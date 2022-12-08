<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PusatPengajian extends Model
{
    use HasFactory;
    protected $table = 'pusat_pengajian';
    protected $fillable = ['id','nama','kod','no','status','deleted_by','is_deleted'];
}
