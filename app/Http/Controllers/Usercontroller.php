<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Usercontroller extends Controller
{

    public function index()
    {

    }

    public function postLogin()
    {

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            // 认证通过...
            $user = Auth::user();
            $user = User::find(1);
            // Creating a token without scopes...
            $token = $user->createToken('MyApp')->accessToken;
            return response()->json([
                'token'=>$token,
            ],200);

            // Creating a token with scopes...
            //$token = $user->createToken('My Token', ['place-orders'])->accessToken;
        } else {
            return response()->json([
                'message'=>'登录失败',
                'code'=>401
            ],401);
        }

    }

    public function getPausePlus()
    {
        $user = Auth::user();
        return new \App\Http\Resources\User($user);
    }

    public function pausePlus()
    {
        $user = Auth::user();
        $user->update(request(['begin_at','end_at','remark']));

        return new \App\Http\Resources\User($user);
    }


}
