<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AduanPenyelenggaraanDetail extends Model
{
    use HasFactory;
    
    protected $table = 'aduan_penyelenggaraan_detail';
    protected $guarded = ['id'];
}
