<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AduanPenyelenggaraan extends Model
{
    use HasFactory;
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
        if(!empty($user->is_staff))
        {
            return @Staff::where('user_id', $user->id)->first()->nama;
        }
        else if(!empty($user->is_student))
        {
            return @Student::where('user_id', $user->id)->first()->nama;
        }
        return '';
    }

    public function getKategoriNameAttribute()
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

        if(!empty($this->attributes['kategori']))
        {
            return @$kategori_aduan[$this->attributes['kategori']];
        }
    }

    public function getStatusNameAttribute()
    {        
        $status = [
            1 => 'Baru diterima', 
            2 => 'Dalam Proses Vendor', 
            3 => 'Dalam Proses Unit Penyelenggaraan', 
            4 => 'Selesai',
        ];

        if(!empty($this->attributes['status']))
        {
            return @$status[$this->attributes['status']];
        }
    }

    public function getLokasiNameAttribute()
    {        
        $lokasi = [
            'A' => 'Asrama', 
            'K' => 'Kuliah', 
            'P' => 'Pentadbiran', 
            'L' => 'Lain-lain',
        ];

        if(!empty($this->attributes['type']))
        {
            return @$lokasi[$this->attributes['type']];
        }
    }



    
}
