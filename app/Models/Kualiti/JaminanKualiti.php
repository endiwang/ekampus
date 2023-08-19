<?php

namespace App\Models\Kualiti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JaminanKualiti extends Model
{
    use HasFactory;

    protected $table = 'jaminan_kualiti';

    protected $guarded = ['id'];

    public function lkpKategoriMaklumat()
    {
        return $this->belongsTo('App\Models\Lookup\LookupKategoriMaklumat', 'lkp_kategori_maklumat', 'id');
        // return $this->belongsTo(Lookup\User::class, 'user_id', 'id');
    }
}
