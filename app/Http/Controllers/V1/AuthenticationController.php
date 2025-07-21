<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\V1\LoginRequest;

class AuthenticationController extends Controller
{
    public function login(LoginRequest $loginRequest)
    {
        $loginRequest->authenticate();


        return $loginRequest->generateUserToken();
    }

    public function getUser(){
        return Auth::user();
    }
}
