<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeahlianPerpustakaan extends Model
{
    use HasFactory;

    protected $table = "perpustakaan_keahlian";
    protected $guarded = ['id'];
}
