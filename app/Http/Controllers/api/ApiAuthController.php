<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;


class ApiAuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }



    public function me()
    {

        $token = auth()->attempt([
            'username' => 'admin',
            'password' => 'admin',
        ]);

        dd($token);
        die("Romina k");
        $query = auth('api')->user();
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
