<?php

namespace App\Models;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Konvo extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'konvo';

    protected $guarded = ['id'];

    public function konvo_pelajar()
    {
        return $this->hasMany(KonvoPelajar::class);
    }
}
