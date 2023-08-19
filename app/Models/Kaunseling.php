<?php

namespace App\Models;


use App\Models\Base as Model;

class Kaunseling extends Model
{


    protected $table = 'kaunseling';

    protected $guarded = ['id'];

    protected $appends = ['status_label'];

    public const STATUS_BARU = 'baru';

    public const STATUS_DITERIMA = 'diTerima';

    public const STATUS_DITOLAK = 'diTolak';

    public const STATUS_SELESAI = 'selesai';

    protected $casts = [
        'tarikh_permohonan' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getStatuses(): array
    {
        return [
            self::STATUS_BARU => 'Baru',
            self::STATUS_DITERIMA => 'Diterima',
            self::STATUS_DITOLAK => 'Ditolak',
            self::STATUS_SELESAI => 'Selesai',
        ];
    }

    public function getStatusLabelAttribute()
    {
        return self::getStatuses()[$this->status];
    }
}
