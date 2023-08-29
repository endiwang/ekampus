<?php

namespace App\Models\Kualiti;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KursusDanLatihanPensyarah extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'kursus_dan_latihan_pensyarah';

    protected $guarded = ['id'];

    public function deletedby()
    {
        return $this->belongsTo('App\Models\User', 'deleted_by', 'id');

    }
}
