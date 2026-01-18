<?php

namespace App\Providers;
use Illuminate\Support\Facades\Event;
use App\Domain\Lead\Events\LeadCreated;
use App\Domain\Lead\Listeners\TriggerIntegrations;
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
            LeadCreated::class,
            TriggerIntegrations::class
        );
    }
}
