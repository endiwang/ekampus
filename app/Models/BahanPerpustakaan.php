<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanPerpustakaan extends Model
{
    use HasFactory;

    protected $table = 'perpustakaan_bahan';

    protected $guarded = ['id'];
}
