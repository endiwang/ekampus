<?php

namespace App\Listeners;

use App\Events\BayaranYuranEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Pdf;

class GenerateBayaranYuranResitListener
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
        $bayaran = $event->bayaran;
        $data['bayaran'] = $bayaran;
        $resit = [];
        $datetime_now = strtotime(now());

        $pdf = Pdf::loadView('pages.pengurusan.kewangan.yuran.resit', $data);
        $pdf_name = $bayaran->doc_no . '_' . $datetime_now . '.pdf';
        $pdf_path = 'bayaran/resit/' . $pdf_name;
        $content  = $pdf->download($pdf_name)->getOriginalContent();
        Storage::disk('local')->put('public/' . $pdf_path, $content, 'public');
            
        $resit['resit_name'] = $pdf_name;
        $resit['resit_path'] = $pdf_path;
            
        $bayaran->resit = json_encode($resit);
        $bayaran->save();
    }
}
