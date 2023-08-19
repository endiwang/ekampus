<?php

namespace App\Models;


use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjekSPM extends Model
{

    use SoftDeletes;

    protected $table = 'subjek_spm';

    protected $fillable = ['id', 'nama', 'slug', 'minimum_gred', 'order', 'status', 'is_deleted', 'deleted_by'];
}
