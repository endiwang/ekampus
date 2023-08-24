<?php

namespace App\Libraries;

use App\Models\Bil;

class BilLibrary {

    public static function createBil($data)
    {
        if(!empty($data['yuran']))
        {
            $count_bil = Bil::count();
            $no_bil = sprintf('%04d', $count_bil + 1);

            $bil = new Bil;
            $bil->doc_no = 'INV' . $no_bil;
            $bil->pelajar_id = $data['pelajar_id'];
            $bil->yuran_id = $data['yuran']->id;
            $bil->description = $data['yuran']->nama;
            $bil->amaun = $data['amaun'];
            $bil->status = 1;
            $bil->save();
        }
        
    }
}
