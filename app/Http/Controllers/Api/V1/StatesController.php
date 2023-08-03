<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\StatesFilter;
use App\Http\Controllers\Controller;
use App\Models\States;
use App\Http\Requests\V1\StoreStatesRequest;
use App\Http\Requests\V1\UpdateStatesRequest;
use App\Http\Resources\V1\StateCollection;
use App\Http\Resources\V1\StateResource;
use Illuminate\Http\Request;

class StatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $filter = new StatesFilter();
        $filteredRequest = $filter->transform($request);
        
        $states = States::where($filteredRequest);
        
        /**
         * menambahkan table lain dari @param include 
         */
        $include = $request->get('include');
        $arr_include = explode(',',$include);
        $arr_include = array_values(array_filter($arr_include,function($value){
            return !empty($value);
        }));

        if(count($arr_include)>0){
            $states = $states->with($arr_include);
        }

        return new StateCollection($states->paginate()->appends($request->query()));
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
        return new StateResource(States::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(States $state, Request $request)
    {
        //
        $include = $request->get('include');
        $arr_include = explode(',',$include);
        $arr_include = array_values(array_filter($arr_include,function($value){
            return !empty($value);
        }));

        if(count($arr_include)>0)
        {
            return new StateResource($state->loadMissing($arr_include));
        }

        return new StateResource($state);
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
    public function update(UpdateStatesRequest $request, States $state)
    {
        //
        return response($state->update($request->all()),204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(States $states)
    {
        //
    }
}
