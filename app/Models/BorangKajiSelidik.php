<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BorangKajiSelidik extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'borang_kaji_selidik';
    protected $guarded = ['id'];


    public function getFormArray()
    {
        return json_decode($this->json);
    }
}
