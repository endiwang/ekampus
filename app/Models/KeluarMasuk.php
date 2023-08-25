<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluarMasuk extends Model
{
    use HasFactory;

    protected $table = 'keluar_masuk';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->hasOne(Pelajar::class, 'id', 'pelajar_id');
    }
}
