<?php

namespace App\HttpController\Admin;

use EasySwoole\Validate\Validate;
use EasySwoole\Http\Message\Status;
use App\HttpController\Service\Token;
use App\HttpController\Service\AdminUserToken;
use App\HttpController\BaseWithDb;

class User extends BaseWithDb
{
    
    public function login(){
        $phone = $this->request()->getRequestParam('phone');
        $password = $this->request()->getRequestParam('password');
        $validate = new Validate();
        $validate->addColumn('phone')->required('手机号必填')->allDigital('手机号必须是数字');
        $validate->addColumn('password')->required('密码必填');

        if (!$this->validate($validate)) {
            throw new \Exception($validate->getError()->__toString(),Status::CODE_LOGIN_ERROR);
        }

        $adminUserToken = new AdminUserToken($phone, $password,$this->db);
        $token = $adminUserToken->getAdmin();
        return $this->writeJson(Status::CODE_OK,'',$token);
    }

    public function loginOut(){
        $token = $this->request()->getHeaders('token');
        $adminUserToken = new AdminUserToken();
        $res = $adminUserToken->unsetToken($token);
        if(!$res){
            throw new \Exception('退出登陆失败',Status::CODE_LOGIN_ERROR);
        }

        return $this->writeJson(Status::CODE_OK,'','');
    }

    // //获取登陆信息
    // public function isLogin(){
    //     $tokenVar = $this->getTokenVar();

    //     if($tokenVar['code'] != Status::CODE_OK){
    //         throw new \Exception($tokenVar['data'], $tokenVar['code']);
    //     }

    //     return $this->writeJson(Status::CODE_OK,'',$tokenVar['data']);
    // }

}