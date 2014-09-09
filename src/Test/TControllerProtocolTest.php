<?php

/**
 * 测试协议-遥控器关系表
 *
 * User: snake
 * Date: 14-9-4
 * Time: 下午2:27
 */
class TControllerProtocolTest extends PHPUnit_Framework_TestCase
{
    protected $db;

    function __construct()
    {
        $this->db = new medoo(DBFileConfig::$dbinfo);
    }

    /**
     * @test
     */
    public function getProtocolInfoFromControllerID()
    {
//        $model = new \Snake\TControllerProtocol($this->db);
//        $r = $model->getProtocolInfoFromControllerID(307);
//        $this->assertTrue(count($r) > 0, '测试');
    }

    /**
     * @test
     */
    public function isProtocolInUser(){
//        $model = new \Snake\ControllerProtocolDB($this->db);
//        $r = $model->isProtocolInUser(10000);
//        $this->assertTrue(count($r)>0,'测试');
    }

    /**
     * @test
     */
    public function getControllerProtocolMore2(){
//        $model = new \Snake\TControllerProtocol($this->db);
//        $r = $model->getControllerProtocolMore2();
//        $this->assertTrue(count($r)>0,'测试');
    }

    /**
     * @test
     */
    public function getProtocolIDsByControllerID(){
//        $model = new \Snake\ControllerProtocolDB($this->db);
//        $r = $model->getProtocolIDsByControllerID("6");
//        $this->assertTrue(count($r)>0,'测试');
    }
}
 