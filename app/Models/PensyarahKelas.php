<?php

namespace App\Models;


use App\Models\Base as Model;

class PensyarahKelas extends Model
{


    protected $table = 'pensyarah_kelas';

    protected $guarded = ['id'];

    public function subjek()
    {
        return $this->belongsTo(Subjek::class, 'subjek_id', 'id');
    }
}
