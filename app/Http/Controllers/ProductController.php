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
        // INPUT
        $search = $request->input('search');

        // PROCESS
        $products = ProductSummary::where('line_id', session('selected_line_id'))
            ->with([
                'firstProductIn:id,part_number,time_in',
                'lastProductIn:id,product_out_id,part_number,time_in',
                'lastProductIn.productOut:id,tag_id,part_number,time_out',
            ])
            ->paginate(10, ['*'], 'page_products')
            ->withQueryString();

        $datas = ProductIn::where('line_id', session('selected_line_id'))
            ->select('id', 'product_out_id', 'part_id', 'part_number', 'time_in', 'quantity')
            ->with('productOut:id,tag_id,part_number,time_out')
            ->when($search, fn ($q) => $q->where('part_id', 'like', "%{$search}%"))
            ->orderBy('id', 'desc')
            ->paginate(10, ['*'], 'page_parts')
            ->withQueryString();

        // OUTPUT
        return view('products.index', compact('products', 'datas'));
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