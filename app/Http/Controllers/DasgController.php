<?php

namespace App\Http\Controllers;

use App\Models\Dasg;
use App\Models\Line;
use Illuminate\Http\Request;

class DasgController extends Controller
{
    /**
     * Show DASg document page
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query  = Dasg::select('id', 'name', 'detail_standard', 'revision', 'link', 'line_id')
                      ->where('line_id', session('selected_line_id'))
                      ->with(['line' => function ($q) {
                          $q->select('id', 'name');
                      }]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('detail_standard', 'like', "%$search%");
            });
        }

        $dasgs = $query->orderBy('created_at', 'desc')->paginate(6);
        $lines = Line::orderBy('name')->get();

        return view('documents.dasg.index', compact('dasgs', 'lines'));
    }

    /**
     * Store new DASg document
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'detail_standard' => 'nullable|string',
            'sop_no'          => 'prohibited',
            'ra_no'           => 'prohibited',
            'dasg_file'       => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        $validated['line_id'] = session('selected_line_id');
        $validated['link'] = $request->file('dasg_file')->store('dasgs', 'public');

        Dasg::create($validated);

        return redirect()->route('dasgs.index')->with('success', 'DASg document created successfully.');
    }

    /**
     * Update DASg document
     */
    public function update(Request $request, Dasg $dasg)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'detail_standard' => 'nullable|string',
            'revision' => 'required|integer|min:1',
            'line_id'  => 'nullable|integer|exists:lines,id',
            'dasg_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        if ($request->hasFile('dasg_file')) {
            $validated['link'] = $request->file('dasg_file')->store('dasgs', 'public');
        }

        $dasg->update($validated);

        return redirect()->route('dasgs.index')->with('success', 'DASg document updated successfully.');
    }

    /**
     * Delete DASg document
     */
    public function destroy(Dasg $dasg)
    {
        $dasg->delete();
        return redirect()->route('dasgs.index')->with('success', 'DASg document deleted successfully.');
    }
}
