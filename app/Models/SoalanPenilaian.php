<?php

namespace App\Models;


use App\Models\Base as Model;

class SoalanPenilaian extends Model
{


    protected $table = 'soalan_penilaian';

    protected $guarded = ['id'];

    public function createdBy()
    {
        return $this->belongsTo(Staff::class, 'created_by', 'user_id');
    }
}
