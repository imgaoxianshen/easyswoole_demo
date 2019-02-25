<?php

namespace App\HttpController\Service;

use EasySwoole\Component\Di;

//token类
class Token
{
    private $salt = 'imgaoxianshen';

    public static function getCurrentTokenVar($token){
        $vars =  Di::getInstance()->get('REDIS')->get($token);
        if(!$vars){
            //返回错误信息
            return false;
        }

        return json_decode($vars,true);
    }

    public function generateToken(){
        $randChars = self::getRandChars(32);
        $timestamp = time();
        //加盐
        $salt = $this->salt;
        return md5($randChars.$timestamp.$salt);
    }

    private static function getRandChars($length){
        $str = null;
        $strPol = 'ABCDEFGHIJKMNOPQRSTUVWXYZ0123456789abcdefghijkmnopqrstuvwxyz';
        $max = strlen($strPol)-1;
        for($i =0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];
        }
        return $str;
    }
}