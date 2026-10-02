<?php

namespace App\Http\Controllers;

use App\Models\LinePerformance;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class LinePerformanceController extends Controller
{
	public static function index() {
										
		$linePerformances = LinePerformance::select('id', 'line_id', 'month', 'year', 'target', 'actual')
										   ->where('line_id', session('selected_line_id'))
										   ->orderBy('year', 'desc')
										   ->orderByRaw("FIELD(month,'January','February','March','April','May','June', 'July','August','September','October','November','December') DESC")
										   ->paginate(10);

		return view('line-performances.index', compact('linePerformances'));
	}

	public function search(Request $request) {

		$q     = $request->q;
		$group = $request->group;

		$query = LinePerformance::select('id', 'line_id', 'month', 'year', 'target', 'actual')
								->where('line_id', session('selected_line_id'));

		if ($q) {
			$query->where(function ($q2) use ($q) {
				$q2->where('month', 'like', "%$q%")->orWhere('year', 'like', "%$q%");
			});
		}

		if ($group === 'month') {
			$query->selectRaw('month, SUM(target) as target, SUM(actual) as actual')->groupBy('month');
		}

		if ($group === 'year') {
			$query->selectRaw('year, SUM(target) as target, SUM(actual) as actual')->groupBy('year');
		}

		if ($group === 'month_year') {
			$query->selectRaw('month, year, SUM(target) as target, SUM(actual) as actual')->groupBy('month', 'year');
		}

		return response()->json($query->get());
	}

	public function store(Request $request):RedirectResponse {

		//validate form
		$request->validate([
			'line-performance-month'  => 'required|string',
			'line-performance-year'   => 'required|string',
			'line-performance-target' => 'required|regex:/^\d+(\.\d{1,2})?$/',
			'line-performance-actual' => 'required|regex:/^\d+(\.\d{1,2})?$/',
		]);

		$targetValue = str_replace(',', '.', $request->input('line-performance-target'));
		$actualValue = str_replace(',', '.', $request->input('line-performance-actual'));

		//create product
		LinePerformance::create([
			'month'         => $request->input('line-performance-month'),
			'year'          => $request->input('line-performance-year'),
			'target'        => $targetValue,
			'actual'        => $actualValue,
			'line_id'       => session('selected_line_id'),
		]);

		//redirect to dashboard
		return redirect()->route('line-performance.index')->with(['success' => 'Data Berhasil Disimpan!']);
	}

	public function edit(string $id) {

		//get product by ID
		$linep = LinePerformance::select('id', 'line_id', 'month', 'year', 'target', 'actual')->findOrFail($id);

		//return JSON response
		return response()->json($linep);
	}

	public function update(Request $request, $id):RedirectResponse {

		// Validasi input
		$request->validate([
			'month'  => 'required|string',
			'year'   => 'required|string',
			'target' => 'required|regex:/^\d+(\.\d{1,2})?$/',
			'actual' => 'required|regex:/^\d+(\.\d{1,2})?$/',
		]);

		// Mengambil produk berdasarkan ID dan memperbarui datanya
		$linep = LinePerformance::select('id', 'line_id', 'month', 'year', 'target', 'actual')->findOrFail($id);
	
		$targetValue = str_replace(',', '.', $request->input('target'));
		$actualValue = str_replace(',', '.', $request->input('actual'));

		$linep->update([
			'month'  => $request->input('month'),
			'year'   => $request->input('year'),
			'target' => $targetValue,
			'actual' => $actualValue,
		]);

		// Redirect atau mengembalikan respon setelah update
		return redirect()->route('line-performance.index')->with(['success' => 'Data Berhasil Diupdate!']);
	}

	public function destroy($id){
		
		$linePerformance = LinePerformance::findOrFail($id);
		
    	$linePerformance->delete();

    return redirect()->route('line-performance.index')->with(['success' => 'Data Berhasil Dihapus!']);
	}
}
