<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\EasySwoole;

use App\lib\ConsumerTest;
use App\lib\Redis\Redis;
use App\Utility\Pool\MysqlPool;
use App\Utility\Exception\ExceptionHandler;
use EasySwoole\Component\Di;
use EasySwoole\Component\Pool\PoolManager;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Utility\File;
use EasySwoole\EasySwoole\ServerManager;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');
        // PoolManager::getInstance()->register(MysqlPool::class, Config::getInstance()->getConf('MYSQL.POOL_MAX_NUM'));
        PoolManager::getInstance()->register(MysqlPool::class, Config::getInstance()->getConf('MYSQL.POOL_MAX_NUM'))->setMinObjectNum((int)Config::getInstance()->getConf('MYSQL.POOL_MIN_NUM'));//min_num不能大于或等于max_num
        Di::getInstance()->set(SysConst::HTTP_EXCEPTION_HANDLER,[ExceptionHandler::class,'handle']);
        self::loadConf();
    }

    /**
     * 加载配置文件
     *
     * @return void
     */
    public static function loadConf() {
        $files = File::scanDirectory(EASYSWOOLE_ROOT.'/App/Config');
        if(is_array($files)){
            foreach($files['files'] as $file){
                $fileNameArr = explode('.', $file);
                $fileSuffix = end($fileNameArr);
                if($fileSuffix == 'php') {
                    Config::getInstance()->loadFile($file);
                }elseif($fileSuffix == 'env'){
                    Config::getInstance()->loadEnv($file);
                }
            }
        }
    }

    public static function mainServerCreate(EventRegister $register)
    {
        // 依赖注入
        Di::getInstance()->set('REDIS', Redis::getInstance());
        // TODO: Implement mainServerCreate() method.
            // TODO: Implement mainServerCreate() method.
        $allNum = 3;
        for ($i = 0 ;$i < $allNum;$i++){
            ServerManager::getInstance()->getSwooleServer()->addProcess((new ConsumerTest("consumer_{$i}"))->getProcess());
        }
    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }

    public static function onReceive(\swoole_server $server, int $fd, int $reactor_id, string $data):void
    {

    }

}