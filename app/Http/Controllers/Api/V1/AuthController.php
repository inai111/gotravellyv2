<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Traits\HttpResponse;
use Auth;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    use HttpResponse;

    public function index(AuthLoginRequest $request)
    {
        if(!Auth::attempt($request->all())){
            return response('',401);
        }
        $user = Auth::user();
        $token = $user->createToken('basic-token',['create','read','update','delete'])->plainTextToken;
        $token = explode('|',$token);
        return response()->json([
            'data'=>$user,
            'token'=>$token[1]
        ]);
    }
}
