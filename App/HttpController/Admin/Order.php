<?php
//订单
namespace App\HttpController\Admin;

// use EasySwoole\Validate\Validate;
use App\Model\Order\OrderModel;
use EasySwoole\Http\Message\Status;
// use App\HttpController\Service\Token;
// use App\HttpController\Service\AdminUserToken;
use App\HttpController\BaseWithLogin;

class Order extends BaseWithLogin
{
    //获取订单列表
    public function getOrderList(){
        $page = $this->getParamOfKey('page', 1);
        $pageSize = $this->getParamOfKey('pageSize', 10);
        $model = new OrderModel($this->db);
        $data = $model->getAll($page, $pageSize);
        return $this->writeJson(Status::CODE_OK,'',$data);
    }

    //修改运单号
    public function changeLogisticNo(){
        $id = $this->getParamOfKey('id');
        $logisticNo = $this->getParamOfKey('logisticNo');
        $model = new OrderModel($this->db);
        $data = $model->updateLogisticNo($id, $logisticNo);
        return $this->writeJson(Status::CODE_OK,'',$data);
    }

}