<?php

/**
 * 品牌数据库测试类
 *
 * User: snake
 * Date: 14-6-12
 * Time: 上午11:51
 */
class BrandDBTest extends \PHPUnit_Framework_TestCase
{
    protected $db;

    function __construct()
    {
        $this->db = new medoo(DBFileConfig::$dbinfo);
    }


    public function testInsertOne()
    {
//        $model = new \Snake\BrandDB($this->db);
//        $id = $model->insert('test','','测试');
//        $this->assertEquals(12,$id,'名字相同');
    }

    public function testIsInserted(){
//        $model = new \Snake\BrandDB($this->db);
//        $r = $model->isInserted('索尼');
//        $this->assertTrue($r,'是否已经在数据库了?');
    }

    public function testInsertTDeviceBrand(){
//        $model = new \Snake\BrandDB($this->db);
//        $r = $model->insertTDeviceBrand(1,1);
//        $this->assertEquals('0',$r,'是否已经在数据库了?');
    }

    public function testIsInsertedTDeviceBrand(){
//        $model = new \Snake\BrandDB($this->db);
//        $r = $model->isInsertedTDeviceBrand(1,1);
//        $this->assertTrue(true,$r,'是否已经在数据库了?');
    }

    public function testGetBrandID(){
//        $model = new \Snake\BrandDB($this->db);
//        $r = $model->getBrandID('索尼');
//        $this->assertEquals(1,$r,'获得品牌的ID');
    }

    /**
     * @test
     */
    public function touchBrandTime(){
        $model = new \Snake\BrandDB($this->db);
        $r = $model->touchBrandTime(1);
        $this->assertEquals(1,$r,'测试');
    }
} 