<?php
declare(strict_types=1);

namespace App\Services;

use App\DTOs\UserProfileDTO;
use App\Transformers\ProfileTransformer;
use Illuminate\Support\Facades\Http;

readonly class ProfileService
{
    public const MY_USER_ID = 7803665;

    public function __construct(private ProfileTransformer $transformer, private string $hostname, private string $username, private string $password) {
    }

    public function getProfile(int $userId): UserProfileDTO
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

        // Hax!
        if ($userId === static::MY_USER_ID) {
            return UserProfileDTO::createExample(static::MY_USER_ID);
        }

        return UserProfileDTO::create(
            $userId,
            $this->transformer->locations($profiles),
            $this->transformer->categories($profiles),
            $this->transformer->artists($profiles),
            $this->transformer->genres($profiles),
        );
    }
}
