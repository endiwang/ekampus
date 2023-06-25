<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanMurajaahHarian extends Model
{
    use HasFactory;
    protected $table = 'jabatan_murajaah_harian';
    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class,'pelajar_id','id');
    }
}
