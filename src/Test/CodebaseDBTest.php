<?php

/**
 * 红外代码测试
 *
 * User: snake
 * Date: 14-6-15
 * Time: 下午10:24
 */
class CodebaseDBTest extends PHPUnit_Framework_TestCase
{
    protected $db;

    function __construct()
    {
        $this->db = new medoo(DBFileConfig::$dbinfo);
    }

    /**
     * @test
     */
    public function update()
    {
//        $model = new \Snake\CodebaseDB($this->db);
//        $r = $model->update(
//            '0',32,'FF00','0','A810016822E6118E022D022E022D068AB659000000FF00FF',
//            '00FF00FF',50,0,1,0);
//        $this->assertTrue(!!$r,'测试更新代码库');
    }

    /**
     * @test
     */
    public function getCodeID()
    {
//        $model = new \Snake\CodebaseDB($this->db);
//        $r = $model->getCodeID('电源','5');
//        $this->assertTrue(!!$r,'测试更新代码库');
    }

    /**
     * @test
     */
    public function deleteByCodeIDs()
    {
//        $codeids = array(1,2,3);
//        $model = new \Snake\CodebaseDB($this->db);
//        $r = $model->deleteByCodeIDs($codeids);
//        $this->assertTrue($r,'测试删除多个codeids');
    }

    /**
     * @test
     */
    public function isInsertedByCodeDisplayNameAndCodeController()
    {
//        $params = array('C-20-A','1');
//        $model = new \Snake\CodebaseDB($this->db);
//        $r = $model->isInsertedByCodeDisplayNameAndCodeController($params[0],$params[1]);
//        $this->assertTrue($r,'测试查找按键是否插入过');
    }

    /**
     * @test
     */
    public function arrayDiff()
    {
//        $a1 = array(1,2,3,4,5,6,7,8);
//        $a2 = array(4,5,6,7,8,9,10,12);
//        $r = array_diff($a1,$a2);
    }

    /**
     * @test
     */
    public function getOneControllerAllCodeids()
    {
//        $model = new \Snake\CodebaseDB($this->db);
//        $r = $model->getOneControllerAllCodeids('1');
//        $this->assertTrue(is_array($r),'测试获得某个遥控器所有建制');
    }
}
 