<?php

namespace App\Http\Controllers;

use App\Models\Ncd;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class BestRecordController extends Controller
{
    public function index(Request $request){
        
        $q     = $request->input('search');
        $query = Ncd::where('line_id', session('selected_line_id'));

        if ($q) {

            $query->where(function ($q2) use ($q) {

                $q2->where('date', 'like', "%{$q}%")
                   ->orWhere('claim', 'like', "%{$q}%")
                   ->orWhere('action', 'like', "%{$q}%");
            });
        }

        $ncds = $query->orderBy('date', 'desc')->paginate(10);

        return view('best-records.index', compact('ncds'));
    }

    public function store(Request $request):RedirectResponse{
        
		//validate form
		$request->validate([
			'date'   => 'required|date',
			'claim'  => 'required|string',
			'action' => 'required|string',
		],[
            'date.required'   => 'Tanggal is required!',
            'claim.required'  => 'Claim is required!',
            'action.required' => 'Action is required!',
        ]);

		//create product
		Ncd::create([
			'date'          => $request->input('date'),
			'claim'         => $request->input('claim'),
			'action'        => $request->input('action'),
			'line_id'       => session('selected_line_id'),
		]);

		//redirect to dashboard
		return redirect()->route('best-records.index')->with(['success' => 'Data Berhasil Disimpan!']);
	}

    public function update(Request $request, $id):RedirectResponse{
        
        //validate form
        $request->validate([
            'date'   => 'required|date',
            'claim'  => 'required|string',
            'action' => 'required|string',
        ],[
            'date.required'   => 'Tanggal is required!',
            'claim.required'  => 'Claim is required!',
            'action.required' => 'Action is required!',
        ]);

        $ncd = Ncd::findOrFail($id);
        $ncd->update($request->all());

        return redirect()->route('best-records.index')->with(['success' => 'Data Berhasil Diperbarui!']);
    }

    public function destroy($id):RedirectResponse{

        $ncd = Ncd::findOrFail($id);
        $ncd->delete();

        return redirect()->route('best-records.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}