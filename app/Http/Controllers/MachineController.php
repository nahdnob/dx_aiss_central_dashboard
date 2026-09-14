<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Sop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MachineController extends Controller
{
    /**
     * Display list of machines from the database.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query  = Machine::select('id', 'asset_no', 'asset_name', 'acquisition_date', 'line_id')
                         ->withCount('sops as sops_count')
                         ->where('line_id', session('selected_line_id'));

        if ($search) {

            $query->where(function ($q) use ($search) {
                
                $q->where('asset_no', 'like', "%{$search}%")
                  ->orWhere('asset_name', 'like', "%{$search}%");
            });
        }

        $machines = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('machines.index', compact('machines'));
    }

    /**
     * Store a new machine to the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            
            'asset_no'         => 'required|string|unique:machines,asset_no|max:100',
            'asset_name'       => 'required|string|max:255',
            'acquisition_date' => 'nullable|date',
            'image_path'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ],[
            'asset_no.unique'  => 'The asset number must be unique.',
            'image_path.mimes' => 'The image must be an image (JPG, JPEG, PNG, or WebP).',
            'image_path.max'   => 'The image size must not exceed 2MB.',
        ]);

        if ($request->hasFile('image_path')) {

            $file = $request->file('image_path');

            // Generate nama file unik
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();

            // Simpan ke folder machines/images
            $file->storeAs('machines/images', $filename, 'public');

            // Simpan HANYA nama file ke database
            $validated['image_path'] = $filename;
        }

        Machine::create($validated);

        return redirect()->route('machines.index')->with('success', 'Machine added successfully.');
    }

    /**
     * Show machine detail page.
     */
    public function show($id)
    {
        $machine = Machine::where('asset_no', $id)
                          ->with([
                              'sops.riskAssessment',
                              'sops.dasgs',
                            ])
                          ->firstOrFail();

        $sops = $machine->sops; 

        $allDasgs = $sops->flatMap(fn($sop) => $sop->dasgs)
                         ->unique('id')
                         ->sortBy('name')
                         ->values();

        return view('machines.partial', compact(
            'machine',
            'sops',
            'allDasgs'
        ));
    }

    /**
     * Show the edit page for a machine (info + linked SOPs).
     */
    public function edit($id)
    {
        $machine       = Machine::where('asset_no', $id)->with('sops')->firstOrFail();
        $linkedSopIds  = $machine->sops->pluck('id')->toArray();
        $availableSops = Sop::whereNotIn('id', $linkedSopIds)->orderBy('name')->get();

        return view('machines.edit', compact('machine', 'availableSops'));
    }

    /**
     * Update machine information.
     */
    public function update(Request $request, $id)
    {
        $machine = Machine::where('asset_no', $id)->firstOrFail();

        $validated = $request->validate([
            'asset_name'       => 'required|string|max:255',
            'acquisition_date' => 'nullable|date',
            'manufacturer'     => 'nullable|string|max:255',
            'image_path'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'model'            => 'nullable|string|max:255',
            'status'           => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image_path')) {

            // Hapus gambar lama
            if (
                $machine->image_path &&
                Storage::disk('public')->exists('machines/images/' . $machine->image_path)
            ) {
                Storage::disk('public')->delete('machines/images/' . $machine->image_path);
            }

            $file = $request->file('image_path');

            // Generate nama file unik
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();

            // Simpan ke folder machines/images
            $file->storeAs('machines/images', $filename, 'public');

            // Simpan HANYA nama file ke database
            $validated['image_path'] = $filename;
        }

        $validated['line_id'] = session('selected_line_id');

        $machine->update($validated);

        return redirect()
            ->route('machines.edit', $id)
            ->with('success', 'Machine information updated successfully.'
        );
    }

    /**
     * Attach a SOP to a machine (many-to-many via machine_sop).
     */
    public function attachSop(Request $request, $id)
    {
        $machine = Machine::where('asset_no', $id)->firstOrFail();

        $request->validate([
            'sop_id' => 'required|integer|exists:sops,id',
        ]);

        $sopId = $request->input('sop_id');

        // Prevent duplicate
        if (!$machine->sops()->where('sop_id', $sopId)->exists()) {
            $machine->sops()->attach($sopId);
        }

        return redirect()->route('machines.edit', $id)
            ->with('success', 'SOP linked to machine successfully.');
    }

    /**
     * Detach a SOP from a machine.
     */
    public function detachSop($id, $sopId)
    {
        $machine = Machine::where('asset_no', $id)->firstOrFail();
        $machine->sops()->detach($sopId);

        return redirect()->route('machines.edit', $id)
            ->with('success', 'SOP unlinked from machine.');
    }

    /**
     * Delete a machine.
     */
    public function destroy($id){

        $machine = Machine::where('asset_no', $id)->firstOrFail();

        if ($machine->image_path && Storage::disk('public')->exists($machine->image_path)) {
            Storage::disk('public')->delete($machine->image_path);
        }

        $machine->delete();

        return redirect()
            ->route('machines.index')
            ->with('success', 'Machine deleted successfully.');
    }
}
