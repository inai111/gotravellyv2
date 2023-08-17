<?php
namespace App\Repositories;

use App\Models\States;
use App\Repositories\Interfaces\StateRepositoryInterface;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class StateRepository implements StateRepositoryInterface
{

    public function getAll(Request $request)
    {
        QueryBuilder::for(States::class)
        ->allowedFilters(['name'])
        ->allowedSorts(['name'])
        ->paginate()
        ->appends($request->query());
    }
}