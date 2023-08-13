<?php

use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Management\UserController as UserManagementController;
use App\Http\Controllers\Management\CategoryController as CategoryManagementController;
use App\Http\Controllers\Management\ProductController as ProductManagementController;
use App\Http\Controllers\Management\OrderController as OrderManagementController;
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

Route::prefix('/database')->controller(DatabaseController::class)->group(function () {
    Route::post('/refresh', 'refresh');
    Route::post('/seed', 'seed');
});

Route::prefix('/auth')->controller(AuthController::class)->group(function () {
    // Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/refresh', 'refresh');
    Route::post('/request-password-reset-link', 'requestPasswordResetLink');
    Route::patch('/reset-password', 'resetPassword');
});

Route::prefix('/categories')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{category}/products', 'showProducts');
});

Route::prefix('/products')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{product}', 'show');
});

Route::prefix('/orders')->controller(OrderController::class)->group(function () {
    Route::post('/', 'store');
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('/auth')->controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/user', 'getAuthenticatedUser');
        // Route::patch('/user', 'updateAuthenticatedUser');
        // Route::post('/request-email-verification-link', 'sendEmailVerificationLink');
        // Route::patch('/verify-email', 'verifyEmail')->name('verification.verify');
    });

    Route::prefix('/manage')->group(function () {
        // Route::prefix('/users')->controller(UserManagementController::class)->group(function () {
        //     Route::get('/', 'index');
        //     Route::post('/', 'store');

        //     Route::prefix('/{category}')->group(function () {
        //         Route::get('/', 'show');
        //         Route::put('/', 'update');
        //         Route::delete('/', 'destroy');
        //         Route::get('/orders', 'showOrders');
        //     });
        // });

        Route::prefix('/categories')->controller(CategoryManagementController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');

            Route::prefix('/{category}')->group(function () {
                Route::get('/', 'show');
                Route::put('/', 'update');
                Route::delete('/', 'destroy');
                Route::get('/products', 'showProducts');
            });
        });
    
        Route::prefix('/products')->controller(ProductManagementController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');

            Route::prefix('/{product}')->group(function () {
                Route::get('/', 'show');
                Route::put('/', 'update');
                Route::delete('/', 'destroy');
            });
        });
    
        Route::prefix('/orders')->controller(OrderManagementController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');

            Route::prefix('/{order}')->group(function () {
                Route::get('/', 'show');
                Route::put('/', 'update');
                Route::get('/products', 'showProducts');
            });
        });
    });
});
