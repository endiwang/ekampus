<?php

namespace App\Models;


use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    use SoftDeletes;

    protected $table = 'jabatan';

    protected $fillable = ['id', 'nama', 'status', 'is_deleted', 'deleted_by'];
}
