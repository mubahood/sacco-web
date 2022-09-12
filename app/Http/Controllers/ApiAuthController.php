<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;


class ApiAuthController extends Controller
{
 
   
    public function me()
    {
        die("Romina k");
        $query = auth()->user();
        return $this->successResponse($query, $message = "Profile details", 200);
    }

    public function login()
    {
        die("Time to login");
    }

    public function register()
    {
        die("Time to register");
    }
}
