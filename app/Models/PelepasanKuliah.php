<?php

namespace App\Models;

use App\Models\Base as Model;

class PelepasanKuliah extends Model
{
    protected $table = 'pelepasan_kuliah';

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
