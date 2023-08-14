<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
