<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Tymon\JWTAuth\JWTGuard;

use App\Models\User;
use App\Enums\User\UserRole;

class SecuredFormRequest extends FormRequest
{
    /** @var JWTGuard */
    protected $guard;

    /** @var User */
    protected $user;

    public function __construct()
    {
        $this->guard = auth();
        $this->user = $this->guard->user();
    }

    public function authorize()
    {
        return $this->user->hasSomeRole([UserRole::SUPERVISOR, UserRole::MANAGER]);
    }
}
