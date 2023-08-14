<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IjazahProfilPensyarah extends Model
{
    use HasFactory;

    protected $table = 'ijazah_profil_pensyarah';

    protected $guarded = ['id'];
}
