<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blok extends Model
{
    use HasFactory;
    protected $table = 'blok';
    protected $fillable = ['id','nama','status','jantina','is_deleted','type'];
}
