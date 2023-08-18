<?php

namespace App\Models\Kualiti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muadalah extends Model
{
    use HasFactory;

    protected $table = 'muadalah';

    protected $guarded = ['id'];

    public function uploadby()
    {
        return $this->belongsTo('App\Models\User', 'upload_by', 'id');
    }
}
