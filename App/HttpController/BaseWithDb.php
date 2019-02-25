<?php

namespace App\HttpController;

use App\Utility\Pool\MysqlObject;
use App\Utility\Pool\MysqlPool;
use EasySwoole\Component\Pool\PoolManager;
use EasySwoole\EasySwoole\Config;
use EasySwoole\Validate\Validate;
use EasySwoole\Http\Message\Status;
use App\HttpController\Service\Token;
use EasySwoole\Http\AbstractInterface\Controller;
/**
 * 带数据库链接的控制器基类
 * Class BaseWithDb
 * @package App\HttpController
 */
abstract class BaseWithDb extends Controller
{
    protected $db;

    public function index() {

    }

    /**
     * 请求到来时 获取一个连接
     * @param string|null $action
     * @return bool|null
     * @throws \Exception
     */
    function onRequest(?string $action): ?bool
    {
        $timeout = Config::getInstance()->getConf('MYSQL.POOL_TIME_OUT');
        $mysqlObject = PoolManager::getInstance()->getPool(MysqlPool::class)->getObj($timeout);
        // 请注意判断类型 避免拿到非期望的对象产生误操作
        if ($mysqlObject instanceof MysqlObject) {
            $this->db = $mysqlObject;
        } else {
            //直接抛给异常处理，不往下
            throw new \Exception('url :' . $this->request()->getUri()->getPath() . ' error,Mysql Pool is Empty');
        }
        // 不要忘记 call parent
        return parent::onRequest($action);
    }
    protected function gc()
    {
        //正常连接
        $this->unsetMysqlPool();
        parent::gc();
    }
    protected function getDbConnection(): MysqlObject
    {
        return $this->db;
    }

    //异常时也需要回收连接池   
    protected function onException(\Throwable $throwable): void
    {
        $this->unsetMysqlPool();
        throw new \Exception( $throwable->getMessage(), $throwable->getCode());
    }

    private function unsetMysqlPool(){
        // 请注意 此处db是该链接对象的引用 即使操作了回收 仍然能访问
        // 安全起见 请一定记得设置为null 避免再次被该控制器使用导致不可预知的问题
        if ($this->db instanceof MysqlObject) {
            PoolManager::getInstance()->getPool(MysqlPool::class)->recycleObj($this->db);
            $this->db = null;
        }
    }

    protected function getParamOfKey($value, $default = null){
        return is_null($this->request()->getRequestParam($value)) ? $default : $this->request()->getRequestParam($value);
    }

    protected function getTokenVar($val = null){
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

        if(!is_null($val)){
            $res = $res[$val];
        }
        return [
            'code' => Status::CODE_OK,
            'data' => $res
        ];
    }
}