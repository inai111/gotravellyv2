<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class CustomController extends Controller
{
    /**
     * function untuk melakukan request GET
     * dan menyimpan data dan url kedalam
     * redis agar dapat digunakan kembali
     */
    protected function requestGet(string $url)
    {
        # buat key redis dari url request
        $keyRedis = md5($url);
        $token = session()->get('authToken');
        $etag = '';

        if (Redis::cekKoneksiServer()) {
            # mendapatkan etag yang tersimpan dalam redis
            $etag = Redis::get($keyRedis) ?? $etag;
        }

        #melakukan request data cities
        $getData = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'If-None-Match' => $etag,
        ])->withToken($token)->get($url);

        $data = [];

        # jika status 200, maka simpan key dan etag kedalam redis
        if ($getData->ok()) {
            $body = $getData->body();

            # simpan data dan etag baru ke redis
            $etagRedis = $getData->header('ETag');

            if (Redis::cekKoneksiServer()) {
                # simpan etag berdasarkan url param 
                Redis::set($keyRedis, $etagRedis);

                # simpan value berdasarkan etag 
                Redis::set($etagRedis, $body);
            }

            $data = $getData->json();
        } else if ($getData->status() === 304) {
            $data = json_decode(Redis::get($etag), true);
        }
        return $data;
    }

    /**
     * function untuk melakukan request POST
     * @param String $url url lengkap dari api, post tidak memiliki parameter
     * @param Array $data isi dari form yang akan di kirimkan ke api
     * @return Object setting kembalian melalui controller masing masing
     */
    protected function requestPost(string $url,array $data)
    {
        $json = json_encode($data);

        #melakukan request data cities
        $getData = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->withBody($json)->post($url);

        return $getData;
    } 

    /**
     * @param Array $response kembalian dari request getAll yang isinya [data=>[], meta=>[], links=>[]]
     * @param Request $request
     * @return LengthAwarePaginator
     */
    protected function paginate($response, Request $request)
    {
        $page = $request->get('page')??1;
        return new LengthAwarePaginator(
            $response['data'],
            $response['meta']['total'],
            $response['meta']['per_page'],
            $page,
            [
                "path"=>url()->current(),
                'query'=>$request->query()
            ]
        );
    }
}