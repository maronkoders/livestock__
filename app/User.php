<?php

namespace App;


use App\UserRole as AppUserRole;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\ModelHandler;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, ModelHandler, SoftDeletes;

    protected $fillable = [
        'email',
        'password',
        'phone',
        'slug',
        'user_role_id',
        'email_verified_at',
        'gender',
        'dob'
    ];

    public function processRequest($request)
    {
        return $this->handleIncomingRequest($this, $request);
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
