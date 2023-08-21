<?php

namespace App\Models;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Syukbah extends Model
{
    use SoftDeletes;

    protected $table = 'syukbah';

    protected $fillable = ['id', 'nama', 'kuota_pelajar', 'jumlah_jam_kredit', 'kursus_id', 'status'];
}
