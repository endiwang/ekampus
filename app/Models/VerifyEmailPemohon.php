<?php

namespace App\Models;

use App\Models\Base as Model;

class VerifyEmailPemohon extends Model
{
    protected $table = 'verify_email_pemohon';

    protected $fillable = ['token', 'pemohon_id'];

    public function pemohon()
    {
        return $this->belongsTo('App\Models\Pemohon');
    }
}
