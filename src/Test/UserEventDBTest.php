<?php
/**
 * 
 * User: snake
 * Date: 14-10-14
 * Time: 下午5:47
 */

class UserEventDBTest extends PHPUnit_Framework_TestCase {
    protected $db;

    function __construct()
    {
        $this->db = new medoo(DBFileConfig::$dbinfo);
    }

    /**
     * @test
     */
    public function getUserAffectedControllers(){
//        $model = new \Snake\UserEventDB($this->db);
//
//        $r = $model->getUserAffectedControllers(array(313));
//
//        $this->assertTrue(count($r) > 0,'测试');
    }

    /**
     * @test
     */
    public function getUserLayout(){
//        $model = new \Snake\UserEventDB($this->db);
//
//        $r = $model->getUserLayout(66,313);
//
//        $this->assertTrue(count($r) > 0,'测试');
    }

    /**
     * @test
     */
    public function getUserScenarioAffected(){
        $s = new \Snake\Services\UserEventServices();
        $s->getUserAffectedInfo(66,313);

        $this->assertTrue(count($s)>0,'测试');
    }

    /**
     * @test
     */
    public function getUserScenarios(){
//        $model = new \Snake\UserEventDB($this->db);
//        $r = $model->getUserScenarios(66);
//        $this->assertTrue(count($r) > 0,'测试');
    }

    /**
     * @test
     */
    public function getUserTimingOne(){
//        $model = new \Snake\UserEventDB($this->db);
//        $r = $model->getUserTimingOne(66);
//        $this->assertTrue(count($r) > 0,'测试');
    }

    /**
     * @test
     */
    public function getUserTimingScenarios(){
//        $model = new \Snake\UserEventDB($this->db);
//        $r = $model->getUserTimingScenarios(66);
//        $this->assertTrue(count($r) > 0,'测试');
    }
}
 