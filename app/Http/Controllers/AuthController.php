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
        $url = url(route('v1.login'));
        $response = $this->requestPost($url,$request->all());
        if($response->ok()){
            $data = $response->json();

            # simpan token di session
            $token = $data['token'];
            $request->session()->put('authToken',$token);
            $request->session()->put('user',$data['data']);
            return redirect(route('user'));
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
