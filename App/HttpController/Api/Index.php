<?php

namespace App\HttpController\Api;

use App\lib\Redis\Redis;
use App\Utility\Pool\MysqlPool;
use EasySwoole\Component\Di;
use EasySwoole\Component\Pool\PoolManager;
use EasySwoole\EasySwoole\Config;
use App\HttpController\Service\Dypls;
use App\HttpController\BaseWithDb;

Class Index extends BaseWithDb
{
    public function video() {
        return $this->response()->write('asd');
    }

    public function getVideo() {
        $db = PoolManager::getInstance()->getPool(MysqlPool::class)->getObj(Config::getInstance()->getConf('MYSQL.POOL_TIME_OUT'));
        $table_name = 'video';
        $data = $db->getOne($table_name,'*');
        // 销毁
        PoolManager::getInstance()->getPool(MysqlPool::class)->recycleObj($db);
        return $this->writeJson(200,'',$data);
    }

    public function getRedis() {
        $result = Di::getInstance()->get('REDIS')->get('shuaibi');
        return $this->writeJson(200,'',$result);
    }

    public function bindPhone(){
        $sypls = Dypls::bindAxn(15669762297);
        // return $this->writeJson(200,'',$sypls);    
        var_dump($sypls);    
    }

    public function yaconf(){
        $result = \Yaconf::get('redis');
        return $this->writeJson(200,'OK',$result);
    }
}