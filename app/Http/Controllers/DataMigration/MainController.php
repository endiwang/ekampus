<?php

namespace App\Http\Controllers\DataMigration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//New DB
use App\Models\User;
use App\Models\Kursus;
use App\Models\Syukbah;
use App\Models\Kelas;

//Old DB
use App\Models\OldDatabase\sis_tblpelajar;
use App\Models\OldDatabase\ref_kursus;
use App\Models\OldDatabase\ref_syukbah;
use App\Models\OldDatabase\ref_kelas;

class MainController extends Controller
{
    public function sis_tblpelajar_to_user_table()
    {
        // Create user for student from old database table _sis_tblpelajar to table user

        // is_alumni = 1 (alumni) -> is_berhenti wajib = 1;
        // kod_berhenti = 1 = Tamat Belajar
        // Ada 2 orang alumni tapi is_berhenti = 0 maksudnya masih belajar

        // $student = sis_tblpelajar::get();
        // $student_masih_belajar = sis_tblpelajar::where('is_deleted',0)->where('is_berhenti',0)->where('is_alumni',0)->get();
        // $student_berhenti = sis_tblpelajar::where('is_deleted',0)->where('is_berhenti',1)->where('is_alumni',0)->get();
        // $student_alumni = sis_tblpelajar::where('is_deleted',0)->where('is_berhenti',1)->where('is_alumni',1)->get();
        // $student_deleted = sis_tblpelajar::where('is_deleted',1)->get();

        // $student_alumni_tapi_masih_belajar = sis_tblpelajar::where('is_deleted',0)->where('is_berhenti',0)->where('is_alumni',1)->get();

        // dd($student_alumni_tapi_masih_belajar);


        // dump('Alumni');
        // dump($student_alumni);


        // dump('Berhenti');
        // dump($student_berhenti);

        // dump('Masih Belajar');
        // dump($student_masih_belajar);


        // dump('Deleted');
        // dump($student_deleted);


        // dump('Semua by query');
        // dump($student_alumni + $student_berhenti + $student_masih_belajar + $student_deleted);

        // dump('Semua');
        // dd($student);

        // Duplicate ic no = 960606016399 , 980310036145

        $student_masih_belajar = sis_tblpelajar::select('p_nokp')->whereNotNull('p_nokp')->distinct()->get();

        //passowrd = 123
        $password_hash = '$2y$10$DYl/XAwUYLdFk4BDUD0lkO12yxz0ZO.YpwySx0ZV9.OBVF2o/vi2y';

        foreach($student_masih_belajar as $datum)
        {
            User::create([
                'username' => $datum->p_nokp,
                'password' => $password_hash
            ]);
        }
        dd('done');
    }

    public function ref_kursus_to_kursus_table ()
    {
        $ref_kursus = ref_kursus::all();

        foreach($ref_kursus as $datum)
        {
            if($datum->kursus_prn == null)
            {
                $nama = $datum->kursus;
            }else{
                $nama = $datum->kursus_prn;
            }
            Kursus::create([
                'id' => $datum->kid,
                'kod' => $datum->kod_kursus,
                'nama' => $nama,
                'nama_arab' => $datum->kursus_arab,
                'status' => $datum->kstatus,
                'bil_sem_keseluruhan' => $datum->bil_sem,
                'bil_sem_setahun' => $datum->sem_tahunan,
                'pusat_pengajian_id' => $datum->kursus_pusat_id,
                'is_deleted' => $datum->is_deleted,
                'deleted_at' => $datum->deleted_dt,
                'deleted_by' => $datum->deleted_by,
                'pusat_pengajian_id' => $datum->kursus_pusat_id,
            ]);
        }

        dd('done');

    }

    public function ref_syukbah_to_syukbah_table ()
    {
        $ref_syukbah = ref_syukbah::all();

        foreach($ref_syukbah as $datum)
        {
            Syukbah::create([
                'id' => $datum->ref_sukbah_id,
                'nama' => $datum->ref_sukbah,
                'kuota_pelajar' => $datum->ref_sukbah_num,
                'jumlah_jam_kredit' => $datum->ref_bil_jam,
                'kursus_id' => $datum->kursus_id,
                'status' => $datum->ref_sukbah_status,
            ]);
        }

        dd('done');

    }

    public function ref_kelas_to_kelas_table ()
    {
        $ref_kelas = ref_kelas::all();

        foreach($ref_kelas as $datum)
        {
            Kelas::create([
                'id' => $datum->keid,
                'nama' => $datum->kelas,
                'kapasiti_pelajar' => $datum->kelas_num,
                'semasa_jantina' => $datum->kjantina,
                'semasa_syukbah_id' => $datum->k_syukbah,
                'semasa_semester_id' => $datum->k_semester,
                'jadual_jantina' => $datum->j_jantina,
                'jadual_syukbah_id' => $datum->j_syukbah,
                'jadual_semester_id' => $datum->j_semester,
                'jumlah_pelajar' => $datum->jum_pelajar,
                'sesi' => $datum->sesi,
                'pusat_pengajian_id' => 1,
                'status' => $datum->kestatus,
                'is_deleted' => $datum->is_deleted,
                'deleted_by' => $datum->deleted_by,
                'deleted_at' => $datum->deleted_dt,
            ]);
        }

        dd('done');

    }



    public function find_duplicate()
    {
        $student_masih_belajar = sis_tblpelajar::where('is_deleted',0)->where('is_berhenti',0)->where('is_alumni',0)->get();

        $result = [];
        $num = 0;
        foreach($student_masih_belajar as $datum)
        {
            $temp = sis_tblpelajar::where('p_nokp', $datum->p_nokp)->get()->count();

            if($temp > 1)
            {
                $result[$datum->p_nokp] = [
                    'nokp' => $datum->p_nokp,
                    'dup_no' => $temp
                ];
            }



            // User::create([
            //     'username' => $datum->p_nokp,
            //     'password' => 123
            // ]);

        }

        dump($result);

        dump($num);

        dump($student_masih_belajar->count());

        dd('done');
    }
}
