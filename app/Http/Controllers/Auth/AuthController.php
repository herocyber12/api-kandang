<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth as Ath;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function checkLogin(Ath $r)
    {
        $credential = $r->only('email','password');

        if(Auth::attempt($credential)){
            return redirect()->route('dashboard');
        }

        return back()->with('error','Login Gagal');
    }

    public function portals()
    {
        return view('portal.index');
    }

    public function portal_mode($mode)
    {
        dd($mode);
    }
}
