<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelajarBerhenti extends Model
{
    use HasFactory;

    protected $table = 'pelajar_berhenti';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }

    public function pelajarOld()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'pelajar_id_old');
    }
}
