<?php

namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupKategoriMaklumat extends Model
{
    use HasFactory;
    protected $table = 'lookup_kategori_maklumat';
    protected $guarded = ['id'];

}
