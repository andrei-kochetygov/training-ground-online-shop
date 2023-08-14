<?php

namespace App\Models;

use App\Enums\Order\OrderAttributeName;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;

use Database\TableName;
use App\Enums\User\UserAttributeName;
use App\Models\Traits\SimpleJsonPaginateTrait;
use App\Notifications\EmailVerificationNotification;
use App\Notifications\PasswordResetNotification;

class User extends Authenticatable implements JWTSubject // , MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes, SimpleJsonPaginateTrait;

    protected $table = TableName::USERS;

    protected $primaryKey = UserAttributeName::ID;

    protected $fillable = [];

    protected $hidden = [
        UserAttributeName::PASSWORD,
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, OrderAttributeName::USER_ID, (new Order)->getPrimaryKey());
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function hasSomeRole($roles)
    {
        return collect($roles)->reduce(function ($hasRole, $role) {
            return $hasRole || $this->role === $role;
        }, false);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification());
    }
}
