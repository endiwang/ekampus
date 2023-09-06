<?php

namespace App\Libraries;

use App\Events\BilYuranEvent;
use App\Models\Bil;
use App\Models\BilDetail;
use App\Models\YuranDetail;


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
            $bil->id_hash = md5($bil->id . now());

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
                    $yuran_detail_senarai = YuranDetail::where('yuran_id', $data['yuran']->id)->get();
                    foreach($yuran_detail_senarai as $key => $yuran_detail)
                    {
                        $bil_detail = new BilDetail;
                        $bil_detail->bil_id = $bil->id;
                        $bil_detail->yuran_id = $bil->yuran_id;
                        $bil_detail->description = $yuran_detail->nama;
                        $bil_detail->amaun = $yuran_detail->amaun;
                        $bil_detail->save();

                        $amaun_total += $bil_detail->amaun;

                    }
                }

                $bil->amaun = $amaun_total;
                $bil->save();

            }

            event(new BilYuranEvent($bil));
        }

    }

    public static function createBilPeperikSaan($data)
    {
        if(!empty($data['yuran']) && isset($data['caj_peperiksaan_pengurusan']) && isset($data['caj_peperiksaan_subjek']))
        {
            $count_bil = Bil::count();
            $no_bil = sprintf('%04d', $count_bil + 1);

            $bil = new Bil;
            $bil->doc_no = 'INV' . $no_bil;
            $bil->pelajar_id = $data['pelajar']->pelajar_id;            
            $bil->yuran_id = $data['yuran']->id;
            $bil->description = $data['yuran']->nama;
            $bil->status = 1;

            if($bil->save())
            {
                $amaun_total = 0;

                if(count($data['caj_peperiksaan_pengurusan']) > 0)
                {
                    foreach($data['caj_peperiksaan_pengurusan'] as $caj)
                    {
                        $bil_detail = new BilDetail;
                        $bil_detail->bil_id = $bil->id;
                        $bil_detail->yuran_id = $bil->yuran_id;
                        $bil_detail->description = ucwords(str_replace('_', ' ', $caj->description));
                        $bil_detail->amaun = $caj->jumlah;
                        $bil_detail->save();

                        $amaun_total += $bil_detail->amaun;
                    }
                }

                if(count($data['caj_peperiksaan_subjek']) > 0)
                {
                    foreach($data['caj_peperiksaan_subjek'] as $caj)
                    {
                        $bil_detail = new BilDetail;
                        $bil_detail->bil_id = $bil->id;
                        $bil_detail->yuran_id = $bil->yuran_id;
                        $bil_detail->description = ucwords(str_replace('_', ' ', $caj->description)) . ' - ' . @$caj->subjek->nama;
                        $bil_detail->amaun = $caj->jumlah;
                        $bil_detail->save();

                        $amaun_total += $bil_detail->amaun;
                    }
                }

                $bil->amaun = $amaun_total;
                $bil->save();

            }
        }
        
    }
}
