<?php

namespace App\Providers;

use App\Services\EventService;
use App\Services\ProfileService;
use App\Services\ProfileSummaryService;
use App\Services\RecommendationService;
use App\Transformers\ProfileTransformer;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Profiler\Profile;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(ProfileTransformer::class, function () {
            return new ProfileTransformer();
        });

        $this->app->bind(ProfileService::class, function () {
            $hostname = config('elastic.hostname');
            $password = config('elastic.password');
            $username = config('elastic.username');

            return new ProfileService(new ProfileTransformer(), $hostname, $username, $password);
        });

        $this->app->bind(ProfileSummaryService::class, function () {
            $hostname = config('openapi.hostname');
            $token = config('openapi.token');

            return new ProfileSummaryService($hostname, $token);
        });

        $this->app->bind(EventService::class, function () {
            $hostname = config('skiddle.hostname');
            $pubKey = config('skiddle.pub_key');

            return new EventService($hostname, $pubKey);
        });

        $this->app->bind(RecommendationService::class, function () {
            $hostname = config('openapi.hostname');
            $token = config('openapi.token');

            return new RecommendationService($hostname, $token);
        });
    }
}
