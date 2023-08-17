<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CityInterface;
use App\Repositories\Interfaces\StateRepositoryInterface;
use App\Repositories\StateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CobaController extends CustomController
{
    protected StateRepositoryInterface $stateRepo;

    public function __construct(StateRepositoryInterface $stateRepo)
    {
        $this->stateRepo = $stateRepo;
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

    public function detailcity($id)
    {
        $url = url("/api/v1/cities/{$id}?include=states.cities,states.countries.continents");

        $response = $this->requestGet($url);
        $city = $response['data'];
        $state = $city['included'][0];
        $country = $state['included'][0];
        $continent = $country['included'][0];

        $cities = collect($state['included'])->filter(function($item){
            return $item['entity']=='cities';
        });

        $cities = $cities->values();
        $city = Arr::except($city,['included','relationships']);
        $state = Arr::except($state,['included','relationships']);
        $country = Arr::except($country,['included','relationships']);

        // $continent = $response['include']['include']['include'];
        // $country = Arr::except($response['include']['include'],'include');
        // $stat = Arr::except($response['include'],'include');
        // $city = Arr::except($response,'include');

        return view('home.city',compact('city','cities','state','country','continent'));
    }
}
