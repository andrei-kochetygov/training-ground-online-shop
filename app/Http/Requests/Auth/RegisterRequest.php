<?php

namespace App\Http\Requests\Auth;

use App\Enums\User\UserAttributeName;
use Database\TableName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
{
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
            static::EMAIL_ATTRIBUTE_NAME => ['required', 'email', 'max:255', new Rules\Unique(TableName::USERS)],
            static::PASSWORD_ATTRIBUTE_NAME => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
