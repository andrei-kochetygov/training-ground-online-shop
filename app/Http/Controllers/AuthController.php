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
use OpenApi\Attributes as OA;
use App\Docs;

#[Docs\Controllers\Tags(['Authentication'])]
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

    #[Docs\Controllers\Methods\Post(
        path: '/api/auth/register',
        summary: 'Allows to register new user',
    )]
    #[Docs\Responses\OkResponse(
        access_token: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9hdXRoXC9yZWdpc3RlciIsImlhdCI6MTY5MTUwMDc3OCwiZXhwIjoxNjkxNTAxMDc4LCJuYmYiOjE2OTE1MDA3NzgsImp0aSI6ImZZWml6SlN6M3ozVW9RZjUiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.2ssS5y6CGWNSgZWO5DtYTiU2v4YK-UXV7TyC_kXdknc',
        token_type: 'Bearer',
        expires_in: 5 * 60,
    )]
    #[Docs\JsonBody(
        email: 'user@example.com',
        password: 'password123',
        password_confirmation: 'password123',
    )]
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

    #[Docs\Controllers\Methods\Post(
        path: '/api/auth/login',
        summary: 'Allows user to login with email and password',
    )]
    #[Docs\Responses\OkResponse(
        access_token: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9hdXRoXC9yZWdpc3RlciIsImlhdCI6MTY5MTUwMDc3OCwiZXhwIjoxNjkxNTAxMDc4LCJuYmYiOjE2OTE1MDA3NzgsImp0aSI6ImZZWml6SlN6M3ozVW9RZjUiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.2ssS5y6CGWNSgZWO5DtYTiU2v4YK-UXV7TyC_kXdknc',
        token_type: 'Bearer',
        expires_in: 5 * 60,
    )]
    #[Docs\JsonBody(
        email: 'user@example.com',
        password: 'password123',
    )]
    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $token = $request->getToken();

        return $this->respondWithToken($token);
    }
    
    #[Docs\SecuritySchemas(['jwt'])]
    #[Docs\Controllers\Methods\Post(
        path: '/api/auth/logout',
        summary: 'Allows user to login with email and password',
    )]
    #[Docs\Responses\NoContentResponse()]
    #[Docs\Responses\UnauthenticatedResponse()]
    public function logout()
    {
        $this->guard->logout();

        return response()->noContent();
    }

    #[Docs\SecuritySchemas(['jwt'])]
    #[Docs\Controllers\Methods\Post(
        path: '/api/auth/refresh',
        summary: 'Allows to refresh expired JWT access token',
    )]
    #[Docs\Responses\OkResponse(
        access_token: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9hdXRoXC9yZWdpc3RlciIsImlhdCI6MTY5MTUwMDc3OCwiZXhwIjoxNjkxNTAxMDc4LCJuYmYiOjE2OTE1MDA3NzgsImp0aSI6ImZZWml6SlN6M3ozVW9RZjUiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.2ssS5y6CGWNSgZWO5DtYTiU2v4YK-UXV7TyC_kXdknc',
        token_type: 'Bearer',
        expires_in: 5 * 60,
    )]
    #[Docs\Responses\UnauthenticatedResponse()]
    public function refresh()
    {
        return $this->respondWithToken($this->guard->refresh());
    }

    #[Docs\SecuritySchemas(['jwt'])]
    #[Docs\Controllers\Methods\Get(
        path: '/api/auth/user',
        summary: 'Allows to get currently authenticated user data',
    )]
    #[Docs\Responses\OkResponse(
        id: 1,
        email: 'user@example.com',
        email_verified_at: null,
        created_at: null,
        updated_at: null,
        deleted_at: null,
    )]
    #[Docs\Responses\UnauthenticatedResponse()]
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

    #[Docs\Controllers\Methods\Post(
        path: '/api/auth/request-password-reset-link',
        summary: 'Allows guest to request password reset link if he forgot his password',
        responses: [
            new OA\Response(
                response: 422,
                description: 'Returns form validation errors',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'The given data was invalid.',
                        ),
                        new OA\Property(
                            property: 'errors',
                            type: 'string',
                            example: [
                                'email' => ['The email field is required.'],
                            ],
                        ),
                    ],
                ),
            ),
        ],
    )]
    #[Docs\Responses\OkResponse(
        message: 'We have emailed your password reset link!',
    )]
    #[Docs\JsonBody(
        email: 'user@example.com',
    )]
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

    #[Docs\Controllers\Methods\Patch(
        path: '/api/auth/reset-password',
        summary: 'Allows guest to reset forgotten password with new one',
        responses: [
            new OA\Response(
                response: 422,
                description: 'Returns form validation errors',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'The given data was invalid.',
                        ),
                        new OA\Property(
                            property: 'errors',
                            type: 'string',
                            example: [
                                'email' => ['The email field is required.'],
                            ],
                        ),
                    ],
                ),
            ),
        ],
    )]
    #[Docs\Responses\OkResponse(
        message: 'Password was successfully reset',
    )]
    #[Docs\JsonBody(
        token: 'iImCGLxZKiLccMteIhcA76RYaI5fxHvC',
        email: 'user@example.com',
        password: 'password123',
        password_confirmation: 'password123',
    )]
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
    
    #[Docs\SecuritySchemas(['jwt'])]
    #[Docs\Controllers\Methods\Post(
        path: '/api/auth/request-email-verification-link',
        summary: 'Allows authenticated user to repeat request for the email verification link',
        responses: [
            new OA\Response(
                response: 302,
                description: 'Redirects user to home page if email is already verified',
            ),
        ],
    )]
    #[Docs\Responses\OkResponse(
        message: 'Verification link will be sent soon',
    )]
    #[Docs\Responses\UnauthenticatedResponse()]
    public function sendEmailVerificationLink()
    {
        if ($this->user->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $this->user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification link will be sent soon']);
    }

    #[Docs\SecuritySchemas(['jwt'])]
    #[Docs\Controllers\Methods\Patch(
        path: '/api/auth/verify-email',
        summary: 'Allows to verify email with the link which was sent to the user email',
        responses: [
            new OA\Response(
                response: 422,
                description: 'Returns validation errors', // TODO: Add example
            ),
        ],
    )]
    #[Docs\JsonBody(
        expires: '1690963346',
        hash: '6c08e383e701eee281be1453d3c9a8471fb712ab',
        id: '1',
        signature: 'f0ecf0ee45239b48e802c51d592dd22e126d3c5fa571f713f320262ca98bdf98',
    )]
    #[Docs\Responses\NoContentResponse()]
    #[Docs\Responses\UnauthenticatedResponse()]
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