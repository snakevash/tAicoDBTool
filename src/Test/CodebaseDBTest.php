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
}
 