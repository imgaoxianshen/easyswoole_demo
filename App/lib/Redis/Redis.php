<?php
namespace App\lib\Redis;

use EasySwoole\Component\Singleton;

class Redis
{
    use Singleton;

    public $redis = '';

    private function __construct() {
        if(!extension_loaded('redis')){
            throw new \Exception('redis扩展不存在');
        }
        try{
            $redisConfig = \Yaconf::get('redis');
            $this->redis = new \Redis();
            $result = $this->redis->connect($redisConfig['host'],$redisConfig['port'],$redisConfig['time_out']);
        }catch(\Exception $e){
            throw new \Exception('redis服务异常');
        }

        if($result == false){
            throw new \Exception('redis连接失败');
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $key
     * @return void
     */
    public function get($key){
        if(empty($key)){
            return '';
        }
        return $this->redis->get($key);
    }

    public function set($key, $value, $expire = null){
        if(empty($key)){
            return false;
        }
        return $this->redis->set($key,$value,$expire);
    }

    public function del($key){
        if(empty($key)){
            return '';
        }
        return $this->redis->del($key);
    }

    public function lpop($key){
        if(empty($key)){
            return '';
        }
        return $this->redis->lpop($key);
    }
}