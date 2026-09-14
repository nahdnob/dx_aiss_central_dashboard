<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use Illuminate\View\View;

use App\Models\Line;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {

        $request->validate([
            'npk'      => 'required|unique:users',
            'name'     => 'required',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'required|min:6'
            // 'email'    => 'required|email|unique:users',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
        }

        $user = User::create([
            'npk'      => $request->npk,
            'name'     => $request->name,
            'role'     => 'user',
            'image'    => $imagePath,
            'password' => Hash::make($request->password)
            // 'email'    => $request->email,
        ]);

        Auth::login($user);

        return redirect()->route('dashboards.index')
            ->with('success', 'Registrasi berhasil, selamat datang!');
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route(session('selected_line_id') ? 'system-managers.index' : 'dashboards.index');
        }

        $lines = Line::orderBy('name')->get();

        return view('auth.login', compact('lines'));
    }

    public function login(Request $request) {

        $credentials = $request->validate([
            'npk'      => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();

            if ($request->wantsJson()) {
                return response()->json([
                    'success'    => true,
                    'csrf_token' => csrf_token(),
                ]);
            }

            return redirect()->route('dashboards.index')
                ->with('success', 'Login berhasil!');
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'NPK atau password salah',
            ], 401);
        }

        return back()
            ->with('error', 'NPK atau password salah')
            ->withInput();
    }

    public function logout(Request $request) {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Logout berhasil!');
    }
}
