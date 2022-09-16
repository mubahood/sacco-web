<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enterprise;
use App\Traits\ApiResponser;

class ApiEnterprisesController extends Controller
{

    use ApiResponser;


    public function __construct()
    {
        $this->middleware('auth:api');
    }
 
    public function index()
    {
        /* die(" enterprises romina");
        $query = auth('api')->user(); */

        return $this->success(Enterprise::all(), $message = "Enterprise", 200);
    }
}
