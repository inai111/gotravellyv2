<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\States;
use App\Http\Requests\StoreStatesRequest;
use App\Http\Requests\UpdateStatesRequest;

class StatesController extends Controller
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
    public function store(StoreStatesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(States $states)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(States $states)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatesRequest $request, States $states)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(States $states)
    {
        //
    }
}
