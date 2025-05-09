<?php
declare(strict_types=1);

namespace App\Services;

use App\DTOs\UserProfileDTO;
use App\DTOs\UserEventsDTO;
use Illuminate\Support\Facades\Http;
use Str;

readonly class RecommendationService
{
    public function __construct(private string $hostname, private string $token) {}

    public function generate(UserProfileDTO $profile, UserEventsDTO $events): array
    {
        $cacheKey = "profile.recommendations." . $profile->userId;

        return cache()->remember($cacheKey, now()->addMinutes(5), function () use ($profile, $events) {
            $response = Http::withToken($this->token)
                ->post($this->hostname . '/v1/chat/completions', [
                    'model' => 'gpt-4o',
                    'messages' => [
                        ['role' => 'system', 'content' => $this->systemPrompt()],
                        ['role' => 'user', 'content' => $this->userPrompt($profile, $events)]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 300,
                ]);

            if (!$response->successful()) {
                throw new RuntimeException("Failed to recommend events");
            }

            $content = $response->json('choices.0.message.content');
            $content = str_replace(["```json", "```"], "", $content); // OpenAI sometimes sends it as markdown!
            $content = stripcslashes($content);

            return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        });
    }

    private function systemPrompt(): string
    {
        return "You are a recommendation engine.

Pick the 8 most relevant events for me based on my favorite artists, preferred genres, and event types.

Use the event description to infer genre or format if needed. Prioritize artist matches, then genre and event type.

Return a **valid JSON array** of exactly 8 items. Each item must include:
- id
- reason (10–15 words max)

Output only the array. No markdown.";
    }

    private function userPrompt(UserProfileDTO $profile, UserEventsDTO $events): string
    {
        $profileJson = json_encode([
            "topArtists" => $profile->artists->keys()->toArray(),
            "preferredGenres" => $profile->genres->keys()->take(3)->toArray(),
            "preferredEventTypes" => $profile->categories->keys()->take(2)->toArray(),
        ], JSON_THROW_ON_ERROR);

        $processedEvents = $events->events->take(10)->map(function ($event) {
            return [
                "id" => $event['id'],
                "type" => $event['eventCode'],
                "name" => $event['eventName'],
                "description" => Str::words($event['description'], 30, '...'),
                "artists" => collect($event['artists'])->pluck('name')->toArray(),
            ];
        });

        $eventsJson = json_encode($processedEvents, JSON_THROW_ON_ERROR);

        return "User:
$profileJson

Events:
$eventsJson";
    }


}
