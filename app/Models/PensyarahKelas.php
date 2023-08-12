<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PensyarahKelas extends Model
{
    use HasFactory;

    protected $table = 'pensyarah_kelas';

    protected $guarded = ['id'];

    public function subjek()
    {
        return $this->belongsTo(Subjek::class, 'subjek_id', 'id');
    }
}
