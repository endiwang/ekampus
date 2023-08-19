<?php

namespace App\Models;


use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorangKajiSelidik extends Model
{
    use SoftDeletes;

    protected $table = 'borang_kaji_selidik';

    protected $guarded = ['id'];

    public function getFormArray()
    {
        return json_decode($this->json);
    }
}
