<?php
declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

readonly class ProfileSummaryService
{
    public function __construct(private string $hostname, private string $token) {}

    public function generate(int $userId, array $profile): string
    {
        $cacheKey = "profile.summary.$userId";

        return cache()->remember($cacheKey, now()->addMinutes(15), function () use ($profile) {
            $response = Http::withToken($this->token)
                ->post($this->hostname . '/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'system', 'content' => $this->systemPrompt()],
                        ['role' => 'user', 'content' => $this->userPrompt($profile)]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 150,
                ]);

            if (!$response->successful()) {
                throw new RuntimeException("Failed to generate user profile");
            }

            return $response->json('choices.0.message.content');
        });
    }

    private function systemPrompt(): string
    {
        return 'You are a friendly assistant that writes concise user-facing summaries of music and event interests based on structured data.';
    }

    private function userPrompt(array $profile): string
    {
        return sprintf("Summarise my interests in 1–2 sentences, suitable for a user interface. Keep the tone friendly and informative. Focus on locations, event types, genres, and a small number of artist highlights. Avoid lists or headings.\n\n" .
            "Locations: %s\n" .
            "Event Types: %s\n" .
            "Genres: %s\n" .
            "Artists: %s\n",
            implode(', ', $profile['locations']->take(3)->keys()->toArray()),
            implode(', ', $profile['categories']->take(3)->keys()->toArray()),
            implode(', ', $profile['genres']->take(3)->keys()->toArray()),
            implode(', ', $profile['artists']->take(10)->keys()->toArray()),
        );
    }
}
