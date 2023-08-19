<?php

namespace App\Models;

use App\Models\Base as Model;

class AduanSalahlakuPelajar extends Model
{
    protected $table = 'aduan_salahlaku_pelajar';

    protected $guarded = ['id'];

    public function pengadu()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
