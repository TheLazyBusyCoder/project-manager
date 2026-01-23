<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard() {
        return view('admin.dashboard');
    }

    public function projectManagers(Request $request) {
        $projectManagers = User::where('role', 'project_manager')->get();
        return view('admin.project-managers.index' , compact('projectManagers'));
    }

    public function projectManagerAdd(Request $request)
    {

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        DB::beginTransaction();

        try {
            // 1️⃣ Create user WITHOUT password
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt("password"), // temporary random password
                'role'     => 'project_manager',
                'status'   => 'active', // inactive until setup
            ]);

            // 2️⃣ Create setup token
            $token = Str::random(64);

            DB::table('password_reset_tokens')->insert([
                'email'      => $user->email,
                'token'      => $token,
                'created_at' => now(),
            ]);

            // 3️⃣ Send setup email
            $setupLink = url('/setup-account?token=' . $token . '&email=' . urlencode($user->email));

            // Mail::raw(
            //     "Hello {$user->name},\n\nYour Project Manager account has been created.\n\nSet your password using the link below:\n$setupLink\n\nThis link is valid for one-time use.",
            //     function ($message) use ($user) {
            //         $message->to($user->email)
            //                 ->subject('Set up your Project Manager account');
            //     }
            // );

            DB::commit();

            return back()->with('success', 'Project Manager added and email sent.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Something went wrong.');
        }
    }
}
