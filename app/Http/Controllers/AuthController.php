<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    // --- REGISTER ---

    // 1. Tampilkan Form Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // 2. Proses Data Register
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Pastikan ada input name="password_confirmation" di view
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Password wajib di-hash!
        ]);

        // Langsung login setelah register
        Auth::login($user);

        // Redirect ke dashboard
        return redirect()->intended('dashboard');
    }

    // --- LOGIN ---

    // 3. Tampilkan Form Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // 4. Proses Data Login
    public function login(Request $request)
    {
        // Validasi input sederhana
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login (Auth::attempt otomatis cek hash password)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Jika sukses, regenerate session ID (Wajib untuk keamanan!)
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        // Jika gagal, kembalikan error
        throw ValidationException::withMessages([
            'email' => __('Kombinasi email dan password tidak cocok.'),
        ]);
    }

    // --- LOGOUT ---

    // 5. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session agar tidak bisa dipakai lagi (Fixation attack protection)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

}
