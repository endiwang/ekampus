<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadualPensyarahDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function subjek()
    {
        return $this->belongsTo(Subjek::class, 'subjek_id', 'id');
    }
}
