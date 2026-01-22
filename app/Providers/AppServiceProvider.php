<?php

namespace App\Providers;

use App\Domain\Lead\Events\LeadCreated;
use App\Domain\Lead\Listeners\TriggerIntegrations;
use Illuminate\Support\Facades\Event;
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
        if (app()->isProduction()) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        app()->setLocale('ar');

        Event::listen(
            LeadCreated::class,
            TriggerIntegrations::class
        );
    }
}
