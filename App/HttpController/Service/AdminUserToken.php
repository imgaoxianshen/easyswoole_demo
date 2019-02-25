<?php

namespace App\HttpController\Service;

use App\Model\Admin\AdminModel;
use EasySwoole\Component\Di;
use EasySwoole\EasySwoole\Config;
use EasySwoole\Http\Message\Status;

class AdminUserToken extends Token
{
    protected $phone;
    protected $password;
    protected $adminModel;

    function __construct($phone = '',$password = '',$db = null){
        $this->phone = $phone;
        $this->password = $password;
        $this->adminModel = $db;
    }

    public function unsetToken($token){
        $result = Di::getInstance()->get('REDIS')->del($token);
        return $result;
    }

    public function getAdmin(){
        $model = new AdminModel($this->adminModel);
        $adminUser = $model->getOneByLogin($this->phone, $this->password);
        if(!$adminUser){
            throw new \Exception('账号或者密码错误,请检查完再来~',Status::CODE_REDIS_ERROR); 
        }

        $cachedValue = [
            'nickname' => $adminUser['nickname'],
            'uid' => $adminUser['id'],
            'role' => 1
        ];

        $token = $this->saveToCache($cachedValue);
        return $token;
    }
    
    private function saveToCache($cachedValue){
        $key = $this->generateToken();
        $value = json_encode($cachedValue);
        $expire_in = Config::getInstance()->getConf('REDIS')['token_expire_in'];
        $result = Di::getInstance()->get('REDIS')->set($key,$value,$expire_in);
        if(!$result){
            throw new \Exception('服务器缓存异常',Status::CODE_REDIS_ERROR);
        }
        return $key;
    }

    
}