<?php

namespace App\Http\Requests\Management;

use Illuminate\Validation\Rules\Unique;

use App\Models\User;
use App\Enums\User\UserAttributeName;
use App\Enums\User\UserRole;
use App\Http\Requests\SecuredFormRequest;

class UserUpdateRequest extends SecuredFormRequest
{
    public function authorize()
    {
        return $this->user->hasSomeRole([UserRole::SUPERVISOR]);
    }

    public function rules()
    {
        $userId = $this->request->get('user');

        $usersTableName = (new User)->getTable();

        $uniqueEmailRule = new Unique($usersTableName, UserAttributeName::EMAIL);

        return [
            UserAttributeName::EMAIL => ['required', 'email', $uniqueEmailRule->ignore($userId)],
            UserAttributeName::ROLE => 'required|string|in:' . UserRole::MANAGER,
        ];
    }
}
