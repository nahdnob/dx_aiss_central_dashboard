<?php

namespace App\Http\Controllers;

use App\Models\Dasg;
use App\Models\Line;
use App\Models\RiskAssessment;
use App\Models\Sop;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SopController extends Controller
{
    public function index(Request $request)
    {
        // INPUT
        $search = $request->input('search');
        $lineId = session('selected_line_id');
        $query  = Sop::where('line_id', $lineId)->with(['riskAssessment', 'dasgs', 'line']);

        if ($search) {
            $query->where(function ($q2) use ($search) {
                $q2->where('name', 'like', "%$search%")
                   ->orWhere('sop_no', 'like', "%$search%");
            });
        }

        // PROCESS
        $sops            = $query->orderBy('created_at', 'desc')->paginate(6);
        $riskAssessments = RiskAssessment::where('line_id', $lineId)->orderBy('created_at', 'desc')->get();
        $dasgs           = Dasg::where('line_id', $lineId)->orderBy('created_at', 'desc')->get();
        $lines           = Line::orderBy('name')->get();

        // OUTPUT
        return view('documents.sop.index', compact('sops', 'riskAssessments', 'dasgs', 'lines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'sop_no'   => 'nullable|string|unique:sops,sop_no',
            'link'     => 'nullable|string|max:255',
            'sop_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
            'ra_id'    => 'nullable|exists:risk_assessments,id',
        ]);

        $validated['line_id'] = session('selected_line_id');

        if ($request->hasFile('sop_file')) {
            $validated['link'] = $request->file('sop_file')->store('sops', 'public');
        }

        $sop = Sop::create(collect($validated)->except('ra_id')->toArray());

        // update RA yang dipilih supaya nunjuk ke SOP ini
        if ($request->filled('ra_id')) {
            RiskAssessment::where('id', $request->ra_id)->update(['sop_id' => $sop->id]);
        }

        return redirect()->route('documents.sop')->with('success', 'SOP document created successfully.');
    }

    public function update(Request $request, Sop $sop){

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'sop_no'   => 'nullable|string|unique:sops,sop_no,' . $sop->id,
            'link'     => 'nullable|string|max:255',
            'revision' => 'required|integer|min:1',
            'sop_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
            'ra_id'    => 'nullable|integer|exists:risk_assessments,id',
        ]);

        if ($request->hasFile('sop_file')) {
            // hapus file lama biar tidak numpuk sampah
            if ($sop->link) {
                Storage::disk('public')->delete($sop->link);
            }
            $validated['link'] = $request->file('sop_file')->store('sops', 'public');
        }

        $sop->update(collect($validated)->except('ra_id')->toArray());

        // Lepas RA lama yang sebelumnya nunjuk ke SOP ini (kalau ganti RA)
        RiskAssessment::where('sop_id', $sop->id)
            ->where('id', '!=', $request->ra_id)
            ->update(['sop_id' => null]);

        // Pasang RA baru (kalau dipilih)
        if ($request->filled('ra_id')) {
            RiskAssessment::where('id', $request->ra_id)->update(['sop_id' => $sop->id]);
        }

        $dasgIds = $request->input('dasg_ids', []);
        $sop->dasgs()->sync($dasgIds);

        return redirect()->route('documents.sop')->with('success', 'SOP document updated successfully.');
    }

    public function destroy(Sop $sop)
    {
        $sop->delete();

        return redirect()->route('documents.sop')->with('success', 'SOP document deleted successfully.');
    }
}
