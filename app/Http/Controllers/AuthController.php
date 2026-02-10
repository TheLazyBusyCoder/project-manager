<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return match (auth()->user()->role) {
                'admin' => redirect()->to('/admin'),
                'project_manager' => redirect()->to('/pm'),
                'developer' => redirect()->to('/developer'),
                'tester' => redirect()->to('/tester'),
                default => abort(403),
            };
        }

        return back()->withErrors([
            'email' => 'Invalid email or password',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // logout user
        $request->session()->invalidate(); // invalidate session
        $request->session()->regenerateToken(); // prevent CSRF reuse
        return redirect('/')->with('success', 'Logged out successfully.');
    }

    public function setupAccount(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'token'    => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return abort(403, 'Invalid or expired link');
        }

        User::where('email', $request->email)->update([
            'password' => bcrypt($request->password),
            'status'   => 'active',
        ]);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect('/login')->with('success', 'Account setup completed.');
    }

    public function register() {

    }
}
