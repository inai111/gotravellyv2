<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\CategoriesFilter;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Http\Requests\V1\StoreCategoriesRequest;
use App\Http\Requests\V1\UpdateCategoriesRequest;
use App\Http\Resources\V1\CategoryCollection;
use App\Http\Resources\V1\CategoryResource;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $filter = new CategoriesFilter();
        $filteredRequest = $filter->transform($request);

        $categories = Categories::where($filteredRequest);

        return new CategoryCollection($categories->paginate()->appends($request->all()));
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
    public function store(StoreCategoriesRequest $request)
    {
        //
        return new CategoryResource(Categories::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $category)
    {
        //
        return new CategoryResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriesRequest $request, Categories $category)
    {
        //
        return response($category->update($request->all()),204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $categories)
    {
        //
    }
}
