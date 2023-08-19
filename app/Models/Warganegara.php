<?php

namespace App\Models;


use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warganegara extends Model
{
    use SoftDeletes;

    protected $table = 'warganegara';

    protected $fillable = ['id', 'nama', 'kod', 'status', 'is_deleted', 'deleted_by'];
}
