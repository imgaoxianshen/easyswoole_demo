<?php

namespace App\Model\Order;

use App\Model\BaseModel;

class OrderModel extends BaseModel
{
    protected $table = 'order';
    /*
     * 获取列表数据
     */
    function getAll(int $page = 1, int $pageSize = 10) {
        $data = $this->getDbConnection()->withTotalCount()->orderBy('id', 'DESC')->get($this->table, [($page - 1) * $pageSize, $pageSize]);
        $total = $this->getDbConnection()->getTotalCount();

        if(!empty($data)){
            foreach($data as &$d){
                $d['create_time'] = date('Y-m-d H:i:s', $d['create_time']);
            }
        }
        return ['data' => $data, 'total' => $total];
    }

    /*
     * 修改运单号
     */
    function updateLogisticNo(int $id, $logisticNo):bool {
        $data = [
            'logisticNo' => $logisticNo
        ];
        $result = $this->getDbConnection()->where('id', $id)->update($this->table, $data);
        return $result;
    }
    /*
     * 获取订单
     */
    function getOne(int $uid) {
        $data = $this->getDbConnection()->where('uid', $uid)->getOne($this->table);
        return empty($data) ? null : $data;
    }
    
    // function insert(Array $data){
    //     return $this->getDbConnection()->insert($this->table,$data);
    // }

    
}