<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Profile;
use App\Models\Student;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('feed');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username_or_email' => 'required|string',
            'password' => 'required|string',
        ]);

        $field = filter_var($credentials['username_or_email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $credentials['username_or_email'], 'password' => $credentials['password']], $request->has('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('feed'))->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'username_or_email' => 'Username/email atau password yang Anda masukkan salah.',
        ])->onlyInput('username_or_email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('feed');
        }
        $roles = Role::whereIn('name', ['siswa', 'guru', 'orang_tua', 'alumni'])->get();
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username|alpha_dash',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => strtolower($request->username),
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        Profile::create([
            'user_id' => $user->id,
            'full_name' => $user->name,
            'bio' => 'Anggota baru ekosistem SchoolVideo SMK Negeri 1 Cirebon.',
        ]);

        $role = Role::find($request->role_id);
        if ($role && strtolower($role->name) === 'siswa') {
            Student::create([
                'user_id' => $user->id,
            ]);
        }

        Auth::login($user);

        return redirect()->route('feed')->with('success', 'Registrasi berhasil! Selamat datang di SchoolVideo.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
