<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ZonNegeri extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'zon_id',
        'name',
        'status',
        'deleted_by',
    ];
    protected $guarded = ['id'];
}
