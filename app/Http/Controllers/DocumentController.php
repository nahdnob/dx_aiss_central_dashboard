<?php

namespace App\Http\Controllers;

class DocumentController extends Controller
{
    /**
     * Show the documents landing page with quick access
     */
    public function index()
    {
        return view('documents.index');
    }
}
