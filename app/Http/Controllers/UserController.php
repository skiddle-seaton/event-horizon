<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\Services\ProfileSummaryService;
use App\Transformers\ProfileTransformer;

class UserController extends Controller
{
    public function show(ProfileSummaryService $summaryService, ProfileService $profileService, ProfileTransformer $transformer, int $userId)
    {
        $profile = $profileService->getProfile($transformer, $userId);
        $summary = $summaryService->generate($userId, $profile);

        return view('users.show', [
            'userId' => $userId,
            'summary' => $summary,
            'profile' => $profile
        ]);
    }
}
