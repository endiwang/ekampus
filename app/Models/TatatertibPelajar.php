<?php

namespace App\Models;

use App\Models\Base as Model;

class TatatertibPelajar extends Model
{
    protected $table = 'tatatertib_pelajar';
    protected $guarded = ['id'];

    public function aduan()
    {
        return $this->hasOne(AduanSalahlakuPelajar::class,'id','aduan_salahlaku_pelajar_id');
    }

    public function siasatan()
    {
        return $this->hasOne(SiasatanAduanSalahlakuPelajar::class,'id','siasatan_aduan_salahlaku_pelajar_id');
    }

    public function pelaku()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }

    public function rayuan()
    {
        return $this->hasOne(RayuanTatatertibPelajar::class, 'id', 'tatatertib_pelajar_id');
    }
}
