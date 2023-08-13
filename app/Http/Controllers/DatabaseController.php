<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

use App\Docs;
use App\Models\User;
use App\Enums\User\UserAttributeName;
use App\Http\Controllers\Controller;
use App\Http\Requests\Database\RefreshRequest;

#[Docs\FeatureTag('Database')]
class DatabaseController extends Controller
{
    #[
        Docs\Http\Methods\Post(
            path: '/api/database/refresh',
        ),
        Docs\Http\Requests\Json(
            email: 'supervisor@example.com',
            password: 'password123',
            password_confirmation: 'password123',
        ),
        Docs\Http\Responses\NoContent,
    ]
    public function refresh(RefreshRequest $request)
    {
        Artisan::call('migrate:fresh');

        $user = new User();

        $user->forceFill([
            UserAttributeName::EMAIL => $request->email,
            // UserAttributeName::EMAIL_VERIFIED_AT => now(),
            UserAttributeName::PASSWORD => bcrypt($request->password),
            UserAttributeName::ROLE => 'supervisor',
        ]);

        $user->save();

        return response()->noContent();
    }

    #[
        Docs\Http\Methods\Post(
            path: '/api/database/seed',
        ),
        Docs\Http\Responses\NoContent,
    ]
    public function seed()
    {
        Artisan::call('db:seed');

        return response()->noContent();
    }
}
