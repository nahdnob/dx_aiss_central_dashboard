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
    // Tampilkan form login
    public function showLoginForm()
    {
        // Sudah login: arahkan ke halaman sesuai status pilihan line
        if (Auth::check()) {
            return redirect()->route(
                session('selected_line_id') ? 'system-managers.index' : 'dashboards.index'
            );
        }

        // Ambil daftar line untuk form login
        $lines = Line::orderBy('name')->get();

        return view('auth.login', compact('lines'));
    }

    // Registrasi user baru
    public function register(Request $request) {

        // Validasi input
        $request->validate([
            'npk'      => 'required|unique:users',
            'name'     => 'required',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'required|min:8'
        ],[
            'npk.required'      => 'NPK wajib diisi',
            'npk.unique'        => 'NPK sudah terdaftar',
            'name.required'     => 'Nama wajib diisi',
            'image.image'       => 'File harus berupa gambar',
            'image.mimes'       => 'Format gambar harus JPG, JPEG, atau PNG',
            'image.max'         => 'Ukuran gambar maksimal 2MB',
            'password.required' => 'Password wajib diisi',
            'password.min'      => 'Password minimal 8 karakter'
        ]);

        $imagePath = null;

        // Simpan foto (jika ada)
        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('users', 'public');
        }

        // Simpan user baru
        $user = User::create([
            'npk'      => $request->npk,
            'name'     => $request->name,
            'role'     => 'user',
            'image'    => $imagePath,
            'password' => Hash::make($request->password) // Password di-hash
        ]);

        Auth::login($user); // Auto-login setelah daftar

        return redirect()->route('dashboards.index')
            ->with('success', 'Registrasi berhasil, selamat datang!');
    }

    // User login
    public function login(Request $request) {

        // Validasi input login
        $credentials = $request->validate([
            'npk'      => 'required',
            'password' => 'required'
        ]);

        // Verify credentials without authenticating until a line is selected.
        if (Auth::validate($credentials)) {
            $user = User::where('npk', $credentials['npk'])->firstOrFail();

            $request->session()->put('pending_login', [
                'user_id'  => $user->id,
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

        $request->session()->invalidate();      // Hapus session
        $request->session()->regenerateToken(); // Buat CSRF token baru

        return redirect('/')->with('success', 'Logout berhasil!');
    }
}