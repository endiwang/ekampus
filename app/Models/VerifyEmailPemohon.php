<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyEmailPemohon extends Model
{
    use HasFactory;

    protected $table = 'verify_email_pemohon';

    protected $fillable = ['token','pemohon_id'];

    public function pemohon()
    {
        return $this->belongsTo('App\Models\Pemohon');
    }

}
