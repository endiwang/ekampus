<?php

namespace App\Models;

use App\Models\Base as Model;

class PusatPengajian extends Model
{
    protected $table = 'pusat_pengajian';

    protected $fillable = ['id', 'nama', 'kod', 'no', 'status', 'deleted_by', 'is_deleted'];
}
