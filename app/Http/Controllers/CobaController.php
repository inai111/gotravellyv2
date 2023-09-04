<?php

namespace App\Http\Controllers;

use App\Http\Requests\V1\StoreCitiesRequest;
use App\Models\Countries;
use App\Models\States;
use App\Repositories\Interfaces\StateRepositoryInterface;
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
        $paramQuery = [];
        if($request->get('page')) {
            $paramQuery['page'] = $request->get('page');
        }

        $filter = $request->get('filter')??[];
        foreach($filter as $key=>$val){
            if($key=='name') {
                $paramQuery["{$key}"]['like']="%{$val}%";
            }
            else{
                $paramQuery["{$key}"]['eq']=$val;
            }
        }
        $page = $request->get('page')??1;
        $url = url(route('v1.cities.index',$paramQuery));
        
        $response = $this->requestGet($url);
        if(!isset($response['data'])){
            return abort(500);
        }
        
        $response = $this->paginate($response,$request);

        $dataCities = $response;
        
        # mendapatkan  continents
        $url = url(route('v1.continents.index'));

        $response = $this->requestGet($url);
        if(!isset($response['data'])){
            return abort(500);
        }

        $dataContinents = $response['data'];

        # mendapatkan states
        $filter = $request->get('filter');
        $continentId = $filter['continentId']??'';
        $countryId   = $filter['countryId']??'';
        $stateId     = $filter['stateId']??'';

        $dataOption = [];
        if($continentId){
            $countries = Countries::where('continent_id',$continentId);

            if($countryId){
                $countries = $countries->with('states',function($query) use($countryId){
                    return $query->where('country_id',$countryId);
                });
            }
            $countries = $countries->get();
            $states = [];
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
        if(!isset($response['data'])){
            return abort(500);
        }
        $title = 'asdads1111';

        return view('home.index',compact('dataCities','dataContinents','dataOption','title'));
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

        return view('home.city',compact('city','cities','state','country','continent'));
    }

    public function createcity()
    {
        #mendapatkan semua continent
        $continents= $this->requestGet(route('v1.continents.index'))['data'];
        return view('cities.create');
    }

    public function storecity()
    {
        dd(request());
        #mendapatkan semua continent
        dd($this->requestGet(route('v1.continents.index')));
        return view('cities.create');
    }

    public function createstate()
    {
        return view('state.create');
    }

    public function editstate(States $state)
    {
        return view('state.edit',compact('state'));
    }

    public function updatestate(States $state, Request $request)
    {
        $response = $this->requestPut(route('v1.states.update',['state'=>$state->id]),$request->only('name'));
        if($response->ok()){
            return redirect()->to(route('state.detail',['state'=>$state->id]))
            ->with('message','data state telah di update');
        }
        dd($response->json());
    }

    public function storestate(Countries $country, Request $request)
    {
        $dataRequest = [
            'name'=>$request->post('name'),
            'countryId'=>$country->id
        ];
        #langsung kirim tanpa validasi, validasi di api saja
        $response = $this->requestPost(route('v1.states.store'),$dataRequest);
        if($response->ok()){
            return redirect()->to(route('country.show',['country'=>$country->id]))
            ->with('message','state baru telah ditambahkan!');
        }
        $response = $response->json();
        $message = $response['message'];
        $errors = $response['errors'];

        return redirect()->back()->with('message',$message)->withErrors($errors);
    }

    public function detailcountry($id)
    {
        $response = $this->requestGet(route('v1.countries.show',['country'=>$id,'include'=>'continents,states']));
        $country = [];
        if(!empty($response)){
            $country = $response['data'];
            $continent = $states =[];
            if(isset($country['included'])){
                $states = Arr::where($country['included'],function($item)use(&$continent){
                    if($item['entity']=='continents') $continent = $item;
                    return $item['entity']==='states';
                });
            }
        }
        return view('country.detail',compact('country','continent','states'));
    }
}
