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
     * Display selected database
     */
    public function index(Request $request)
    {
        // 1. Get search parameter from query string
        $search = $request->input('search');

        // 2. Base query: select specific columns, count sops relation, filter by active line
        $query = Machine::select('id', 'asset_no', 'asset_name', 'acquisition_date', 'line_id')
                        ->withCount('sops as sops_count')
                        ->where('line_id', session('selected_line_id'));

        // 3. Additional filter if search input exists
        if ($search) {

            // 4. Grouped where to avoid conflict with where('line_id') above
            $query->where(function ($q) use ($search) {

                // 4.1. Match against asset_no OR asset_name
                $q->where('asset_no', 'like', "%{$search}%")->orWhere('asset_name', 'like', "%{$search}%");
            });
        }

        // 5. Sort by newest, paginate 10/page, preserve query string on page change
        $machines = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // 6. Return view with machines data
        return view('machines.index', compact('machines'));
    }

    /**
     * Store a new machine to the database.
     */
    public function store(Request $request)
    {
        // 1. Validate input request with custom error message
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

        // 2. Checking request File uploaded has file
        if ($request->hasFile('image_path')) {

            // 2.1. Put file uploaded
            $file = $request->file('image_path');

            // 2.2. Generate unique file name (random string 40 char + real extension) - to void collision/overwrite with the same name
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();

            // 2.3. Save object file to storage/app/public/machines/images
            $file->storeAs('machines/images', $filename, 'public');

            // 2.4. Overwrite image_path value in array $validated with file name
            $validated['image_path'] = $filename;
        }

        // 3. Insert new record to machines tabel with validated data
        Machine::create($validated);

        // 4. Redirect to index page with flash message success
        return redirect()->route('machines.index')->with('success', 'Machine added successfully.');
    }

    /**
     * Show machine detail page.
     */
    public function show($id)
    {
        // 1. Find machine by asset_no
        $machine = Machine::where('asset_no', $id)
                          ->with(['sops.riskAssessment','sops.dasgs',])
                          ->firstOrFail();

        // 2. Shortcut variable machine's sops collection
        $sops = $machine->sops;

        // 3. Flatten dasgs from all sops into one collection
        $allDasgs = $sops->flatMap(fn($sop) => $sop->dasgs)
                         // 3.1. Remove duplicate dasgs
                         ->unique('id')
                         // 3.2. Sort alphabetically by name
                         ->sortBy('name')
                         // 3.3. Reset collection keys to sequential index after filter/sort
                         ->values();

        // 4. Return view with machine, sops, and aggregated dasgs
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
        // 1. Find machine by asset_no, eager load its linked sops
        $machine = Machine::where('asset_no', $id)->with('sops')->firstOrFail();

        // 2. Extract IDs of sops already linked to this machine
        $linkedSopIds = $machine->sops->pluck('id')->toArray();

        // 3. Get sops NOT yet linked to this machine
        $availableSops = Sop::whereNotIn('id', $linkedSopIds)->orderBy('name')->get();

        // 4. Return view with machine and available sops
        return view('machines.edit', compact(
            'machine',
            'availableSops'
        ));
    }

    /**
     * Update machine information.
     */
    public function update(Request $request, $id)
    {
        // 1. Find machine by asset_no
        $machine = Machine::where('asset_no', $id)->firstOrFail();

        // 2. Validate input request
        $validated = $request->validate([
            'asset_name'       => 'required|string|max:255',
            'acquisition_date' => 'nullable|date',
            'manufacturer'     => 'nullable|string|max:255',
            'image_path'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'model'            => 'nullable|string|max:255',
            'status'           => 'nullable|string|max:255',
        ]);

        // 3. Checking request file uploaded has file
        if ($request->hasFile('image_path')) {

            // 3.1. Delete old image if it exists on disk
            if (
                $machine->image_path &&
                Storage::disk('public')->exists('machines/images/' . $machine->image_path)
            ) {
                Storage::disk('public')->delete('machines/images/' . $machine->image_path);
            }

            // 3.2. Put file uploaded
            $file = $request->file('image_path');

            // 3.3. Generate unique file name (random string 40 char + real extension) - to avoid collision/overwrite with the same name
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();

            // 3.4. Save object file to storage/app/public/machines/images
            $file->storeAs('machines/images', $filename, 'public');

            // 3.5. Overwrite image_path value in array $validated with file name
            $validated['image_path'] = $filename;
        }

        // 4. Force line_id to current active session line (prevent tampering via unauthorized reassignment)
        $validated['line_id'] = session('selected_line_id');

        // 5. Update machine record with validated data
        $machine->update($validated);

        // 6. Redirect back to edit page with flash message success
        return redirect()->route('machines.edit', $id)->with('success', 'Machine information updated successfully.');
    }

    /**
     * Attach a SOP to a machine (many-to-many via machine_sop).
     */
    public function attachSop(Request $request, $id)
    {
        
        // 1. Find machine by asset_no
        $machine = Machine::where('asset_no', $id)->firstOrFail();

        // 2. Validate sop_id exists
        $request->validate(['sop_id' => 'required|integer|exists:sops,id',]);

        // 3. Get sop_id from request
        $sopId = $request->input('sop_id');

        // 4. Attach sop to machine only if not already linked (prevent duplicate pivot row)
        if (!$machine->sops()->where('sop_id', $sopId)->exists()) {

            $machine->sops()->attach($sopId);
        }

        // 5. Redirect back to edit page with flash message success
        return redirect()->route('machines.edit', $id)->with('success', 'SOP linked to machine successfully.');
    }

    /**
     * Detach a SOP from a machine.
     */
    public function detachSop($id, $sopId)
    {
        // 1. Find machine by asset_no
        $machine = Machine::where('asset_no', $id)->firstOrFail();

        // 2. Detach sop from machine (remove pivot row in machine_sop table)
        $machine->sops()->detach($sopId);

        // 3. Redirect back to edit page with flash message success
        return redirect()->route('machines.edit', $id)->with('success', 'SOP unlinked from machine.');
    }

    /**
     * Delete a machine.
     */
    public function destroy($id)
    {
        // 1. Find machine by asset_no
        $machine = Machine::where('asset_no', $id)->firstOrFail();

        // 2. Delete associated image exists
        if ($machine->image_path && Storage::disk('public')->exists($machine->image_path)) {

            Storage::disk('public')->delete($machine->image_path);
        }

        // 3. Delete machine record from database
        $machine->delete();

        // 4. Redirect to index page with flash message success
        return redirect()->route('machines.index')->with('success', 'Machine deleted successfully.');
    }
}
