<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warganegara extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'warganegara';

    protected $fillable = ['id', 'nama', 'kod', 'status', 'is_deleted', 'deleted_by'];
}
