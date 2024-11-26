<?php

namespace App\Controllers;
use App\Models\User;
use Support\Auth;
use Support\BaseController;
use Support\Request;
use Support\Session;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class AuthController extends BaseController
{
    // Controller logic here
    public function index()
    {
        return view('auth/login');
    }

    public function onLogin(Request $request)
    {
        $credentials = [
            'identifier' => $request->username,
            'password' => $request->password
        ];
        if(Auth::attempt($credentials)){
            return redirect('/home');
        }
        // $user = User::query()
        //         ->where('username','=',$request->username)
        //         ->first();
        //         // print_r($user);
        // if($user && password_verify($request->password,$user->password)){
        //     Session::set('user',[
        //         'username' => $user->username
        //     ]);
        //     return redirect('/home');
        // }
        return view('auth/login');
        // vd($user);
    }

    public function logout(Request $request)
    {
        Session::destroy();
        return redirect('/login');
    }
}
