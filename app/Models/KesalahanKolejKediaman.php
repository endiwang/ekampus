<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KesalahanKolejKediaman extends Model
{
    use HasFactory;
    protected $table = 'kesalahan_kolej_kediaman';
    protected $guarded = ['id'];
}
