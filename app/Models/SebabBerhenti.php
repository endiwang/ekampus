<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SebabBerhenti extends Model
{
    use HasFactory;
    protected $table = 'sebab_berhenti';
    protected $guarded = ['id'];
}
