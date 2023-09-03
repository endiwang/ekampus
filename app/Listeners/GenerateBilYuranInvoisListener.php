<?php

namespace App\Listeners;

use App\Events\BilYuranEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Pdf;

class GenerateBilYuranInvoisListener
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
        $bil = $event->bil;
        $data['bil'] = $bil;
        $data['is_download'] = 1;
        $invois = [];
        $datetime_now = strtotime(now());

        $pdf = Pdf::loadView('pages.pengurusan.kewangan.yuran.invois', $data);
        $pdf_name = $bil->doc_no . '_' . $datetime_now . '.pdf';
        $pdf_path = 'bil/invois/' . $pdf_name;
        $content  = $pdf->download($pdf_name)->getOriginalContent();
        Storage::disk('local')->put('public/' . $pdf_path, $content, 'public');
            
        $invois['invois_name'] = $pdf_name;
        $invois['invois_path'] = $pdf_path;
            
        $bil->invois = json_encode($invois);
        $bil->save();
    }
}
