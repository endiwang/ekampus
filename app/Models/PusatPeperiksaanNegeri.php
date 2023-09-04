<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PusatPeperiksaanNegeri extends Model
{
    use HasFactory;

    protected $fillable = [
        'pusat_peperiksaan_id',
        'state_id',
        'created_by',
        'deleted_by',
    ];

    public function negeri()
    {
        return $this->belongsTo(Negeri::class);
    }
}
