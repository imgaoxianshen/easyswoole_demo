<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/7/26
 * Time: 上午12:54
 */

namespace EasySwoole\Component\Pool;


use EasySwoole\Component\Singleton;

class PoolManager
{
    use Singleton;

    private $pool = [];


    function register(string $className, $maxNum = 20):?PoolConf
    {
       //注册一个连接池对象,以及新建一个带默认参数的连接池对象配置,并且返回它;
        $ref = new \ReflectionClass($className);
        if($ref->isSubclassOf(AbstractPool::class)){
            $conf = new PoolConf($className);
            $conf->setMaxObjectNum($maxNum);
            $this->pool[$this->generateKey($className)] = $conf;
            return $conf;
        }else{
            return null;
        }
    }

    /*
     * 请在进程克隆后，也就是worker start后，每个进程中独立使用
     */
    function getPool(string $className):?AbstractPool
    {
        $key = $this->generateKey($className);
        if(isset($this->pool[$key])){
            $item = $this->pool[$key];
            if($item instanceof AbstractPool){
                return $item;
            }else if($item instanceof PoolConf){
                $className = $item->getClass();
                $obj = new $className($item);
                $this->pool[$key] = $obj;
                return $obj;
            }
        }else if(class_exists($className)){
            if(!$this->register($className)){
                $config = clone $this->defaultConfig;
                $config->setClass($className);
                $pool = new class($config) extends AbstractPool{
                    protected function createObject()
                    {
                        // TODO: Implement createObject() method.
                        $className = $this->getPoolConfig()->getClass();
                        return new $className;
                    }
                };
                $this->pool[$key] = $pool;
            }
            return $this->getPool($className);
        }
        return null;
    }

    private function generateKey(string $class):string
    {//序列化一个class便于存储
        return substr(md5($class), 8, 16);
    }
}