<?php

namespace App\Listeners;

use App\Constants\Generic;
use App\Events\BayaranYuranEvent;
use App\Mail\BayaranYuranMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
     * @param  \App\Events\BayaranYuranEvent  $event
     * @return void
     */
    public function handle(BayaranYuranEvent $event)
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
            Mail::to($pelajar->email)->send(new BayaranYuranMail($event->bil, $event->bayaran));
        }
    }
}
