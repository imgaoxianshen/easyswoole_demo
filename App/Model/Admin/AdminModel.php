<?php

namespace App\Model\Admin;

use App\Model\BaseModel;

class AdminModel extends BaseModel
{
    protected $table = 'admin';
    /*
     * 获取列表数据
     */
    // function getAll(int $page = 1, int $pageSize = 10) {
    //     $data = $this->getDbConnection()->withTotalCount()->orderBy('id', 'DESC')->get($this->table, [($page - 1) * $pageSize, $page * $pageSize]);
    //     $total = $this->getDbConnection()->getTotalCount();
    //     return ['data' => $data, 'total' => $total];
    // }
    // /*
    //  * 获取用户详情
    //  */
    // function getOne(int $uid) {
    //     $data = $this->getDbConnection()->where('uid', $uid)->getOne($this->table);
    //     return empty($data) ? null : $data;
    // }
    // /*
    //  * 修改用户信息
    //  */
    // function update(UserBean $userBean, $data):bool {
    //     $result = $this->getDbConnection()->where('id', $userBean->getId())->update($this->table, $data);
    //     return $result;
    // }
    // function insert(Array $data){
    //     return $this->getDbConnection()->insert($this->table,$data);
    // }

    function getOneByLogin(int $phone, string $password) {
        $data = $this->getDbConnection()->where('phone', $phone, '=' ,'and')->where('password', md5($password),'=','and')->getOne($this->table);
        return empty($data) ? null : $data;
    }
}