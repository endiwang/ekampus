<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RayuanPermohonan extends Model
{
    use HasFactory;

    protected $table = 'rayuan_permohonan';

    protected $guarded = ['id'];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id', 'id');
    }
}
