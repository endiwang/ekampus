<?php

namespace App\Listeners;

use App\Events\BayaranYuranEvent;
use App\Mail\BayaranYuranMail;
use Illuminate\Support\Facades\Mail;

class SendBayaranYuranNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(BayaranYuranEvent $event)
    {
        $pelajar = $event->bil->pelajar;
        if (! empty($pelajar) && ! empty($pelajar->email)) {
            Mail::to($pelajar->email)->send(new BayaranYuranMail($event->bil, $event->bayaran));
        }
    }
}
