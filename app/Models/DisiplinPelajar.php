<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisiplinPelajar extends Model
{
    use HasFactory;

    protected $table = 'disiplin_pelajar';
    protected $guarded = ['id'];

    public function aduan()
    {
        return $this->hasOne(AduanSalahlakuPelajar::class,'id','aduan_salahlaku_pelajar_id');
    }

    public function siasatan()
    {
        return $this->hasOne(SiasatanAduanSalahlakuPelajar::class,'id','siasatan_aduan_salahlaku_pelajar_id');
    }

    public function hukuman()
    {
        return $this->hasOne(HukumanDisiplin::class,'id','hukuman_disiplin_id');
    }

}
