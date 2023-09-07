<?php

namespace App\Models\Alumni;

use App\Models\Base as Model;

class PermohonanSijilGanti extends Model
{
    protected $table = 'permohonan_sijil_ganti';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}