<?php

namespace App\Models;


use App\Models\Base as Model;

class SebabBerhenti extends Model
{


    protected $table = 'sebab_berhenti';

    protected $fillable = ['id', 'berhenti', 'status'];
    // protected $guarded = ['id'];
}
