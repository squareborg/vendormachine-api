<?php

namespace App\Models;

use Sqware\Auth\Concerns\HasUuid;
use App\Models\Presenters\UserPresenter;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens, HasUuid, HasRoles, UserPresenter;

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar', 'name', 'email', 'password', 'email_verify_token', 'email_verified_at', 'facebook_auth_id', 'google_auth_id', 'is_suspended'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_suspended' => 'boolean',
    ];

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }
}
