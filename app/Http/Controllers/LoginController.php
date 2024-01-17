<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
     /**
     * Authenticate username and password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        return view('auth.login');
    }
}
