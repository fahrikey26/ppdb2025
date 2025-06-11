<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginCon extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function login()
    {

        if (Auth::check()) {
            return redirect('dashboard');
        } else {
            return view('auth.login');
        }
    }

    public function actionlogin(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        if (Auth::Attempt($data)) {
            return redirect('dashboard');
        } else {
            //Session::flash('error', 'Email atau Password Salah');
            //return redirect('/login');
            return redirect()->back()->with('error', 'Login gagal! Silakan coba lagi.');
        }
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
