<?php

namespace App\Traits;

trait HttpResponse{

    /**
     * @param Array $data
     * @param String $message
     * @param HttpCode $code
     * @param Array $headers
     */
    protected function success($data, $message=null, $code=200,array $headers=[])
    {
        return response()->withHeaders($headers)->json([
            'data'=>$data,
            'message'=>$message,
        ],$code);
    }

    protected function error($data, $message=null, $code=400,array $headers=[])
    {
        return response()->withHeaders($headers)->json([
            'data'=>$data,
            'message'=>$message,
        ],$code);
    }
}