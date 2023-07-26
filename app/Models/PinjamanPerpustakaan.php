<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinjamanPerpustakaan extends Model
{
    use HasFactory;

    protected $table = "perpustakaan_pinjaman";
    protected $guarded = ['id'];

    public function bahan()
    {
        return $this->belongsTo(BahanPerpustakaan::class,'bahan_id','id');
    }
}
