<?php

use App\Http\Controllers\Api\ApiUsersController;
use Illuminate\Support\Facades\Route;

Route::get("users/login", [ApiUsersController::class, "login"])->name('login');
Route::get("users/register", [ApiUsersController::class, "register"])->name('register');

Route::group(['middleware' => 'api'], function ($router) {
    Route::get("users/me", [ApiUsersController::class, "me"]);
});
