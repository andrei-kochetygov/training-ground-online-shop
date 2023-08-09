<?php

namespace App\Http\Requests\Auth;

use App\Enums\User\UserAttributeName;
use Illuminate\Foundation\Http\FormRequest;

class PasswordResetLinkRequest extends FormRequest
{
    const EMAIL_ATTRIBUTE_NAME = UserAttributeName::EMAIL;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            static::EMAIL_ATTRIBUTE_NAME => ['required', 'email'],
        ];
    }
}
