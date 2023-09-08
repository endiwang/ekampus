<?php

namespace App\Models;

use App\Models\Base as Model;

class PenyelenggaraanAsrama extends Model
{
    protected $table = 'penyelenggaraan_asrama';

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }
}
