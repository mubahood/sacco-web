<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;

class ApiUsersController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

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
