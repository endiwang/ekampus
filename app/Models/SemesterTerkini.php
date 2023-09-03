<?php

namespace App\Models;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SemesterTerkini extends Model
{
    use SoftDeletes;

    protected $table = 'semester_terkini';

    protected $guarded = ['id'];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'kursus_id', 'id');
    }

    public function tarikhKeputusan()
    {
        return $this->hasMany(TarikhKeputusan::class);
    }
}
