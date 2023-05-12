<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KehadiranPensyarah extends Model
{
    use HasFactory;

    protected $table = "kehadiran_pensyarah";
    protected $guarded = ['id'];

    public function staff()
    {
        return $this->belongsTo(Staff::class,'staff_id','id');
    } 
}
