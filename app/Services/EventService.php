<?php
declare(strict_types=1);

namespace App\Services;

use App\DTOs\UserProfileDTO;
use App\DTOs\UserEventsDTO;
use App\Models\Postcode;
use Illuminate\Support\Facades\Http;
use RuntimeException;

readonly class EventService
{
    public function __construct(private string $hostname, private string $key) {}

    public function getUserEvents(UserProfileDTO $profile): UserEventsDTO
    {
        $location = Postcode::select('latitude', 'longitude')
            ->where('city', $profile->locations->keys()->first())
            ->first();

        $payload = array_filter([
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'radius' => 20,
            'genreIds' => implode(',', $profile->genres->take(5)->pluck('id')->toArray()),
            'minDate' => now()->format('Y-m-d'),
            'maxDate' => now()->addWeeks(4)->format('Y-m-d'),
            'ticketsAvailable' => 1,
            'imageFilter' => 1,
            'page' => [
                'size' => 50,
            ],
            'order' => 'trendingdistance',
            'hideCancelled' => 1,
            'pubKey' => $this->key,
            'description' => 1,
            'artistMeta' => 1,
        ]);

        $response = Http::get($this->hostname . '/v3/events/instant-search', $payload);

        if (!$response->successful()) {
            throw new RuntimeException("Failed to fetch recommended events");
        }

        return UserEventsDTO::create(
            $response->json('data')
        );
    }

}
