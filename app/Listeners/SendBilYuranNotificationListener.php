<?php

namespace App\Listeners;

use App\Constants\Generic;
use App\Events\BilYuranEvent;
use App\Mail\BilYuranMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendBilYuranNotificationListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(BilYuranEvent $event)
    {
        if($event->bil->yuran_id == Generic::YURAN_SIJIL_TAHFIZ)
        {
            $pelajar = $event->bil->pemohon;
        }
        else {
            $pelajar = $event->bil->pelajar;
        }
        
        if(!empty($pelajar) && !empty($pelajar->email))
        {
            Mail::to($pelajar->email)->send(new BilYuranMail($event->bil));
        }
    }
}
