<?php

namespace App\HttpController\Api;

use App\HttpController\BaseWithDb;
use EasySwoole\Validate\Validate;
use EasySwoole\Http\Message\Status;
use App\HttpController\Service\Token;
use App\HttpController\Service\UserToken;
use App\Model\CarCard\CarCardModel;

class Card extends BaseWithDb
{
    
    //获取登陆信息
    public function getCarCardList(){
        $tokenVar = $this->getTokenVar('uid');
        var_dump($tokenVar);
        if($tokenVar['code'] != Status::CODE_OK){
            throw new \Exception($tokenVar['data'], $tokenVar['code']);
        }

        $page =  empty($this->request()->getRequestParam('page')) ? 1: $this->request()->getRequestParam('page');
        $pageSize = empty($this->request()->getRequestParam('pageSize')) ? 10 : $this->request()->getRequestParam('pageSize');

        $uid = $tokenVar['data'];
        $CarCardModel = new CarCardModel($this->db);
        $list = $CarCardModel->getAll($page, $pageSize);
        return $this->writeJson(Status::CODE_OK,'',$list);
    }
}