<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
                'admin' => redirect()->to('/admin/dashboard'),
                'project_manager' => redirect()->to('/project-manager/dashboard'),
                'developer' => redirect()->to('/developer/dashboard'),
                'tester' => redirect()->to('/tester/dashboard'),
                default => abort(403),
            };
        }

        return back()->withErrors([
            'email' => 'Invalid email or password',
        ])->onlyInput('email');
    }

    public function register() {

    }
}
