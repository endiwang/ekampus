<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AduanPenyelenggaraanDetail extends Model
{
    use HasFactory;

    protected $table = 'aduan_penyelenggaraan_detail';

    protected $guarded = ['id'];
}
