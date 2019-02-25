<?php

namespace App\Model;

use App\Utility\Pool\MysqlObject;

class BaseModel
{
    private $db;
    function __construct(MysqlObject $db)
    {
        $this->db = $db;
    }
    function getDbConnection():MysqlObject
    {
        return $this->db;
    }
}