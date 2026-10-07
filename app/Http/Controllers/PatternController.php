<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pattern;
use App\Models\Sensor;

class PatternController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patterns = Pattern::where('line_id', session('selected_line_id'))->with('sensors:id,name')->get();
        $sensors  = Sensor::where('line_id', session('selected_line_id'))->get();
 
        return view('cycletimes.setting.index', [
            'patterns' => $patterns,
            'sensors'  => $sensors
        ]);
    } 

    /**
     * Handle the upload of the sensor mapping image.
     */
    public function uploadMap(Request $request)
    {
        $request->validate([
            'map_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'map_image.required' => 'File gambar tidak ditemukan.',
            'map_image.image'    => 'File harus berupa gambar.',
            'map_image.mimes'    => 'Format gambar harus berupa jpeg, png, jpg, atau webp.',
            'map_image.max'      => 'Ukuran gambar maksimal 5MB.',
        ]);

        if ($request->hasFile('map_image')) {
            
            $file            = $request->file('map_image');
            $destinationPath = public_path('img');
            $fileName        = 'sensor-mapping.png';
            
            $file->move($destinationPath, $fileName);
            
            return back()->with('success', 'Sensor Map berhasil diperbarui.');
        }

        return back()->withErrors(['map_image' => 'Terjadi kesalahan saat mengunggah gambar.']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        // 1️⃣ Validasi data utama
        $request->validate([
            'name'       => 'required|regex:/^[a-zA-Z0-9\s\-]+$/|unique:patterns,name',
            'cycle_time' => 'required|numeric|min:0|max:3600',
            'max_time'   => 'required|numeric|min:0|max:3600|gt:cycle_time',
            'min_time'   => 'required|numeric|min:0|max:3600|lt:cycle_time',
            'sensors' => 'sometimes|array',
            'sensors.*' => 'array',
            'sensors.*.pos' => 'nullable|integer|min:1',
            'sensors.*.cycle' => 'nullable|integer|min:1',
        ], [
            'name.required'       => 'Nama mode wajib diisi.',
            'name.regex'          => 'Nama hanya boleh berisi huruf, angka, spasi, dan tanda minus (-).',
            'name.unique'         => 'Nama mode sudah digunakan.',
            'cycle_time.required' => 'Limit durasi wajib diisi.',
            'cycle_time.numeric'  => 'Limit durasi harus berupa angka.',
            'cycle_time.min'      => 'Limit durasi minimal 0 detik.',
            'cycle_time.max'      => 'Limit durasi maksimal 3600 detik.',
            'max_time.required'   => 'Durasi maksimum wajib diisi.',
            'max_time.numeric'    => 'Durasi maksimum harus berupa angka.',
            'max_time.min'        => 'Durasi maksimum minimal 0 detik.',
            'max_time.max'        => 'Durasi maksimum maksimal 3600 detik.',
            'max_time.gt'         => 'Durasi maksimum harus lebih besar dari limit durasi.',
            'min_time.required'   => 'Durasi minimum wajib diisi.',
            'min_time.numeric'    => 'Durasi minimum harus berupa angka.',
            'min_time.min'        => 'Durasi minimum minimal 0 detik.',
            'min_time.max'        => 'Durasi minimum maksimal 3600 detik.',
            'min_time.lt'         => 'Durasi minimum harus lebih kecil dari limit durasi.',
        ]);
        
        // 2️⃣ Simpan data pattern
        $pattern = Pattern::create([
            'name'       => $request->name,
            'cycle_time' => $request->cycle_time,
            'max_time'   => $request->max_time,
            'min_time'   => $request->min_time,
            'line_id'    => session('selected_line_id'),
        ]);

        // 3️⃣ Sinkronisasi pivot pattern_sensor dengan kolom tambahan 'pos'
        $sensorsInput = $request->input('sensors', []);
        $syncData = [];
        foreach ($sensorsInput as $sensorId => $sensorConfig) {
            if (!empty($sensorConfig['pos'])) {
                $syncData[$sensorId] = [
                    'pos' => $sensorConfig['pos'],
                    'cycle' => $sensorConfig['cycle'] ?? 1,
                ];
            }
        }
        $pattern->sensors()->sync($syncData);

        // 5️⃣ Redirect sukses
        return redirect()->route('cycletimes.setting.index')->with('success', 'Mode berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pattern = Pattern::with('sensors:id')
                          ->select('id', 'name', 'cycle_time', 'max_time', 'min_time')
                          ->findOrFail($id);

        // Cek apakah request AJAX
        if (request()->ajax()) {
            return response()->json($pattern);
        }

        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1️⃣ Ambil data pattern yang akan diupdate
        $pattern = Pattern::findOrFail($id);

        // 2️⃣ Validasi input
        $request->validate([
            'name'       => "required|regex:/^[a-zA-Z0-9\s\-]+$/|unique:patterns,name,{$id}",
            'cycle_time' => 'required|numeric|min:0|max:3600',
            'max_time'   => 'required|numeric|min:0|max:3600|gt:cycle_time',
            'min_time'   => 'required|numeric|min:0|max:3600|lt:cycle_time',
            'sensors' => 'sometimes|array',
            'sensors.*' => 'array',
            'sensors.*.pos' => 'nullable|integer|min:1',
            'sensors.*.cycle' => 'nullable|integer|min:1',
        ], [
            'name.required'       => 'Nama mode wajib diisi.',
            'name.regex'          => 'Nama hanya boleh berisi huruf, angka, spasi, dan tanda minus (-).',
            'name.unique'         => 'Nama mode sudah digunakan.',
            'cycle_time.required' => 'Limit durasi wajib diisi.',
            'cycle_time.numeric'  => 'Limit durasi harus berupa angka.',
            'cycle_time.min'      => 'Limit durasi minimal 0 detik.',
            'cycle_time.max'      => 'Limit durasi maksimal 3600 detik.',
            'max_time.required'   => 'Durasi maksimum wajib diisi.',
            'max_time.numeric'    => 'Durasi maksimum harus berupa angka.',
            'max_time.min'        => 'Durasi maksimum minimal 0 detik.',
            'max_time.max'        => 'Durasi maksimum maksimal 3600 detik.',
            'max_time.gt'         => 'Durasi maksimum harus lebih besar dari limit durasi.',
            'min_time.required'   => 'Durasi minimum wajib diisi.',
            'min_time.numeric'    => 'Durasi minimum harus berupa angka.',
            'min_time.min'        => 'Durasi minimum minimal 0 detik.',
            'min_time.max'        => 'Durasi minimum maksimal 3600 detik.',
            'min_time.lt'         => 'Durasi minimum harus lebih kecil dari limit durasi.',
        ]);

        // 3️⃣ Update data utama pattern
        $pattern->update([
            'name'       => $request->name,
            'cycle_time' => $request->cycle_time,
            'max_time'   => $request->max_time,
            'min_time'   => $request->min_time,
        ]);

        // 4️⃣ Sinkronisasi pivot pattern_sensor dengan kolom tambahan 'pos'
        $sensorsInput = $request->input('sensors', []);
        $syncData = [];
        foreach ($sensorsInput as $sensorId => $sensorConfig) {
            if (!empty($sensorConfig['pos'])) {
                $syncData[$sensorId] = [
                    'pos' => $sensorConfig['pos'],
                    'cycle' => $sensorConfig['cycle'] ?? 1,
                ];
            }
        }
        $pattern->sensors()->sync($syncData);

        // 6️⃣ Redirect sukses
        return redirect()->route('cycletimes.setting.index')->with('success', 'Mode berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 1. Cari pattern berdasarkan ID
        $pattern = Pattern::findOrFail($id);

        // 2. Hapus relasi di tabel pivot (pattern_sensor)
        $pattern->sensors()->detach();

        // 3. Hapus pattern utama
        $pattern->delete();

        // 4. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('cycletimes.setting.index')->with('success', 'Pattern berhasil dihapus.');
    }
}
