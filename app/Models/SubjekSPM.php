<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SubjekSPM extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;
    protected $table = 'subjek_spm';
    protected $fillable = ['id','nama','slug','minimum_gred','order','status','is_deleted','deleted_by'];


}
