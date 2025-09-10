<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
        if(!$user){
            return back()->withErrors([
                'email' => 'Email hoặc mật khẩu không chính xác',
            ]);
        }
        if(!Hash::check($password, $user->password))
        {
            return back()->withErrors([
                'email' => 'Email hoặc mật khẩu không chính xác',
            ]);
        }

        //đăng nhập bằng id
        Auth::loginUsingId($user->id);
        $request->session()->regenerate();
        return redirect()->intended('/');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->intended('/');
    }
}