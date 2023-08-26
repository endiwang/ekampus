<?php

namespace App\Models;

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
