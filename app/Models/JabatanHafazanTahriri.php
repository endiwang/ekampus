<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanHafazanTahriri extends Model
{
    use HasFactory;
    protected $table = 'jabatan_hafazan_tahriri';
    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class,'pelajar_id','id');
    }
}
