<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Redis;

class CobaController extends Controller
{
    //
    public function index(Request $request)
    {
        $page = $request->get('page')??1;
        $url = url(route('v1.cities.index',[
            'page'=>$page
        ]));
        
        # buat key redis dari url request
        $keyRedis = md5($url);

        # mendapatkan etag yang tersimpan dalam redis
        $etag = Redis::get($keyRedis)??'';

        #melakukan request data cities
        $getData = Http::withHeaders([
            'Accept'=>'application/json',
            'Content-Type'=>'application/json',
            'If-None-Match'=>$etag,
        ])->withToken('7x0lHIA0ozP8S2J7FV7yOIXE72Iqw6LUExRP3Jjd')->get($url);

        $dataCities = [];
        $response = $getData->json();
        // dd($response,$url);
        $links = $getData->header('link');

        # jika status 200, maka simpan key dan etag kedalam redis
        if($getData->ok())
        {
            $body = $getData->body();
            $dataCities = json_decode($getData->body(),true);
            
            # simpan data dan etag baru ke redis
            $etagRedis = $getData->header('ETag');

            # simpan etag berdasarkan url param 
            Redis::set($keyRedis,$etagRedis);

            # simpan value berdasarkan etag 
            Redis::set($etagRedis,$body);
        }else if($getData->status()===304)
        {
            $dataCities = json_decode(Redis::get($etag),true);
        }else if($getData->badRequest())
        {
            return response('',404);
        }

        $cities = new LengthAwarePaginator(
            $dataCities['data'],
            $dataCities['meta']['total'],
            $dataCities['meta']['per_page'],
            $page
        );
        $cities->setPath(url()->current());
        $cities->appends($request->query());

        $dataCities = $cities->items();

        # mendapatkan states
        $url = url(route('v1.states.index'));
        
        # buat key redis dari url request
        $keyRedis = md5($url);

        # mendapatkan etag yang tersimpan dalam redis
        $etag = Redis::get($keyRedis)??'';

        #melakukan request data cities
        $getData = Http::withHeaders([
            'Accept'=>'application/json',
            'Content-Type'=>'application/json',
            'If-None-Match'=>$etag,
        ])->withToken('7x0lHIA0ozP8S2J7FV7yOIXE72Iqw6LUExRP3Jjd')->get($url);

        $states = [];
        $response = $getData->json();
        // dd($response,$url);
        $links = $getData->header('link');

        # jika status 200, maka simpan key dan etag kedalam redis
        if($getData->ok())
        {
            $body = $getData->body();
            $states = $getData->json();
            $states = $states['data'];
            
            # simpan data dan etag baru ke redis
            $etagRedis = $getData->header('ETag');

            # simpan etag berdasarkan url param 
            Redis::set($keyRedis,$etagRedis);
            
            # simpan value berdasarkan etag 
            Redis::set($etagRedis,$body);
        }else if($getData->status()===304)
        {
            $states = json_decode(Redis::get($etag),true);
            $states = $states['data'];
        }else if($getData->badRequest())
        {
            return response('',404);
        }

        return view('home.index',compact('cities','dataCities','states'));
        
    }
}
