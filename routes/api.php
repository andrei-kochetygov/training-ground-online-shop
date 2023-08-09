<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/refresh', 'refresh');
    Route::post('/request-password-reset-link', 'requestPasswordResetLink');
    Route::patch('/reset-password', 'resetPassword');
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('/auth')->controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/user', 'getAuthenticatedUser');
        Route::patch('/user', 'updateAuthenticatedUser');
        Route::post('/request-email-verification-link', 'sendEmailVerificationLink');
        Route::patch('/verify-email', 'verifyEmail')->name('verification.verify');
    });
});
