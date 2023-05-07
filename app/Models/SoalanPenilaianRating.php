<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalanPenilaianRating extends Model
{
    use HasFactory;
    protected $table = 'soalan_penilaian_rating';
    protected $guarded = ['id'];
}
