<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ELearningSyllabus extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class,'kursus_id','id');
    }

    public function subjek()
    {
        return $this->belongsTo(Subjek::class,'subjek_id','id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
}
