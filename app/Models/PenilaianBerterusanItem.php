<?php

namespace App\Models;

use App\Models\Base as Model;

class PenilaianBerterusanItem extends Model
{
    protected $guarded = ['id'];

    public function components()
    {
        return $this->hasMany(PenilaianBerterusanComponent::class, 'penilaian_berterusan_item_id', 'id');
    }
}
