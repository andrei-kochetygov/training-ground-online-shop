<?php

namespace App\Http\Requests\Database;

use App\Enums\User\UserAttributeName;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rules\Password;

class RefreshRequest extends FormRequest
{
    public function rules()
    {
        return [
            UserAttributeName::EMAIL => 'required|email|max:255',
            UserAttributeName::PASSWORD => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
