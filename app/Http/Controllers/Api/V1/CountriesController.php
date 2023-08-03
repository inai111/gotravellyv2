<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\CountriesFilter;
use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Http\Requests\V1\StoreCountriesRequest;
use App\Http\Requests\V1\UpdateCountriesRequest;
use App\Http\Resources\V1\CountryCollection;
use App\Http\Resources\V1\CountryResource;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $filter = new CountriesFilter();
        $filteredRequest = $filter->transform($request);
        
        $countries = Countries::where($filteredRequest);
        
        /**
         * menambahkan table lain dari @param include 
         */
        $include = $request->get('include');
        $arr_include = explode(',',$include);
        $arr_include = array_values(array_filter($arr_include,function($value){
            return !empty($value);
        }));

        if(count($arr_include)>0){
            $countries = $countries->with($arr_include);
        }

        return new CountryCollection($countries->paginate()->appends($request->query()));
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
    public function store(StoreCountriesRequest $request)
    {
        //
        return new CountryResource(Countries::create($request->all()));

    }

    /**
     * Display the specified resource.
     */
    public function show(Countries $country, Request $request)
    {
        //
        $include = $request->get('include');
        $arr_include = explode(',',$include);
        $arr_include = array_values(array_filter($arr_include,function($value){
            return !empty($value);
        }));

        if(count($arr_include)>0)
        {
            return new CountryResource($country->loadMissing($arr_include));
        }

        return new CountryResource($country);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Countries $countries)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCountriesRequest $request, Countries $country)
    {
        // no content
        return response($country->update($request->all()),204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Countries $countries)
    {
        //
    }
}
