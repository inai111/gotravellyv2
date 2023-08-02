<?php

namespace App\Http\Controllers;

use App\Models\Continents;
use App\Http\Requests\StoreContinentsRequest;
use App\Http\Requests\UpdateContinentsRequest;

class ContinentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreContinentsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Continents $continents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Continents $continents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContinentsRequest $request, Continents $continents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Continents $continents)
    {
        //
    }
}
