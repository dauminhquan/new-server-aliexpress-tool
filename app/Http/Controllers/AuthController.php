<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function post_login(LoginRequest $request)
    {
        if(Auth::attempt(['email' => $request->email,'password' => $request->password]))
        {
            return response()->redirectToRoute('home');
        }
        return response()->redirectToRoute('login')->withErrors('Mật khẩu hoặc email không đúng');
    }
    public function logout(){
        Auth::logout();
        return response()->redirectToRoute('login');
    }
}
