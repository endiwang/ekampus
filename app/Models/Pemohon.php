<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pemohon extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;

    protected $guard = 'pemohon';

    protected $table = 'pemohon';

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function verifyEmailPemohon()
    {
        return $this->hasOne('App\Models\VerifyEmailPemohon');
    }
}
