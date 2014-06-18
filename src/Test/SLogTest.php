<?php

/**
 * 日志服务类测试
 *
 * User: snake
 * Date: 14-6-18
 * Time: 下午1:59
 */
class SLogTest extends PHPUnit_Framework_TestCase
{

    public function testCreateOneDir()
    {
//        $r = \Snake\Services\SLog::createOneDir();
//        $this->assertFalse(!$r,'测试创建文件夹');
    }

    public function testWriteINIFile(){
        $r = \Snake\Services\SLog::writeINIFile('testB',false);
    }
}
 