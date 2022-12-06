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
use App\Models\OldDatabase\sis_tblstaff;
use App\Models\Pelajar;
use Carbon\Carbon;
use App\Models\Staff;

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
        dd('sinin');
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

    public function sis_tblpelajar_to_pelajar_table()
    {
        $sis_tblpelajar = sis_tblpelajar::all();
        // $pelajar = Pelajar::all();
        foreach($sis_tblpelajar as $datum)
        {
            if($datum->p_nokp != NULL)
            {


            $temp = User::where('username', $datum->p_nokp)->first();

            if($datum->p_tkh_lahir = '0000-00-00')
            {
                $tarikh_lahir = NULL;
            }else{
                $tarikh_lahir = Carbon::parse($datum->p_tkh_lahir)->toDateString();
            }

            if($datum->tarikh_daftar = '0000-00-00')
            {
                $tarikh_daftar = NULL;
            }else{
                $tarikh_daftar = Carbon::parse($datum->tarikh_daftar)->toDateString();
            }

            Pelajar::create([
                'user_id' => $temp->id,
                'pelajar_id_old' => $datum->pelajar_id,
                'mohon_id_old' => $datum->mohon_id,
                'kursus_id' => $datum->kursus_id,
                'syukbah_id' => $datum->syukbah_id,
                'kelas_id' => $datum->kelas_id,
                'no_metrik' => $datum->no_metrik,
                'sesi_id' => $datum->sesi_id,
                'semester' => $datum->semester,
                'pusat_pengajian_id' => $datum->pusat_id,
                'nama' => $datum->p_nama,
                'email' => $datum->p_email,
                'alamat' => $datum->p_alamat1,
                'poskod' => $datum->p_poskod,
                'bandar' => $datum->p_bandar,
                'daerah_id' => $datum->p_daerah_id,
                'negeri_id' => $datum->p_daerah_id,
                'no_tel' => $datum->p_notel,
                'no_hp' => $datum->p_nohp,
                'jantina' => $datum->p_jantina,
                'tarikh_lahir' => $tarikh_lahir,
                'umur_ketika_mendaftar' => $datum->p_umur,
                'keturunan_id' => $datum->p_keturunan_id,
                'negeri_kelahiran_id' => $datum->p_nkelahiran,
                'nama_sekolah' => $datum->pk_nama_sekolah,
                'tahun_peperiksaan' => $datum->pk_periksa,
                'jumlah_matapelajaran' => $datum->pk_matapelajaran,
                // 'gred_percubaan_spm_bm' => $datum->ppc_bm,
                // 'gred_percubaan_spm_ba' => $datum->ppc_ba,
                // 'gred_percubaan_spm_bi' => $datum->ppc_bi,
                'gred_sebenar_bm' => $datum->pk_bm,
                'gred_sebenar_bi' => $datum->pk_bi,
                'gred_sebenar_pi' => $datum->pk_pi,
                'gred_sebenar_aqs' => $datum->pk_aqs,
                'gred_sebenar_psi' => $datum->pk_bpsi,
                'gred_sebenar_art' => $datum->pk_art,
                'gred_sebenar_ark' => $datum->pk_ark,
                'gred_sebenar_fizik' => $datum->pk_fizik,
                'gred_sebenar_kimia' => $datum->pk_kimia,
                'gred_sebenar_biologi' => $datum->pk_biologi,
                'gred_sebenar_math' => $datum->pk_math,
                'gred_sebenar_math_tambahan' => $datum->pk_math_tambahan,
                'gred_sebenar_akaun' => $datum->pk_akaun,
                'sijil_setaraf' => $datum->pk_setaraf,
                'tahun_sijil_setaraf' => $datum->pk_sthn,
                'nama_sijil_setaraf' => $datum->pk_snama,
                'tahun_stpm' => $datum->pk_stpm_thn,
                'tahun_stam' => $datum->pk_sagama_thn,
                'nama_tilawah' => $datum->pa_tilawah,
                'cita_cita' => $datum->pa_citacita,
                'sebab_memohon' => $datum->pa_sebab,
                'kursus_dihadiri' => $datum->pa_kursus,
                'kokurikulum_sekolah' => $datum->pa_koku,
                'status' => $datum->pa_status,
                'img_pelajar' => $datum->img_pelajar,
                'is_deleted' => $datum->is_deleted,
                'deleted_by' => $datum->deleted_by,
                'p_gred' => $datum->p_gred,
                'p_gred_lain' => $datum->p_gred_lain,
                'p_gred_bm' => $datum->p_gred_bm,
                'p_gred_ba' => $datum->p_gred_ba,
                'is_register' => $datum->is_register,
                'gred_akhir' => $datum->gred_akhir,
                'mata_akhir' => $datum->mata_akhir,
                'kedudukan_result' => $datum->kedudukan_result,
                'tarikh_daftar' => $tarikh_daftar,
                'is_berhenti' => $datum->is_berhenti,
                'sebab_berhenti' => $datum->sebab_berhenti,
                'kod_berhenti' => $datum->kod_berhenti,
                'is_calc' => $datum->is_calc,
                'is_migrate' => $datum->is_migrate,
                'is_gantung' => $datum->is_gantung,
                'next_sem' => $datum->next_sem,
                'jam_kredit' => $datum->j_kredit,
                'jumlah_jam_kredit' => $datum->jumj_kredit,
                'is_tamat' => $datum->is_tamat,
                'is_alumni' => $datum->is_alumni,
                'nama_arab' => $datum->nama_arab,
                'hafazan' => $datum->hafazan,
            ]);
            }
        }

        dd("done");


    }

    public function sis_tblstaff_to_user_table()
    {
        $sis_tblstaff = sis_tblstaff::select('flduser_name','fld_kp')->distinct()->get();

        $password_hash = '$2y$10$DYl/XAwUYLdFk4BDUD0lkO12yxz0ZO.YpwySx0ZV9.OBVF2o/vi2y';
        $null_var = 0;
        $not_null_var = 0;
        foreach($sis_tblstaff as $datum)
        {
            if($datum->flduser_name != NULL)
            {
                $user = User::where('username', $datum->flduser_name)->first();
                $username = $datum->flduser_name;

            }else{
                $user = User::where('username', $datum->fld_kp)->first();
                $username = $datum->fld_kp;

            }
            // dd($user);

            if($user == null)
            {
                // dump('Null');
                ++$null_var;
                User::create([
                    'username' => $username,
                    'password' => $password_hash,
                    'is_staff' => 1,
                ]);
            }else{
                // dump('Not Null');
                ++$not_null_var;
                $user->is_staff = 1;
                $user->is_alumni = 1;
                $user->save();
            }
        }
        dump($null_var);
        dump($not_null_var);
        dd('done');

    }

    public function sis_tblstaff_to_staff_table()
    {
        $sis_tblstaff = sis_tblstaff::all();

        foreach($sis_tblstaff as $datum)
        {

            if($datum->fld_bdate = '0000-00-00')
            {
                $tarikh_lahir = NULL;
            }else{
                $tarikh_lahir = Carbon::parse($datum->fld_bdate)->toDateString();
            }

            if($datum->flduser_name != NULL)
            {
                $user = User::where('username', $datum->flduser_name)->first();

            }else{
                $user = User::where('username', $datum->fld_kp)->first();
            }
            
            Staff::create([
                'user_id' => $user->id,
                'staff_id'  => $datum->staff_id,
                'name' => $datum->fld_staff,
                'pusat_pengajian_id' => $datum->fldpusat,
                'jawatan' => $datum->fld_jawatan,
                'gred' => $datum->gred,
                'no_ic' => $datum->fld_kp,
                'tarikh_lahir' => $tarikh_lahir,
                'jantina' => $datum->fld_jantina,
                'warganegara' => $datum->fld_warganegara,
                'status' => $datum->fld_status,
                'alamat' => $datum->fld_alamat,
                'no_tel' => $datum->fld_tel,
                'email' => $datum->fld_email,
                'img_staff' => $datum->fld_image,
                'is_pensyarah' => $datum->is_pensyarah,
                'is_warden' => $datum->is_warden,
                'jabatan_id' => $datum->jabatan_id,
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
