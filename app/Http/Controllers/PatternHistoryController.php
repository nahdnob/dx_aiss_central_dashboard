<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatternHistory;

class PatternHistoryController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'pattern' => 'required|exists:patterns,id',
            'line_id' => 'required|exists:lines,id',
        ]);

        $latestPattern = PatternHistory::where('line_id', $request->line_id)->latest()->first();

        if(!$latestPattern || $latestPattern->pattern_id != $request->pattern){
            PatternHistory::create([
                'pattern_id' => $request->pattern,
                'line_id'    => $request->line_id,
            ]);

            return redirect()->back()
            ->with('success', 'Pattern has been successfully changed');
        }

        return redirect()->back();
    }
}
