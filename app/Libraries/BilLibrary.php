<?php

namespace App\Libraries;

use App\Events\BilYuranEvent;
use App\Models\Bil;
use App\Models\BilDetail;
use App\Models\YuranDetail;

class BilLibrary {

    public static function createBil($data, $is_pelajar = true, $is_pemohon = false)
    {
        if(!empty($data['yuran']))
        {
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
            $bil->status = 1;
            if($bil->save())
            {
                $amaun_total = 0;
                if(!empty($data['manual_bil']) && !empty($data['nama_yuran']) && !empty($data['amaun']))
                {
                    foreach($data['nama_yuran'] as $key => $nama_yuran)
                    {
                        $bil_detail = new BilDetail;
                        $bil_detail->bil_id = $bil->id;
                        $bil_detail->yuran_id = $bil->yuran_id;
                        $bil_detail->description = $nama_yuran;
                        $bil_detail->amaun = $data['amaun'][$key];
                        $bil_detail->save();

                        $amaun_total += $bil_detail->amaun;

                    }
                }
                else {
                    $yuran_detail = YuranDetail::where('yuran_id', $data['yuran']->id);
                    exit;
                }

                $bil->amaun = $amaun_total;
                $bil->save();

            }

            event(new BilYuranEvent($bil));
        }
        
    }
}
