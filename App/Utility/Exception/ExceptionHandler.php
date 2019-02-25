<?php

namespace  App\Utility\Exception;

use EasySwoole\Http\Request;
use EasySwoole\Http\Response;

class ExceptionHandler
{
    public static function handle( \Throwable $exception, Request $request, Response $response )
    {
        $data = Array(
            "code"=>  $exception->getCode(),
            "result"=> '',
            "msg"=> $exception->getMessage()
        );
        $response->write(json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        $response->withHeader('Content-type','application/json;charset=utf-8');
        $response->withStatus(200);
        return true;
    }

}