<?php

namespace App\Providers;

use App\Services\ProfileService;
use App\Services\ProfileSummaryService;
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
        $this->app->bind(ProfileService::class, function () {
            $hostname = config('elastic.hostname');
            $password = config('elastic.password');
            $username = config('elastic.username');

            return new ProfileService($hostname, $username, $password);
        });

        $this->app->bind(ProfileSummaryService::class, function () {
            $hostname = config('openapi.hostname');
            $token = config('openapi.token');

            return new ProfileSummaryService($hostname, $token);
        });
    }
}
