<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PusatPeperiksaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'status',
        'created_by',
        'is_deleted',
        'deleted_by',
    ];

    protected $guarded = ['id'];

    public function pusatPeperiksaanNegeri(){
        return $this->hasMany(PusatPeperiksaanNegeri::class);
    }
}
