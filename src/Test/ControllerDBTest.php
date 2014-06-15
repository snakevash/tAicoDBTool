<?php
/**
 * 遥控器数据表测试类
 *
 * User: snake
 * Date: 14-6-15
 * Time: 下午7:44
 */

class ControllerDBTest extends PHPUnit_Framework_TestCase {
    protected $db;

    function __construct()
    {
        $this->db = new medoo(DBFileConfig::$dbinfo);
    }

    public function testInsert(){

    }
}
 