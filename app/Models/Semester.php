<?php

namespace App\Models;


use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Semester extends Model
{
    use SoftDeletes;

    protected $table = 'semester';

    protected $fillable = ['id', 'nama', 'status', 'deleted_by', 'is_deleted'];
}
