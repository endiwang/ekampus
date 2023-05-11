<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitiPdp extends Model
{
    use HasFactory;
    protected $table = 'aktiviti_pdp';
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id','id');
    }

    public function subjek()
    {
        return $this->belongsTo(Subjek::class,'subjek_id','id');
    }
}
