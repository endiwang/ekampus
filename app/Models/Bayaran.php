<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bayaran extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bayaran';

    protected $guarded = ['id'];

    public function bil()
    {
        return $this->belongsTo(Bil::class);
    }

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class);
    }
}
