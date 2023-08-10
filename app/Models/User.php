<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;

use Database\TableName;
use App\Enums\User\UserAttributeName;
use App\Notifications\EmailVerificationNotification;
use App\Notifications\PasswordResetNotification;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = TableName::USERS;

    protected $primaryKey = UserAttributeName::ID;

    protected $fillable = [];

    protected $hidden = [
        UserAttributeName::PASSWORD,
    ];

    public static function getValidationRulesForFillableAttributes()
    {
        return static::getValidationRules()->only((new static)->getFillable());
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
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