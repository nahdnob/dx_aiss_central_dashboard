<?php

namespace App\Http\Controllers;

use App\Models\Line;
use Illuminate\Http\Request;

class LineController extends Controller
{
    /**
     * Tampilkan halaman pemilihan line.
     */
    public function index()
    {
        $lines = Line::orderBy('name')->get();

        return view('line-selector.index', compact('lines'));
    }

    /**
     * Simpan pilihan line ke session dan redirect ke system-managers.
     */
    public function select(Request $request)
    {
        $request->validate([
            'line_id' => 'required|exists:lines,id',
        ]);

        $line = Line::findOrFail($request->line_id);

        session([
            'selected_line_id'   => $line->id,
            'selected_line_name' => $line->name,
        ]);

        return redirect()->route('system-managers.index')
            ->with('success', "{$line->name} berhasil dipilih. Selamat datang di System Manager!");
    }

    /**
     * Bersihkan pilihan line dari session (ganti line).
     */
    public function clear()
    {
        session()->forget(['selected_line_id', 'selected_line_name']);

        return redirect()->route('dashboards.index');
    }
}
