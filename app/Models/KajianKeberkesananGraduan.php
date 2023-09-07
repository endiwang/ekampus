<?php

namespace App\Models;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KajianKeberkesananGraduan extends Model
{
    use SoftDeletes;

    protected $table = 'kajian_keberkesanan_graduan';

    protected $guarded = ['id'];

    public function getFormArray()
    {
        return json_decode($this->json);
    }
}