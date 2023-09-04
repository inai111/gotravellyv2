<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\StateCollection;
use App\Models\Continents;
use App\Models\Countries;
use App\Models\States;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CollectionController extends CustomController
{
    //
    public function getstates(Request $request)
    {
        $data = QueryBuilder::for(States::class)
        ->allowedFilters(['countries.id'])
        ->get();

        $data = new StateCollection($data);

        // # mendapatkan states

        $component = view('components.form.select.option',compact('data'))->render();

        $return = [
            'view'=>$component,
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

    public function getcontinents(Request $request)
    {
        $data = QueryBuilder::for(Continents::class)
        ->allowedFilters(['name','countries.name'])
        ->allowedIncludes(['countries.states'])
        ->get();

        $component = view('components.form.select.option',compact('data'))->render();

        $return = [
            'view'=>$component,
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

    public function getcountries(Request $request)
    {
        $data = QueryBuilder::for(Countries::class)
        ->allowedFilters(['continents.id'])
        ->get();

        $component = view('components.form.select.option',compact('data'))->render();

        $return = [
            'view'=>$component,
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

    public function getFirstInitOptionContinent(Request $request)
    {
        $continentId = $request->get('continentId');
        $data = QueryBuilder::for(Continents::class)
        ->allowedIncludes(['countries','states','cities']);
    }
}
