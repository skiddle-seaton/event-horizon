<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\EventService;
use App\Services\ProfileService;
use App\Services\RecommendationService;
use Illuminate\Support\Collection;

class UserRecommendationController extends Controller
{
    public function show(ProfileService $profileService, EventService $eventService, RecommendationService $recommendationService, int $userId)
    {
        $profile = $profileService->getProfile($userId);
        $userEvents = $eventService->getUserEvents($profile);
        $events = $userEvents->events->keyBy('id');

        $recommendedEventIds = $recommendationService->generate($profile, $userEvents);
        $recommendedEvents = new Collection();

        foreach ($recommendedEventIds as $recommendedEvent) {
            if ($events->has($recommendedEvent['id'])) {
                $reason = $recommendedEvent['reason'];
                $matchingEvent = $events[$recommendedEvent['id']];

                $recommendedEvents->push([...$matchingEvent, 'reason' => $reason]);
            }
        }

        return view('user-recommendations.show', [
            'profile' => $profile,
            'events' => $recommendedEvents,
        ]);
    }
}
