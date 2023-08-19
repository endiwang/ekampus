<?php

namespace App\Models;


use App\Models\Base as Model;

class Tingkat extends Model
{


    protected $table = 'tingkat';

    protected $fillable = ['id', 'nama', 'status'];
}
