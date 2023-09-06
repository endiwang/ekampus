<?php

namespace App\Providers;

use App\Events\BayaranYuranEvent;
use App\Events\BilYuranEvent;
use App\Events\QuizMarkEvent;
use App\Listeners\CalculateTotalQuizMarkListener;
use App\Listeners\GenerateBayaranYuranResitListener;
use App\Listeners\GenerateBilYuranInvoiceListener;
use App\Listeners\GenerateBilYuranInvoisListener;
use App\Listeners\SendBayaranYuranNotificationListener;
use App\Listeners\SendBilYuranNotificationListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        BayaranYuranEvent::class => [
            GenerateBayaranYuranResitListener::class,
            SendBayaranYuranNotificationListener::class,
        ],
        BilYuranEvent::class => [
            // GenerateBilYuranInvoisListener::class,
            SendBilYuranNotificationListener::class,
        ],
        QuizMarkEvent::class => [
            CalculateTotalQuizMarkListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
