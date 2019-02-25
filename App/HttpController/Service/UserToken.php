<?php

namespace App\HttpController\Service;

use App\lib\Curl\Curl;
use App\Model\User\UserModel;
use EasySwoole\Component\Di;
use EasySwoole\EasySwoole\Config;
use EasySwoole\Http\Message\Status;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl = 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code';
    protected $userModel;

    function __construct($code, $db = null){
        $wechatConfig = Config::getInstance()->getConf('WECHAT');
        $this->code = $code;
        $this->wxAppID = $wechatConfig['wxAppID'];
        $this->wxAppSecret = $wechatConfig['wxAppSecret'];
        $this->wxLoginUrl = sprintf($this->wxLoginUrl,
            $this->wxAppID,$this->wxAppSecret,$this->code);
        $this->userModel = $db;
    }

    public function get(){
        $request = new Curl();
        $content = $request->request('GET',$this->wxLoginUrl)->getBody();
        $wxResult = json_decode($content, TRUE);

        if(empty($wxResult)){
            throw new Exception('获取session_key以及openID时异常，微信内部错误');
        }else{
            $loginFail = array_key_exists('errcode',$wxResult);
            if($loginFail){
                //返回失败 
                throw new \Exception('获取登陆信息失败',400);
            }else{
                //成功
                return $this->grantToken($wxResult);
            }
        }
    }

    private function grantToken($wxResult){
        $openId = $wxResult['openid'];
        $model = new UserModel($this->userModel);
        $user = $model->getByOpenID($openId);

        if($user){
            $uid = $user['id'];
        }else{
            $uid = $this->newUser($openId);
        }
        $cachedValue = $this->prepareCachedValue($wxResult,$uid);
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

    private function prepareCachedValue($wxResult,$uid){
        $cachedValue = $wxResult;
        $cachedValue['uid']=$uid;
        return $cachedValue;
    }


    private function newUser($openId){
        $model = new UserModel($this->userModel);
        $data = $model->insert([
            'openId' => $openId,
            'createTime' => time()
        ]);
        
        return $data;
    }

}