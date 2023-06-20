<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IjazahKompilasiSoalan extends Model
{
    use HasFactory;
    protected $table = "ijazah_kompilasi_soalan";
    protected $guarded = ['id'];


    public function sesi()
    {
        return $this->belongsTo(Sesi::class,'sesi_id','id');
    }
}
