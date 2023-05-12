<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMesyuaratDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function uploadedBy()
    {
        return $this->belongsTo(User::class,'uploaded_by','id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class,'uploaded_by','user_id');
    }
}
