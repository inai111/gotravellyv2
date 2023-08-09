<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\CitiesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreCitiesRequest;
use App\Models\Cities;
use App\Http\Requests\V1\StoreCitiesRequest;
use App\Http\Requests\V1\UpdateCitiesRequest;
use App\Http\Resources\V1\CityCollection;
use App\Http\Resources\V1\CityResource;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $filter = new CitiesFilter();
        $filteredRequest = $filter->transform($request);
        
        $cities = Cities::where($filteredRequest);
        
        /**
         * menambahkan table lain dari @param include 
         */
        $include = $request->get('include');
        $arr_include = explode(',',$include);
        $arr_include = array_values(array_filter($arr_include,function($value){
            return !empty($value);
        }));

        if(count($arr_include)>0){
            $cities = $cities->with($arr_include);
        }

        return new CityCollection($cities->paginate()->appends($request->query()));
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
    public function store(StoreCitiesRequest $request)
    {
        //
        return new CityResource(Cities::create($request->all()));
    }

    /**
     * store a multiple resource in storage
     */
    public function storebulk(BulkStoreCitiesRequest $request)
    {
        if(Cities::insert($request->all()))
        {
            $message = "INSERT_BULK_OK";
            return response()->json(['message'=>$message],201);
        }

        $message = "INSERT_BULK_ERR";
        return response()->json(['message'=>$message],500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cities $city,Request $request)
    {
        //
        $include = $request->get('include');
        $arr_include = explode(',',$include);
        $arr_include = array_values(array_filter($arr_include,function($value){
            return !empty($value);
        }));

        if(count($arr_include)>0)
        {
            return new CityResource($city->loadMissing($arr_include));
        }

        return new CityResource($city);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cities $city)
    {
        //
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCitiesRequest $request, Cities $city)
    {
        //
        # no content
        return response($city->update($request->all()),204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cities $city)
    {
        $city->delete();
        return response('',204);
    }
}
