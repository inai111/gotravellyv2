<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Cookie;

class AuthController extends Controller
{
    use HttpResponse;

    /**
     * @param Object $user
     */
    public function index(AuthLoginRequest $request)
    {
        if(!Auth::attempt($request->all())){
            return response('',401);
        }
        $user = Auth::user();
        $token = $user->createToken('basic-token',['create','read','update','delete'])->plainTextToken;
        $token = explode('|',$token);
        $response = Response::make(['user'=>$user,'token'=>$token[1]]);
        $response->headers->setCookie(
            new Cookie('token',$token[1],0,'/',"",false,true,false,'Lax')
        );
        return $response;
    }
}
