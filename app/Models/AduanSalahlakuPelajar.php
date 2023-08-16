<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AduanSalahlakuPelajar extends Model
{
    use HasFactory;

    protected $table = 'aduan_salahlaku_pelajar';

    protected $guarded = ['id'];

    public function pengadu()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pelaku()
    {
        return $this->belongsTo(Pelajar::class, 'pelaku_pelajar_id', 'id');
    }
}
