<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianBerterusanItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function components()
    {
        return $this->hasMany(PenilaianBerterusanComponent::class, 'penilaian_berterusan_item_id', 'id');
    }
}
