<?php
declare(strict_types=1);

namespace App\DTOs;

use Illuminate\Support\Collection;

readonly class UserProfileDTO
{
    private function __construct(
        public int $userId,
        public Collection $locations,
        public Collection $categories,
        public Collection $artists,
        public Collection $genres
    ) {}

    public static function create(int $userId, Collection $locations, Collection $categories, Collection $artists, Collection $genres): self
    {
        return new self($userId, $locations, $categories, $artists, $genres);
    }

    public static function createExample(int $userId): self
    {
        $locations = new Collection([
            'Manchester' => 5000,
            'Blackburn' => 1000,
            'Preston' => 250,
        ]);
        $categories = new Collection([
            'Live Music Gig' => ['id' => 'LIVE', 'score' => 6000],
            'Comedy' => ['id' => 'COMEDY', 'score' => 250],
        ]);
        $artists = new Collection([
            'Linkin Park' => ['id' => 703831, 'score' => 1200],
            'Freqgen' => ['id' => 0, 'score' => 500],
            'Ghost' => ['id' => 123540755, 'score' => 300],
            'Electric Callboy' => ['id' => 123585861, 'score' => 200],
            'Lake Malice' => ['id' => 123577856, 'score' => 200],
            'Fleetwood Mac' => ['id' => 123510708, 'score' => 100],
            'Don Broco' => ['id' => 123522510, 'score' => 100],
            'DJ Shadow' => ['id' => 123456923, 'score' => 100],
            'Highly Suspect' => ['id' => 123571989, 'score' => 100],
            'Bicep' => ['id' => 123504694, 'score' => 100],
        ]);
        $genres = new Collection([
            'Metal' => ['id' => 27, 'score' => 600],
            'Rock' => ['id' => 5, 'score' => 500],
            'Alternative' => ['id' => 46, 'score' => 300],
            'EDM' => ['id' => 79, 'score' => 200],
            'Experimental' => ['id' => 91, 'score' => 150],
        ]);

        return new self($userId, $locations, $categories, $artists, $genres);
    }
}
