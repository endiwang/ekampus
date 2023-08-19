<?php

namespace App\Models;

use App\Models\Base as Model;

class KehadiranPensyarah extends Model
{
    protected $table = 'kehadiran_pensyarah';

    protected $guarded = ['id'];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }
}
