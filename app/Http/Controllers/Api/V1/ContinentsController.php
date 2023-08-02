<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\ContinentsFilter;
use App\Http\Controllers\Controller;
use App\Models\Continents;
use App\Http\Requests\StoreContinentsRequest;
use App\Http\Requests\UpdateContinentsRequest;
use App\Http\Resources\V1\ContinentCollection;
use App\Http\Resources\V1\ContinentsResource;
use Illuminate\Http\Request;

class ContinentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /**
         * @param String include
         * @param String sort
         * @param Array name
         * @param Array fields
         */

        $filter = new ContinentsFilter();
        $filteredRequest = $filter->transform($request);
        
        $continent = Continents::where($filteredRequest);
        
        /**
         * menambahkan table lain dari @param include 
         */
        $include = $request->get('include');
        $arr_include = explode(',',$include);

        if(in_array('countries',$arr_include)){
            $continent = $continent->with('countries');
        }

        return new ContinentCollection($continent->paginate()->appends($request->query()));
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
    public function show(Continents $continent,Request $request)
    {
        $include = $request->get('include');
        $arr_include = explode(',',$include);

        if(in_array('countries',$arr_include)){
            return new ContinentsResource($continent->loadMissing('countries'));
        }

        return new ContinentsResource($continent);
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
