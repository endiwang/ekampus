<?php

namespace App\Models;


use App\Models\Base as Model;

class LaporanMesyuaratDetail extends Model
{


    protected $guarded = ['id'];

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'uploaded_by', 'user_id');
    }
}
