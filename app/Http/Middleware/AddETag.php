<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddETag
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        # mendapatkan request ke dalam bentuk Response
        $response = $next($request);
        
        # hanya get yang akan return 304 atau new etag
        if($request->getMethod()!=="GET") return $response;
        
        # mendapatkan isi response dan membuat etag menggunakan md5
        $etag = md5($request->getContent());
        $response->header('ETag',$etag);

        #cek apakah ada header if-none-match dari Request
        $requestEtag = $request->header('if-none-match')??'';

        # jika tidak sama, maka kembalikan response yang berisi data
        if($etag !== $requestEtag) return  $response;

        return response('',304)->header('ETag',$etag);
    }
}
