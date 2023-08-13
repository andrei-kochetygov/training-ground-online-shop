<?php

namespace App\Http\Requests\Management;

use App\Models\User;
use App\Enums\User\UserAttributeName;
use App\Enums\User\UserRole;
use App\Http\Requests\SecuredFormRequest;

class UserStoreRequest extends SecuredFormRequest
{
    public function authorize()
    {
        return $this->user->hasSomeRole([UserRole::SUPERVISOR]);
    }

    public function rules()
    {
        return [
            UserAttributeName::EMAIL => 'required|email|unique:' . (new User)->getTable() . ',email',
            UserAttributeName::ROLE => 'required|string|in:' . UserRole::MANAGER,
        ];
    }
}
