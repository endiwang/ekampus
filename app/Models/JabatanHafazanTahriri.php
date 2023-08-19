<?php

namespace App\Models;


use App\Models\Base as Model;

class JabatanHafazanTahriri extends Model
{


    protected $table = 'jabatan_hafazan_tahriri';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }
}
