<?php

namespace App\Models;


use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PusatTemuduga extends Model
{
    use SoftDeletes;

    protected $table = 'pusat_temuduga';

    protected $guarded = ['id'];
}
