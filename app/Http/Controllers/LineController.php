<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LineController extends Controller
{
    /**
     * Simpan pilihan line ke session dan redirect ke dashboard (Home).
     */
    public function select(Request $request)
    {
        $request->validate([
            'line_id' => 'required|exists:lines,id',
        ]);

        $line = Line::findOrFail($request->line_id);

        if (!Auth::check()) {
            $pendingLogin = session('pending_login');

            abort_unless($pendingLogin, 403, 'Silakan login terlebih dahulu.');

            $user = User::findOrFail($pendingLogin['user_id']);
            Auth::login($user, (bool) $pendingLogin['remember']);
            $request->session()->regenerate();
            $request->session()->forget('pending_login');
        }

        session([
            'selected_line_id'   => $line->id,
            'selected_line_name' => $line->name,
        ]);

        // Semua role masuk ke Dashboard (Home); menu sidebar menyesuaikan role
        return redirect()->route('dashboards.index')
            ->with('success', "{$line->name} berhasil dipilih. Selamat datang!");
    }
}
