<?php

namespace App\Http\Controllers;

//import model
use App\Models\ProductSummary;
use App\Models\ProductIn;
use App\Services\Production\SummaryService;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private SummaryService $summaryService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('products.index', [
            ...$this->summaryData(),
            ...$this->logData($request),
        ]);
    }

    public function summary()
    {
        return response()
            ->view('products.partials.summary', $this->summaryData())
            ->header('Cache-Control', 'no-store');
    }

    public function log(Request $request)
    {
        return response()
            ->view('products.partials.log', $this->logData($request))
            ->header('Cache-Control', 'no-store');
    }

    private function summaryData(): array
    {
        $lineId = session('selected_line_id');

        $timeOutSub = ProductIn::query()
            ->join('product_outs', 'product_outs.id', '=', 'product_ins.product_out_id')
            ->whereColumn('product_ins.line_id', 'product_summaries.line_id')
            ->whereColumn('product_ins.id', '>=', 'product_summaries.first_id')
            ->whereColumn('product_ins.id', '<=', 'product_summaries.last_id')
            ->selectRaw('MAX(product_outs.time_out)');

        $products = ProductSummary::where('line_id', $lineId)
            ->select('product_summaries.*')
            ->addSelect(['last_time_out' => $timeOutSub])
            ->with('firstProductIn:id,part_number,time_in')
            ->orderByDesc(
                ProductIn::select('time_in')
                    ->whereColumn('product_ins.id', 'product_summaries.first_id')
            )
            ->orderByDesc('product_summaries.id')
            ->paginate(10, ['*'], 'page_products')
            ->withPath(route('products.index'))
            ->withQueryString();

        $totalIn   = ProductSummary::where('line_id', $lineId)->sum('qty_in');
        $totalOut  = ProductSummary::where('line_id', $lineId)->sum('qty_out');
        $runningId = ProductSummary::where('line_id', $lineId)->max('id');

        return compact('products', 'totalIn', 'totalOut', 'runningId');
    }

    private function logData(Request $request): array
    {
        $search = $request->input('search');
        $lineId = session('selected_line_id');

        $datas = ProductIn::where('line_id', $lineId)
            ->select('id', 'product_out_id', 'part_id', 'part_number', 'time_in', 'quantity')
            ->with('productOut:id,tag_id,part_number,time_out')
            ->when($search, fn ($q) => $q->where('part_id', 'like', "%{$search}%"))
            ->orderBy('time_in', 'desc')
            ->paginate(10, ['*'], 'page_parts')
            ->withPath(route('products.index'))
            ->withQueryString();

        return compact('datas');
    }
}