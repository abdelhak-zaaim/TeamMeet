<?php

namespace App\Providers;

use App\Events\CreateGoogleEvent;
use App\Events\DeleteEventFromGoogleCalendar;
use App\Listeners\HandleCreatedGoogleEvent;
use App\Listeners\HandleDeletedEventFromGoogleCalendar;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        DeleteEventFromGoogleCalendar::class => [
            HandleDeletedEventFromGoogleCalendar::class,
        ],
        CreateGoogleEvent::class => [
            HandleCreatedGoogleEvent::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
