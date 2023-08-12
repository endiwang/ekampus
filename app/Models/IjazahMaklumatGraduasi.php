<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IjazahMaklumatGraduasi extends Model
{
    use HasFactory;

    protected $table = 'ijazah_maklumat_graduasi';

    protected $guarded = ['id'];
}
