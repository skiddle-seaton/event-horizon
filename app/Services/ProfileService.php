<?php
declare(strict_types=1);

namespace App\Services;

use App\Transformers\ProfileTransformer;
use Illuminate\Support\Facades\Http;

readonly class ProfileService
{
    public function __construct(private string $hostname, private string $username, private string $password) {
    }

    public function getProfile(ProfileTransformer $transformer, int $userId): array
    {
        // Elastic 5 needs version 5 of the Elastic PHP SDK, but that doesn't run on PHP8.2 - so Http::get() it is
        $response = Http::withBasicAuth($this->username, $this->password)
            ->get($this->hostname . '/profiledata/_search', [
                "q" => "profiles:$userId"
            ]);

        if (!$response->successful()) {
            throw new \RuntimeException("Failed to load user data");
        }

        $profiles = $response->json('hits.hits') ?? [];

        return [
            'locations' => $transformer->locations($profiles),
            'categories' => $transformer->categories($profiles),
            'artists' => $transformer->artists($profiles),
            'genres' => $transformer->genres($profiles),
        ];
    }
}
