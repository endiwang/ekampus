<?php

namespace App\Models;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SesiPeperiksaan extends Model
{
    use SoftDeletes;

    protected $table = 'sesi_peperiksaan';

    protected $guarded = ['id'];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'kursus_id', 'id');
    }
}
