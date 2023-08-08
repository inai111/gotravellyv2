<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\ContinentsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreContinentsRequest;
use App\Models\Continents;
use App\Http\Requests\V1\StoreContinentsRequest;
use App\Http\Requests\V1\UpdateContinentsRequest;
use App\Http\Resources\V1\ContinentCollection;
use App\Http\Resources\V1\ContinentsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
        $arr_include = array_values(array_filter($arr_include,function($value){
            return !empty($value);
        }));

        if(count($arr_include)>0){
            $continent = $continent->with($arr_include);
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
        return new ContinentsResource(Continents::create($request->all()));
    }

    /**
     * store a multiple resource in storage
     */
    public function storebulk(BulkStoreContinentsRequest $request)
    {
        if(Continents::insert($request->all()))
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
    public function show(Continents $continent,Request $request)
    {
        $include = $request->get('include');
        $arr_include = explode(',',$include);
        $arr_include = array_values(array_filter($arr_include,function($value){
            return !empty($value);
        }));

        if(count($arr_include)>0)
        {
            return new ContinentsResource($continent->loadMissing($arr_include));
        }

        return new ContinentsResource($continent);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Continents $continents,)
    {
        //
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContinentsRequest $request, Continents $continent)
    {
        // no content
        return response($continent->update($request->all()),204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Continents $continents)
    {
        //
    }
}
