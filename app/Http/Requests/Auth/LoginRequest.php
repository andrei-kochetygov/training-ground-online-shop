<?php

namespace App\Http\Requests\Auth;

use App\Enums\User\UserAttributeName;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\JWTGuard;

class LoginRequest extends FormRequest
{
    const EMAIL_ATTRIBUTE_NAME = UserAttributeName::EMAIL;
    const PASSWORD_ATTRIBUTE_NAME = UserAttributeName::PASSWORD;

    /** @var JWTGuard */
    protected $guard;

    protected $token;

    public function __construct()
    {
        $this->guard = auth();
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            static::EMAIL_ATTRIBUTE_NAME => ['required', 'email'],
            static::PASSWORD_ATTRIBUTE_NAME => ['required', 'string'],
        ];
    }

    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        $this->token = $this->guard->attempt($this->only(static::EMAIL_ATTRIBUTE_NAME, static::PASSWORD_ATTRIBUTE_NAME));

        if (! $this->token) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                static::EMAIL_ATTRIBUTE_NAME => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            static::EMAIL_ATTRIBUTE_NAME => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey()
    {
        return Str::lower($this->input(static::EMAIL_ATTRIBUTE_NAME)).'|'.$this->ip();
    }

    public function getToken()
    {
        return $this->token;
    }
}
