<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalanPenilaian extends Model
{
    use HasFactory;
    protected $table = 'soalan_penilaian';
    protected $guarded = ['id'];

    public function createdBy()
    {
        return $this->belongsTo(Staff::class, 'created_by','user_id');
    }
}
