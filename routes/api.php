<?php

use App\Http\Controllers\UsersController;

use Illuminate\Http\Request;
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

Route::get('/users', [UsersController::class, 'index']);

Route::post('/users/{userName}/follow', [UsersController::class, 'doFollow']);

Route::post('/users/{userName}/unfollow', [UsersController::class, 'doUnfollow']);

Route::get('/users/{userName}/followers', [UsersController::class, 'followers']);
