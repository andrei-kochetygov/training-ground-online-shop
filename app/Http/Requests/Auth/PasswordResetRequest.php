<?php

namespace App\Http\Requests\Auth;

use App\Enums\User\UserAttributeName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class PasswordResetRequest extends FormRequest
{
    const TOKEN_ATTRIBUTE_NAME = 'token';
    const EMAIL_ATTRIBUTE_NAME = UserAttributeName::EMAIL;
    const PASSWORD_ATTRIBUTE_NAME = UserAttributeName::PASSWORD;
    const PASSWORD_CONFIRMATION_ATTRIBUTE_NAME = UserAttributeName::PASSWORD . '_confirmation';

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            static::TOKEN_ATTRIBUTE_NAME => ['required'],
            static::EMAIL_ATTRIBUTE_NAME => ['required', 'email'],
            static::PASSWORD_ATTRIBUTE_NAME => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
