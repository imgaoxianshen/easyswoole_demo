<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/4
 * Time: 12:05 PM
 */

namespace EasySwoole\Component\Pool;


class PoolConf
{
    protected $class;//当前连接池对象名称
    protected $intervalCheckTime = 30*1000;//定时验证对象是否可用的间隔时间
    protected $maxIdleTime = 15;//最大存活时间,超出则会每$intervalCheckTime/1000秒被释放
    protected $maxObjectNum = 20;//最大创建数量
    protected $minObjectNum = 5;//最小创建数量
    protected $getObjectTimeout = 0.5;//连接池对象获取连接对象时的等待时间

    protected $extraConf = [];//额外参数

    function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }


    /**
     * @return float|int
     */
    public function getIntervalCheckTime()
    {
        return $this->intervalCheckTime;
    }

    /**
     * @param float|int $intervalCheckTime
     */
    public function setIntervalCheckTime($intervalCheckTime): void
    {
        $this->intervalCheckTime = $intervalCheckTime;
    }

    /**
     * @return int
     */
    public function getMaxIdleTime(): int
    {
        return $this->maxIdleTime;
    }

    /**
     * @param int $maxIdleTime
     */
    public function setMaxIdleTime(int $maxIdleTime): void
    {
        $this->maxIdleTime = $maxIdleTime;
    }

    /**
     * @return int
     */
    public function getMaxObjectNum(): int
    {
        return $this->maxObjectNum;
    }

    /**
     * @param int $maxObjectNum
     */
    public function setMaxObjectNum(int $maxObjectNum): void
    {
        $this->maxObjectNum = $maxObjectNum;
    }

    /**
     * @return float
     */
    public function getGetObjectTimeout(): float
    {
        return $this->getObjectTimeout;
    }

    /**
     * @param float $getObjectTimeout
     */
    public function setGetObjectTimeout(float $getObjectTimeout): void
    {
        $this->getObjectTimeout = $getObjectTimeout;
    }

    /**
     * @return array
     */
    public function getExtraConf(): array
    {
        return $this->extraConf;
    }

    /**
     * @param array $extraConf
     */
    public function setExtraConf(array $extraConf): void
    {
        $this->extraConf = $extraConf;
    }

    /**
     * @return int
     */
    public function getMinObjectNum(): int
    {
        return $this->minObjectNum;
    }

    /**
     * @param int $minObjectNum
     */
    public function setMinObjectNum(int $minObjectNum): void
    {
        $this->minObjectNum = $minObjectNum;
    }

}