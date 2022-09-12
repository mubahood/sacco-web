<?php

use Illuminate\Support\Facades\Route;
 
Route::group(['middleware' => 'api'], function ($router) {
    Route::get("users/me", function (){
        $token = auth()->attempt([
            'email' => 'admin',
            'password' => 'admin',
        ]);
        die($token);

        die("Romina");
    });
});
