<?php

namespace App\Models;

use App\Models\Base as Model;

class JabatanHafazanShafawi extends Model
{
    protected $table = 'jabatan_hafazan_shafawi';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }
}
