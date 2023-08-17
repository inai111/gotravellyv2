<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\ContinentCollection;
use App\Models\Continents;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CollectionController extends CustomController
{
    //
    public function getstates(Request $request)
    {
        # mendapatkan states
        $url = url(route('v1.states.index',[
            'page'=>$request->get('page')??1
        ]));
        
        $response = $this->requestGet($url);
        if(!isset($response['data'])) return response()->json('',500);

        $response = $this->paginate($response,$request);
        // dd($response->nextPageUrl());
        $data = $response->getCollection();

        $component = view('components.option',compact('data'))->render();

        $return = [
            'view'=>$component,
            'nextPageUrl'=>$response->nextPageUrl(),
        ];
        
        # untuk di simpan di sessionStorage
        $generateEtag = md5(json_encode($return));

        $etag = $request->header('If-None-Match')??'';
        if($generateEtag===$etag){
            return response('',304);
        }
        return response()->json($return,200)->withHeaders([
            'ETag'=>$generateEtag
        ]);
    }

    public function getcontinents()
    {
        $continents = QueryBuilder::for(Continents::class)
        ->allowedFilters(['name'])
        ->allowedIncludes(['countries.states'])
        ->get();
        return new ContinentCollection($continents);
    }
}
