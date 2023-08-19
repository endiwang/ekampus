<?php

namespace App\Models;


use App\Models\Base as Model;

class Blok extends Model
{


    protected $table = 'blok';

    protected $fillable = ['id', 'nama', 'status', 'jantina', 'is_deleted', 'type'];
}
