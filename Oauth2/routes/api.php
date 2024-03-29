<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleHasPermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::namespace('Api')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('signup', [AuthController::class, 'register']);
    });

    Route::middleware(['auth:api'])->group(function () {
        Route::get('helloworld', [AuthController::class, 'index']);
        Route::post('logout', [AuthController::class, 'logout']);

        Route::middleware(['admin'])->group(function () {
            // Roles
            Route::get('/roles', [RoleController::class, 'index']);
            Route::get('/role/{id}', [RoleController::class, 'show']);
            Route::post('/role', [RoleController::class, 'store']);
            Route::post('/role/{id}', [RoleController::class, 'update']);
            Route::delete('/role/{id}', [RoleController::class, 'destroy']);

            // Permissions
            Route::get('/permissions', [PermissionController::class, 'index']);
            Route::get('/permission/{id}', [PermissionController::class, 'show']);
            Route::post('/permission', [PermissionController::class, 'store']);
            Route::post('/permission/{id}', [PermissionController::class, 'update']);
            Route::delete('/permission/{id}', [PermissionController::class, 'destroy']);

            // Role has permissions
            Route::get('/role_has_permissions', [RoleHasPermissionController::class, 'index']);
            Route::get('/role_has_permissions/{id}', [RoleHasPermissionController::class, 'show']);
            Route::post('/role_has_permissions', [RoleHasPermissionController::class, 'store']);
            Route::post('/role_has_permissions/{id}', [RoleHasPermissionController::class, 'update']);
            Route::delete('/role_has_permissions/{id}', [RoleHasPermissionController::class, 'destroy']);

            // Users
            Route::get('/users', [UserController::class, 'index']);
            Route::get('/user/{id}', [UserController::class, 'show']);
            Route::post('/user', [UserController::class, 'store']);
            Route::post('/user/{id}', [UserController::class, 'update']);
            Route::delete('/user/{id}', [UserController::class, 'destroy']);
        });
    });
});

