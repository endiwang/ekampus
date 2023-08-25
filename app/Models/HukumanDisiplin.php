<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HukumanDisiplin extends Model
{
    use HasFactory;

    protected $table = 'hukuman_disiplin';

    protected $guarded = ['id'];
}
