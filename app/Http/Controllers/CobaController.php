<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CityInterface;
use Illuminate\Http\Request;

class CobaController extends CustomController
{
    protected $citiRepo;

    public function __construct(CityInterface $cityRepo)
    {
        $this->citiRepo = $cityRepo;
    }

    public function index(Request $request)
    {
        $page = $request->get('page')??1;
        $url = url(route('v1.cities.index',[
            'page'=>$page
        ]));
        
        $response = $this->requestGet($url);
        if(!isset($response['data'])) return abort(500);
        
        $response = $this->paginate($response,$request);
        
        // dd($response->getCollection());
        
        $dataCities = $response;
        
        # mendapatkan states
        $url = url(route('v1.states.index'));
        
        $response = $this->requestGet($url);
        if(!isset($response['data'])) return abort(500);
        
        $response = $this->paginate($response,$request);

        $dataStates = $response;

        return view('home.index',compact('dataCities','dataStates'));
    }
}
