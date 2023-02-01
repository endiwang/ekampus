<?php

namespace App\Models\OldDatabase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sis_tblpermohonan extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = '_sis_tblpermohonan';
    protected $guarded = ['mohon_id'];
    public $timestamps = false;


    public function penjaga(){
        return $this->hasMany('App\Models\OldDatabase\sis_tblpermohonan_penjaga','mohon_id','mohon_id');
    }

    public function tanggunagn_penjaga(){
        return $this->hasMany('App\Models\OldDatabase\sis_tblpermohonan_tanggung','mohon_id','mohon_id');
    }

    public function pelajaran(){
        return $this->hasMany('App\Models\OldDatabase\sis_tblpermohonan_pelajaran','mohon_id','mohon_id');
    }

    public function kesihatan(){
        return $this->hasMany('App\Models\OldDatabase\sis_tblpermohonan_kesihatan','fldmohon_id','mohon_id');
    }

}
