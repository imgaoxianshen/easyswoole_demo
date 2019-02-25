<?php

namespace App\Model\User;

use EasySwoole\Spl\SplBean;

class UserBean extends SplBean
{
    protected $id;   
    protected $money;
    protected $openId;
    protected $mobile; 
    protected $nickname;
    protected $createTime;
    protected $updateTime;
    protected $deleteTime;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
    /**
     * @return mixed
     */
    public function getMoney()
    {
        return $this->money;
    }
    /**
     * @param mixed $money
     */
    public function setMoney($money): void
    {
        $this->money = $money;
    }
    /**
     * @return mixed
     */
    public function getOpenId()
    {
        return $this->openId;
    }
    /**
     * @param mixed $openId
     */
    public function setOpenId($openId): void
    {
        $this->openId = $openId;
    }
}