<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;

class AuthController extends CustomController
{
    public function __construct()
    {
        if(session()->has('authToken')){
            return redirect('/');
        }
    }
    public function index()
    {
        return view("auth.index");
    }

    public function login(AuthLoginRequest $request)
    {
        if(auth()->attempt($request->only(['email','password']))){
            $token = auth()->user()->createToken('ehe',['create','read'])->plainTextToken;
            $cookie = cookie('token-access',$token);
            return redirect('/')->withCookie($cookie);
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registering(AuthRegisterRequest $request)
    {
        $url = url(route('v1.user.store'));
        $response = $this->requestPost($url,$request->all());
        dd($response);
    }
}
