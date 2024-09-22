<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        return view('lokasi');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
