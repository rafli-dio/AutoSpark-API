<?php

namespace App\Http\Controllers\Web;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
        }

        session([
            'user_id' => $user->id,
            'user_name' => $user->nama,
            'role_id' => $user->role_id,
        ]);

        if ($user->role_id == 1) {
            return redirect()->route('get-dashboard-admin');
        }

        return redirect('/'); 
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        $request->session()->regenerate();

        return redirect()->route('login')->with('message', 'Anda berhasil logout.');
    }
    
}
