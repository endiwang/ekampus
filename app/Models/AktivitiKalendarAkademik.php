<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitiKalendarAkademik extends Model
{
    use HasFactory;

    protected $table = "aktiviti_kalendar_akademik";
    protected $guarded = ['id'];
}
