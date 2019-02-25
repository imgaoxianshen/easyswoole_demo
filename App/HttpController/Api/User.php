<?php

namespace App\HttpController\Api;

use EasySwoole\Validate\Validate;
use EasySwoole\Http\Message\Status;
use App\HttpController\Service\Token;
use App\HttpController\Service\UserToken;
use App\HttpController\BaseWithDb;

class User extends BaseWithDb
{
    
    public function login(){
        $code = $this->request()->getRequestParam('code');
        $userToken = new UserToken($code,$this->db);
        $token = $userToken->get();
        return $this->writeJson(Status::CODE_OK,'',$token);
    }

    //获取登陆信息
    public function isLogin(){
        $tokenVar = $this->getTokenVar();

        if($tokenVar['code'] != Status::CODE_OK){
            throw new \Exception($tokenVar['data'], $tokenVar['code']);
        }

        return $this->writeJson(Status::CODE_OK,'',$tokenVar['data']);
    }

}