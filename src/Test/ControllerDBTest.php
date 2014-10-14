<?php
/**
 * 遥控器数据表测试类
 *
 * User: snake
 * Date: 14-6-15
 * Time: 下午7:44
 */

class ControllerDBTest extends \PHPUnit_Framework_TestCase {
    protected $db;

    function __construct()
    {
        $this->db = new medoo(DBFileConfig::$dbinfo);
    }

    public function testInsert(){
//        $model = new \Snake\ControllerDB($this->db);
//        $id = $model->insert(
//            'testProtocol',
//            '1111',
//            '测试遥控器的名称',
//            'testSeries',
//            '9999',
//            '9998',
//            'testLogo',
//            '1');
//        $this->assertEquals(113,$id,'测试插入遥控器数据库');
    }

    /**
     * @test
     */
    public function getControllersNumber(){
//        $model = new \Snake\ControllerDB($this->db);
//        $n = $model->getControllersNumber();
//        $this->assertTrue($n > 0,'测试');
    }

    /**
     * @test
     */
    public function getControllersDescLimit100(){
//        $model = new \Snake\ControllerDB($this->db);
//        $r = $model->getControllersDescLimit100();
//        $this->assertTrue(count($r)>0,'测试');
    }
}
 