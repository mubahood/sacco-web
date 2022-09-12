<?php

use App\Http\Controllers\Api\ApiAuthController;
use Illuminate\Support\Facades\Route;


Route::POST("users/register", [ApiAuthController::class, "register"]);
Route::POST("users/login", [ApiAuthController::class, "login"]);

Route::group(['middleware' => 'api'], function ($router) {
    Route::get("users/me", [ApiAuthController::class, 'me']);
});
