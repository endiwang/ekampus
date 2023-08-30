<?php

namespace App\Models\Pentadbiran;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RunningNo extends Model
{
    use HasFactory;

    protected $table = 'running_no';

    protected $guarded = ['id'];
}
