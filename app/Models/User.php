<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'is_staff',
        'is_alumni',
        'is_student',
        'is_berhenti',
        'is_suspended',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }

    public function pelajar()
    {
        return $this->hasMany(Pelajar::class)->where('is_deleted', '!=', 1);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function kaunselings()
    {
        return $this->hasMany(Kaunseling::class);
    }

    public function getEmailAddress()
    {
        if ($this->is_berhenti) {
            return null;
        }

        if ($this->is_staff) {
            return $this->staff()->first()->email;
        }

        if ($this->is_student) {
            return $this->pelajar()->where('is_berhenti', false)->first()->email;
        }

        return config('mail.from.address');
    }

    /**
     * Get the notification routing information for the given driver.
     *
     * @param  string  $driver
     * @param  \Illuminate\Notifications\Notification|null  $notification
     * @return mixed
     */
    public function routeNotificationFor($driver, $notification = null)
    {
        if (method_exists($this, $method = 'routeNotificationFor'.Str::studly($driver))) {
            return $this->{$method}($notification);
        }

        return match ($driver) {
            'database' => $this->notifications(),
            'mail' => $this->getEmailAddress(),
            default => null,
        };
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class);

    }
}
