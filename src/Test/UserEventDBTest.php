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
        $model = new \Snake\UserEventDB($this->db);

        $r = $model->getUserAffectedControllers(array(313));

        $this->assertTrue(count($r) > 0,'测试');
    }
}
 