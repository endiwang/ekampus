<?php

namespace App\Models;

use App\Models\Base as Model;
use Carbon\Carbon;

class JadualWaktuDetail extends Model
{
    protected $guarded = ['id'];

    public function subjek()
    {
        return $this->belongsTo(Subjek::class, 'subjek_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'staff_id');
    }

    public function getDifferenceAttribute()
    {
        return Carbon::parse($this->masa_akhir)->diffInMinutes($this->masa_mula);
    }
}
