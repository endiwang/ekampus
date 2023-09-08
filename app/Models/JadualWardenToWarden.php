<?php

namespace App\Models;

use App\Models\Base as Model;

class JadualWardenToWarden extends Model
{
    protected $table = 'jadual_warden_to_warden';

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }

    public function jadual()
    {
        return $this->belongsTo(JadualWarden::class, 'jadual_warden_id', 'id');
    }

}
