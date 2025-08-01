<?php

namespace App\Providers;

use App\Events\ProbeReadingsReceived;
use Illuminate\Support\Facades\Event;
use App\Listeners\PersistProbeUpdates;
use Illuminate\Support\ServiceProvider;

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
        Event::listen(
            ProbeReadingsReceived::class,
            PersistProbeUpdates::class,
        );
    }
}
