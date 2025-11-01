<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginPage()
    {
        return view('backend.pages.auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'login.password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->input('login.password'),
        ];
        $remember = $request->has('remember');

        $active_user = User::where('email', $request->email)->first();

        if ($active_user) {
            if ($active_user->status == 1) {
                if (Auth::attempt($credentials, $remember)) {
                    $request->session()->regenerate();
                    return redirect()->route('admin.dashboard');
                }
            } else {
                return redirect()->back()->with('error', "You are not a valid user.");
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
