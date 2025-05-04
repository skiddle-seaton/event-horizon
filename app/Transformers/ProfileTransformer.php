<?php
declare(strict_types=1);

namespace App\Transformers;

use App\Models\Artist;
use App\Models\EventCode;
use App\Models\Genre;
use Illuminate\Support\Collection;

class ProfileTransformer
{
    public function artists(array $profiles): Collection
    {
        $artistScores = collect($profiles)
            ->flatMap(static fn ($profile) => $profile['_source']['artists'] ?? [])
            ->groupBy('key')
            ->map(static fn ($artistScore) => $artistScore->sum('value'));

        $artists = Artist::select('artistID', 'name')
                ->whereIn('artistID', $artistScores->keys())
                ->get()
                ->keyBy('artistID');

        return $artistScores
            ->mapWithKeys(function ($score, $artistId) use ($artists) {
                $name = $artists[$artistId]->name ?? 'Unknown Artist';

                return [$name => $score];
            })
            ->sortDesc();
    }

    public function locations(array $profiles): Collection
    {
        return collect($profiles)
            ->flatMap(static fn ($profile) => $profile['_source']['locations'] ?? [])
            ->groupBy('key')
            ->filter(static fn ($locationScore, $locationName) => !is_numeric($locationName))
            ->map(static fn ($locationScore) => $locationScore->sum('value'))
            ->sortDesc();
    }

    public function categories(array $profiles): Collection
    {
        $categoryScores = collect($profiles)
            ->flatMap(static fn (array $profile) => $profile['_source']['categories'] ?? [])
            ->groupBy('key')
            ->map(static fn ($categoryScore) => $categoryScore->sum('value'));

        $categories = EventCode::select('EventCode', 'EventCodeDesc')
            ->whereIn('EventCode', $categoryScores->keys())
            ->get()
            ->keyBy('EventCode');

        return $categoryScores
            ->mapWithKeys(function (int $score, string $category) use ($categories): array {
                $description = $categories[$category]->EventCodeDesc ?? 'Unknown Event Code';

                return [$description => $score];
            })
            ->sortDesc();
    }

    public function genres(array $profiles): Collection
    {
        $genreScores = collect($profiles)
            ->flatMap(static fn (array $profile) => $profile['_source']['genres'] ?? [])
            ->groupBy('key')
            ->map(static fn ($genreScore) => $genreScore->sum('value'));

        $genres = Genre::select('GenreId', 'GenreName')
            ->get()
            ->keyBy('GenreId');

        return $genreScores
            ->mapWithKeys(function (int $score, string $genreId) use ($genres): array {
                $name = $genres[$genreId]->GenreName ?? 'Unknown Genre';

                return [$name => $score];
            })
            ->sortDesc();
    }
}
