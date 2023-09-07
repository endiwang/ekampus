<?php

namespace App\Models;

use App\Models\Base as Model;

class Negeri extends Model
{
    protected $table = 'negeri';

    protected $fillable = ['id', 'nama'];

    public function venuePeperiksaanSijilTahfiz()
    {
        return $this->belongsTo(VenuePeperiksaanSijilTahfiz::class, 'id', 'negeri_id');
    }
}
