<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiEnterprisesController;
use Illuminate\Support\Facades\Route;


Route::POST("users/register", [ApiAuthController::class, "register"]);
Route::POST("users/login", [ApiAuthController::class, "login"]);
Route::get("test", function () {
    die("Romina test");
});

Route::group(['middleware' => 'api'], function ($router) {
    Route::get("users/me", [ApiAuthController::class, 'me']);
    Route::get("me", [ApiAuthController::class, 'me']);
    
    //enterprises
    Route::get("enterprises", [ApiEnterprisesController::class, 'index']);
    Route::post("enterprises", [ApiEnterprisesController::class, 'create']);
    Route::post("decline-group-join-request", [ApiEnterprisesController::class, 'decline_group_join_request']);
    Route::post("approve-group-join-request", [ApiEnterprisesController::class, 'approve_group_join_request']);
    Route::post("group-tasks", [ApiEnterprisesController::class, 'group_tasks']);
    Route::post("enterprises-select", [ApiEnterprisesController::class, 'select']);

}); 