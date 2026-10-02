<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;   // Untuk login, logout, cek status auth
use Illuminate\Support\Facades\Hash;   // Untuk hash password

use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Models\Line;
use App\Models\User;

class AuthController extends Controller
{
    // Registrasi user baru
    public function register(Request $request) {

        // Validasi input
        $request->validate([
            'npk'      => 'required|unique:users',
            'name'     => 'required',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'required|min:6'
        ]);

        $imagePath = null;

        // Simpan foto (jika ada)
        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('users', 'public');
        }

        // Simpan user baru (password di-hash)
        $user = User::create([
            'npk'      => $request->npk,
            'name'     => $request->name,
            'role'     => 'user',
            'image'    => $imagePath,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user); // Auto-login setelah daftar

        return redirect()->route('dashboards.index')
            ->with('success', 'Registrasi berhasil, selamat datang!');
    }

    // Tampilkan form login
    public function showLoginForm()
    {
        // Kalau sudah login, langsung redirect
        if (Auth::check()) {
            return redirect()->route(session('selected_line_id') ? 'system-managers.index' : 'dashboards.index');
        }

        $lines = Line::orderBy('name')->get(); // Data untuk dropdown line

        return view('auth.login', compact('lines'));
    }

    // Proses login
    public function login(Request $request) {

        $credentials = $request->validate([
            'npk'      => 'required',
            'password' => 'required'
        ]);

        // Verify credentials without authenticating until a line is selected.
        if (Auth::validate($credentials)) {
            $user = User::where('npk', $credentials['npk'])->firstOrFail();

            $request->session()->put('pending_login', [
                'user_id' => $user->id,
                'remember' => $request->boolean('remember'),
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success'    => true,
                ]);
            }

            return redirect()->route('line-selector.index');
        }

        // Login gagal
        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'NPK atau password salah',
            ], 401);
        }

        return back()->with('error', 'NPK atau password salah')->withInput(); // Kembalikan input lama (password tidak ikut)
    }

    // Proses logout
    public function logout(Request $request) {

        Auth::logout();

        $request->session()->invalidate();     // Hapus session
        $request->session()->regenerateToken(); // Buat CSRF token baru

        return redirect('/')->with('success', 'Logout berhasil!');
    }
}