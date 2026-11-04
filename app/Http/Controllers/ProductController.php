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
    public function index(Request $request) {
        
        // INPUT
        $search = $request->input('search');
        $lineId = session('selected_line_id');

        $timeOutSub = ProductIn::query()
            ->join('product_outs', 'product_outs.id', '=', 'product_ins.product_out_id')
            ->whereColumn('product_ins.line_id', 'product_summaries.line_id')
            ->whereColumn('product_ins.id', '>=', 'product_summaries.first_id')
            ->whereColumn('product_ins.id', '<=', 'product_summaries.last_id')
            ->selectRaw('MAX(product_outs.time_out)');

        // PROCESS
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
            ->withQueryString();

        $totalIn  = ProductSummary::where('line_id', $lineId)->sum('qty_in');
        $totalOut = ProductSummary::where('line_id', $lineId)->sum('qty_out');

        $datas = ProductIn::where('line_id', $lineId)
            ->select('id', 'product_out_id', 'part_id', 'part_number', 'time_in', 'quantity')
            ->with('productOut:id,tag_id,part_number,time_out')
            ->when($search, fn ($q) => $q->where('part_id', 'like', "%{$search}%"))
            ->orderBy('time_in', 'desc')
            ->paginate(10, ['*'], 'page_parts')
            ->withQueryString();

        // OUTPUT
        $runningId = ProductSummary::where('line_id', $lineId)->max('id');

        return view('products.index', compact('products', 'datas', 'totalIn', 'totalOut', 'runningId'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}