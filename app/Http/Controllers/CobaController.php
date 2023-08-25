<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\CountryCollection;
use App\Http\Resources\V1\CountryResource;
use App\Models\Continents;
use App\Models\Countries;
use App\Repositories\Interfaces\CityInterface;
use App\Repositories\Interfaces\StateRepositoryInterface;
use App\Repositories\StateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\QueryBuilder;

class CobaController extends CustomController
{
    protected StateRepositoryInterface $stateRepo;

    public function __construct(StateRepositoryInterface $stateRepo)
    {
        $this->stateRepo = $stateRepo;
    }

    public function index(Request $request)
    {
        $paramQuery = [];
        if($request->get('page')) $paramQuery['page'] = $request->get('page');
        $filter = $request->get('filter')??[];
        foreach($filter as $key=>$val){
            if($key=='name') $paramQuery["{$key}"]['like']="%{$val}%";
            // if($key=='countryId') $paramQuery["cities.states.countryId}"]['eq']=$val;
            else $paramQuery["{$key}"]['eq']=$val;
        }
        $page = $request->get('page')??1;
        $url = url(route('v1.cities.index',$paramQuery));
        
        $response = $this->requestGet($url);
        if(!isset($response['data'])) return abort(500);
        
        $response = $this->paginate($response,$request);
        
        // dd($response->getCollection());
        
        $dataCities = $response;
        
        # mendapatkan  continents
        $url = url(route('v1.continents.index'));

        $response = $this->requestGet($url);
        if(!isset($response['data'])) return abort(500);

        $dataContinents = $response['data'];

        # mendapatkan states
        $filter = $request->get('filter');
        $continentId = $filter['continentId']??'';
        $countryId   = $filter['countryId']??'';
        $stateId     = $filter['stateId']??'';
        // $url = url("/api/v1/continents/$continentId?continents.id[eq]=$continentId&countries.id[eq]=$countryId&countries.states.id[eq]=$stateId&include=countries.states.cities");
        
        // $response = $this->requestGet($url);
        $dataOption = [];
        if($continentId){
            $countries = Countries::where('continent_id',$continentId);

            if($countryId){
                $countries = $countries->with('states',function($query) use($countryId){
                    return $query->where('country_id',$countryId);
                });
                
                // if($stateId) $countries = $countries->with('states.cities',function($query) use($stateId){
                //     return $query->where('state_id',$stateId);
                // });
            }
            $countries = $countries->get();
            $states = [];
            // $country = $countries->where('id',$countryId)->first();
            if($countryId){
                $country = $countries->where('id',$countryId)->first();
                $states = $country->when($country['states'],function($collection,$i){
                    return $i;
                });
            }
            $dataOption = [
                'countries'=>$countries,
                'states'=>$states,
            ];
        }
        if(!isset($response['data'])) return abort(500);
        
        return view('home.index',compact('dataCities','dataContinents','dataOption'));
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
