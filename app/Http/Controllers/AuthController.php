<?php

namespace App\Http\Controllers;

use App\Enums\User\UserAttributeName;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerificationRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\PasswordResetLinkRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateAuthenticatedUserRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\JWTGuard;
use App\Docs;

#[Docs\FeatureTag('Authentication')]
class AuthController extends Controller
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

    #[
        Docs\Http\Methods\Post(
            path: '/api/auth/register',
            summary: 'Allows to register new user',
        ),
        Docs\Http\Requests\Json(
            email: 'user@example.com',
            password: 'password123',
            password_confirmation: 'password123',
        ),
        Docs\Http\Responses\JsonWebToken,
        Docs\Http\Responses\UnprocessableEntity(
            email: ['The email field is required.'],
            password: ['The password field is required.'],
        ),
    ]
    public function register(RegisterRequest $request)
    {
        $user = User::forceCreate([
            UserAttributeName::EMAIL => $request->email,
            UserAttributeName::PASSWORD => bcrypt($request->password),
        ]);

        Registered::dispatch($user);

        $token = $this->guard->login($user);

        return $this->respondWithToken($token);
    }

    #[
        Docs\Http\Methods\Post(
            path: '/api/auth/login',
            summary: 'Allows user to login with email and password',
        ),
        Docs\Http\Requests\Json(
            email: 'user@example.com',
            password: 'password123',
        ),
        Docs\Http\Responses\JsonWebToken,
        Docs\Http\Responses\UnprocessableEntity(
            email: ['The email field is required.'],
            password: ['The password field is required.'],
        ),
    ]
    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $token = $request->getToken();

        return $this->respondWithToken($token);
    }
    
    #[
        Docs\Http\Methods\Post(
            path: '/api/auth/logout',
            summary: 'Allows user to login with email and password',
            secured: true,
        ),
        Docs\Http\Responses\NoContent,
        Docs\Http\Responses\Unauthenticated,
    ]
    public function logout()
    {
        $this->guard->logout();

        return response()->noContent();
    }

    #[
        Docs\Http\Methods\Post(
            path: '/api/auth/refresh',
            summary: 'Allows to refresh expired JWT access token',
            secured: true,
        ),
        Docs\Http\Responses\JsonWebToken,
        Docs\Http\Responses\Unauthenticated,
    ]
    public function refresh()
    {
        return $this->respondWithToken($this->guard->refresh());
    }

    #[
        Docs\Http\Methods\Get(
            path: '/api/auth/user',
            summary: 'Allows to get currently authenticated user data',
            secured: true,
        ),
        Docs\Http\Responses\Ok(
            id: 1,
            email: 'user@example.com',
            email_verified_at: null,
            created_at: null,
            updated_at: null,
            deleted_at: null,
        ),
        Docs\Http\Responses\Unauthenticated,
    ]
    public function getAuthenticatedUser()
    {
        return response()->json($this->user);
    }

    public function updateAuthenticatedUser(UpdateAuthenticatedUserRequest $request)
    {
        if ($this->user instanceof User) {
            $this->user->update($request->validated());
        }

        return response()->noContent();
    }

    #[
        Docs\Http\Methods\Post(
            path: '/api/auth/request-password-reset-link',
            summary: 'Allows guest to request password reset link if he forgot his password',
        ),
        Docs\Http\Requests\Json(
            email: 'user@example.com',
        ),
        Docs\Http\Responses\Ok(
            message: 'We have emailed your password reset link!',
        ),
        Docs\Http\Responses\UnprocessableEntity(
            email: ['The email field is required.'],
        ),
    ]
    public function requestPasswordResetLink(PasswordResetLinkRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only([PasswordResetLinkRequest::EMAIL_ATTRIBUTE_NAME])
        );

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                PasswordResetLinkRequest::EMAIL_ATTRIBUTE_NAME => [__($status)],
            ]);
        }

        return response()->json(['message' => __($status)]);

    }

    #[
        Docs\Http\Methods\Patch(
            path: '/api/auth/reset-password',
            summary: 'Allows guest to reset forgotten password with new one',
        ),
        Docs\Http\Requests\Json(
            token: 'iImCGLxZKiLccMteIhcA76RYaI5fxHvC',
            email: 'user@example.com',
            password: 'password123',
            password_confirmation: 'password123',
        ),
        Docs\Http\Responses\Ok(
            message: 'Password was successfully reset',
        ),
        Docs\Http\Responses\UnprocessableEntity(
            token: ['Token is invalid.'],
            email: ['The email field is required.'],
            password: ['Password is required.'],
        ),
    ]
    public function resetPassword(PasswordResetRequest $request)
    {
        $status = Password::reset(
            $request->only(
                PasswordResetRequest::TOKEN_ATTRIBUTE_NAME,
                PasswordResetRequest::EMAIL_ATTRIBUTE_NAME,
                PasswordResetRequest::PASSWORD_ATTRIBUTE_NAME,
                PasswordResetRequest::PASSWORD_CONFIRMATION_ATTRIBUTE_NAME,
            ),
            function ($user) use ($request) {
                $user->forceFill([
                    UserAttributeName::EMAIL => bcrypt($request->get(PasswordResetRequest::PASSWORD_ATTRIBUTE_NAME)),
                ])->save();
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                PasswordResetRequest::EMAIL_ATTRIBUTE_NAME => [__($status)],
            ]);
        }

        return response()->json(['message' => __($status)]);
    }
    
    #[
        Docs\Http\Methods\Post(
            path: '/api/auth/request-email-verification-link',
            summary: 'Allows authenticated user to repeat request for the email verification link',
            secured: true,
        ),
        Docs\Http\Responses\Ok(
            message: 'Verification link will be sent soon',
        ),
        Docs\Http\Responses\Found(RouteServiceProvider::HOME),
        Docs\Http\Responses\Unauthenticated,
    ]
    public function sendEmailVerificationLink()
    {
        if ($this->user->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $this->user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification link will be sent soon']);
    }

    #[
        Docs\Http\Methods\Patch(
            path: '/api/auth/verify-email',
            summary: 'Allows to verify email with the link which was sent to the user email',
            secured: true,
        ),
        Docs\Http\Requests\Json(
            expires: '1690963346',
            hash: '6c08e383e701eee281be1453d3c9a8471fb712ab',
            id: '1',
            signature: 'f0ecf0ee45239b48e802c51d592dd22e126d3c5fa571f713f320262ca98bdf98',
        ),
        Docs\Http\Responses\NoContent,
        Docs\Http\Responses\Unauthenticated,
    ]
    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return response()->noContent();
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => $this->guard->factory()->getTTL() * 60
        ]);
    }
}