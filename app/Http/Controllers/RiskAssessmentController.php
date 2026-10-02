<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\RiskAssessment;
use Illuminate\Http\Request;

class RiskAssessmentController extends Controller
{
    /**
     * Show Risk Assessment document page
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = RiskAssessment::where('line_id', session('selected_line_id'))->with('line');

        if ($search) {
            $query->where(function ($q2) use ($search) {
                $q2->where('name', 'like', "%$search%")
                   ->orWhere('ra_no', 'like', "%$search%");
            });
        }

        $riskAssessments = $query->orderBy('created_at', 'desc')->paginate(6);
        $lines           = Line::orderBy('name')->get();

        return view('documents.risk-assesment.index', compact('riskAssessments', 'lines'));
    }

    /**
     * Store new Risk Assessment document
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'ra_no'            => 'nullable|string|unique:risk_assessments,ra_no',
            'ra_level'         => 'nullable|integer|between:1,4',
            'ra_security_rank' => 'nullable|in:A,C,E',
            'ra_file'          => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        $validated['line_id'] = session('selected_line_id');
        $validated['link']    = $request->file('ra_file')->store('risk_assessments', 'public');

        RiskAssessment::create($validated);

        return redirect()->route('risk-assessments.index')->with('success', 'Risk Assessment document created successfully.');
    }

    /**
     * Update Risk Assessment document
     */
    public function update(Request $request, RiskAssessment $riskAssessment)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'ra_no'            => 'nullable|string|unique:risk_assessments,ra_no,' . $riskAssessment->id,
            'ra_level'         => 'nullable|integer|between:1,4',
            'ra_security_rank' => 'nullable|in:A,C,E',
            'ra_file'          => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        if ($request->hasFile('ra_file')) {
            $validated['link'] = $request->file('ra_file')->store('risk_assessments', 'public');
        }

        $riskAssessment->update($validated);

        return redirect()->route('risk-assessments.index')->with('success', 'Risk Assessment document updated successfully.');
    }

    /**
     * Delete Risk Assessment document
     */
    public function destroy(RiskAssessment $riskAssessment)
    {
        $riskAssessment->delete();
        return redirect()->route('risk-assessments.index')->with('success', 'Risk Assessment document deleted successfully.');
    }
}
