<?php

namespace App\Models;


use App\Models\Base as Model;

class IjazahNotaKuliah extends Model
{


    protected $table = 'ijazah_nota_kuliah';

    protected $guarded = ['id'];

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id');
    }
}
