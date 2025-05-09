<?php
declare(strict_types=1);

namespace App\DTOs;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

readonly class UserEventsDTO
{
    private function __construct(public Collection $events) {}

    public static function create(array $events): self
    {
        $processedEvents = collect($events)
            ->map(function ($event) {
                $event['startDate'] = Carbon::parse($event['startDate']);
                $event['endDate'] = Carbon::parse($event['endDate']);

                return $event;
            });

        return new self($processedEvents);
    }
}
