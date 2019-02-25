<?php

namespace App\HttpController;

use EasySwoole\Validate\Validate;
use EasySwoole\Http\Message\Status;
use App\HttpController\Service\Token;

class BaseWithLogin extends BaseWithDb
{
    protected $userInfo = null;

    /**
     * 请求到来时 获取一个连接
     * @param string|null $action
     * @return bool|null
     * @throws \Exception
     */
    function onRequest(?string $action): ?bool
    {
        $this->beforeAction();
        return parent::onRequest($action);
    }

    private function beforeAction(){
        $token = $this->request()->getHeaders('token');
        $validate = new Validate();
        $validate->addColumn('token')->required('token必填');
        if (!$this->validate($validate)) {
            return [
                'code' => Status::CODE_LOGIN_ERROR,
                'data' => $validate->getError()->__toString()
            ];
        }
        
        $res = Token::getCurrentTokenVar($token);

        if(!$res){
            return [
                'code' => Status::CODE_LOGIN_ERROR,
                'data' => '登陆过期,请重新登陆'
            ];
        }

        $this->userInfo = $res;
        
    }

}