<?php
/**
 * 系列数据库测试
 *
 * User: snake
 * Date: 14-6-13
 * Time: 下午3:51
 */

class SeriesDBTest extends PHPUnit_Framework_TestCase {
    protected $db;

    function __construct()
    {
        $this->db = new medoo(DBFileConfig::$dbinfo);
    }

    public function testInsert(){
//        $model = new \Snake\SeriesDB($this->db);
//        $id = $model->insert('testSeries',1,1);
//        $this->assertEquals(1,$id,'插入单条数据库');
    }

    public function testIsInsertedBySName(){
//        $model = new \Snake\SeriesDB($this->db);
//        $r = $model->isInsertedBySName('testSeries');
//        $this->assertTrue($r,'系列是否已经存在数据库');
    }

    public function testGetSeriesID(){
//        $model = new \Snake\SeriesDB($this->db);
//        $r = $model->getSeriesID('testSeries');
//        $this->assertEquals(1,$r,'获得系列的ID');
    }
}
 