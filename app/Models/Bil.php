<?php

namespace App\Models;

use App\Constants\Generic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bil extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bil';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class);
    }

    public function pemohon()
    {
        return $this->belongsTo(Pemohon::class);
    }

    public function permohonanSijilTahfiz()
    {
        return $this->belongsTo(PermohonanSijilTahfiz::class);
    }

    public function getPelajarNamaAttribute()
    {
        if ($this->attributes['yuran_id'] == Generic::YURAN_SIJIL_TAHFIZ) {
            return $this->permohonanSijilTahfiz->name;
        }
        else {
            return $this->pelajar->nama;
        }
    }

    public function getPelajarIcAttribute()
    {
        if ($this->attributes['yuran_id'] == Generic::YURAN_SIJIL_TAHFIZ) {
            return $this->pemohon->username;
        }
        else {
            return $this->pelajar->no_ic;
        }
    }

    public static function getStatusSelection()
    {
        $status = [
            1 => 'Belum Dibayar',
            2 => 'Bayaran Selesai',
            3 => 'Bil Batal',
        ];

        return $status;
    }

    public function getStatusNameAttribute()
    {
        $status = $this->getStatusSelection();

        if (! empty($this->attributes['status'])) {
            return @$status[$this->attributes['status']];
        }
    }
}
