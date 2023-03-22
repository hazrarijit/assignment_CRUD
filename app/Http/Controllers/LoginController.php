<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember_me = $request->has('remember') ? true : false;

        if (Auth::attempt($credentials, $remember_me)) {
            if(Auth::user()->active == 2){
                Auth::guard()->logout();
                return redirect()->route('login')->with('message', 'You account is not approve yet. Please try after some time.')->with('alert', 'alert-danger');
            }
            if(Auth::user()->active == 3){
                Auth::guard()->logout();
                return redirect()->route('login')->with('message', 'You account is temporary blocked by admin. Please contact support.')->with('alert', 'alert-danger');
            }
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return redirect()->route('login')->with('message', 'Invalid Credentials.')->with('alert', 'alert-danger');

    }

    public function registrationProcess(Request $request)
    {
        $this->validate($request, [
            "name" => 'required|string',
            "email" => 'required|email|unique:users',
            "password" => 'required|string',
        ]);
        $user_data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
            'active' => 2,
        ];
        User::create($user_data);
        return redirect('login')->with('message', 'Registration Successfully. You can login to you account using your credentials after admin approve your account.')->with('alert', 'alert-success');
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
        return redirect()->to('/');
    }
}
