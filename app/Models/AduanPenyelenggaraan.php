<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AduanPenyelenggaraan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'aduan_penyelenggaraan';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function blok()
    {
        return $this->belongsTo(Blok::class, 'blok_id', 'id');
    }

    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class, 'tingkat_id', 'id');
    }

    public function bilik()
    {
        return $this->belongsTo(Bilik::class, 'bilik_id', 'id');
    }

    public function getUserNameAttribute()
    {
        $user = $this->user;
        if (! empty($user->is_staff)) {
            return @Staff::where('user_id', $user->id)->first()->nama;
        } elseif (! empty($user->is_student)) {
            return @Student::where('user_id', $user->id)->first()->nama;
        }

        return '';
    }

    public static function getKategoriSelection()
    {
        $kategori_aduan = [
            1 => 'Sivil',
            2 => 'Mekanikal',
            3 => 'Elektrikal',
            4 => 'ICT',
            5 => 'Landskap',
            6 => 'Pembersihan',
            7 => 'Perkara/Alatan',
        ];

        return $kategori_aduan;
    }

    public static function getLokasiSelection()
    {
        $lokasi = [
            'A' => 'Asrama',
            'K' => 'Kuliah',
            'P' => 'Pentadbiran',
            'L' => 'Lain-lain',
        ];

        return $lokasi;
    }

    public static function getStatusSelection()
    {
        $status = [
            1 => 'Baru diterima',
            2 => 'Dalam Proses Vendor',
            3 => 'Dalam Proses Unit Penyelenggaraan',
            4 => 'Selesai',
        ];

        return $status;
    }

    public static function getStatusVendorSelection()
    {
        $status = [
            1 => 'Baru diterima',
            2 => 'Dalam Proses',
            3 => 'Selesai',
        ];

        return $status;
    }

    public function getKategoriNameAttribute()
    {
        $kategori_aduan = $this->getKategoriSelection();

        if (! empty($this->attributes['kategori'])) {
            return @$kategori_aduan[$this->attributes['kategori']];
        }
    }

    public function getLokasiNameAttribute()
    {
        $lokasi = $this->getLokasiSelection();

        if (! empty($this->attributes['type'])) {
            return @$lokasi[$this->attributes['type']];
        }
    }

    public function getStatusNameAttribute()
    {
        $status = $this->getStatusSelection();

        if (! empty($this->attributes['status'])) {
            return @$status[$this->attributes['status']];
        }
    }

    public function getStatusVendorNameAttribute()
    {
        $status_vendor = $this->getStatusVendorSelection();

        if (! empty($this->attributes['status_vendor'])) {
            return @$status_vendor[$this->attributes['status_vendor']];
        }
    }
}
