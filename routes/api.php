<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
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

Route::group(['prefix' => '/profile'], function () {
    Route::post('/register', [ProfileController::class, 'store']);
    Route::post('/login', [ProfileController::class, 'login']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/logout', [ProfileController::class, 'logout']);
        Route::get('/', [ProfileController::class, 'show']);
        Route::delete('/', [ProfileController::class, 'destroy']);
    });
});

Route::group([
    'prefix' => '/todos',
    'middleware' => 'auth:api'
], function () {
    Route::get('/', [TodoController::class, 'index']);
    Route::post('/', [TodoController::class, 'store']);
    Route::get('/{todo}', [TodoController::class, 'show']);
    Route::put('/{todo}', [TodoController::class, 'update']);
    Route::delete('/{todo}', [TodoController::class, 'destroy']);
});

Route::fallback(function () {
    return response()->json(['error' => 'Not found'], 404);
})->name('api.fallback.404');
