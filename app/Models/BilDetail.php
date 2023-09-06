<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BilDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bil_detail';

    protected $guarded = ['id'];
}
