<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

if (!function_exists('httpApiGet')) {
    /**
     * kumpulan koding untuk melakukan request get
     * dari pengecekan etag, pengecekan data hingga
     * menyimpan kembali data dan etag di redis.
     * @param string url uasdrl lengkap beserta parameternya
     * @param string token plainText dari token user
     * @return array data dari api
     */
    function httpApiGet(string $url, string $token): array
    {
        # buat key redis dari url request
        $keyRedis = md5($url);
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

        $data = [
            'ok'=>true
        ];

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
            // $data = json_decode(Redis::get($etag), true);
            $data = 'asdasd';
        }

        return $data;
    }
}