<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiasatanAduanSalahlakuPelajar extends Model
{
    use HasFactory;
    protected $table = 'siasatan_aduan_salahlaku_pelajar';
    protected $guarded = ['id'];

    public function aduan()
    {
        return $this->hasOne(AduanSalahlakuPelajar::class,'id','aduan_salahlaku_pelajar_id');
    }
}
