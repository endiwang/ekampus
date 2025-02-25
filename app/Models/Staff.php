<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'staff';

    protected $guarded = ['id'];

    public function pusatPengajian()
    {
        return $this->belongsTo(PusatPengajian::class, 'pusat_pengajian_id', 'id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
    }

    public function getNameIcAttribute()
    {
        return ucfirst($this->nama).' - '.ucfirst($this->no_ic);
    }
}
