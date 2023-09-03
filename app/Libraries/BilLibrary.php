<?php

namespace App\Libraries;

use App\Events\BilYuranEvent;
use App\Models\Bil;


class BilLibrary {

    public static function createBil($data, $is_pelajar = true, $is_pemohon = false)
    {
        if (! empty($data['yuran'])) {
            $count_bil = Bil::count();
            $no_bil = sprintf('%04d', $count_bil + 1);

            $bil = new Bil;

            $bil->doc_no = 'INV' . $no_bil;
            if($is_pelajar)
            {
                $bil->pelajar_id = $data['pelajar_id'];
            }
            if($is_pemohon)
            {
                $bil->pemohon_id = $data['pemohon_id'];
            }

            $bil->yuran_id = $data['yuran']->id;
            $bil->description = $data['yuran']->nama;
            $bil->amaun = (! empty($data['amaun'])) ? $data['amaun'] : $data['yuran']->amaun;
            $bil->status = 1;
            $bil->save();

            event(new BilYuranEvent($bil));
        }

    }
}
