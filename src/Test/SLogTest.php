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

    public function testWriteINIFile()
    {
//        $r = \Snake\Services\SLog::writeINIFile('testB',false);
    }

    public function testWriteLog()
    {
//        $filename = OtherConfig::LOGS . DIRECTORY_SEPARATOR . "test" . DIRECTORY_SEPARATOR . 'testA.txt';
//        $r = \Snake\Services\SLog::writeLog($filename, '测试测试',array(
//            'ControllerID'=>'1'
//        ));
//        $this->assertTrue($r,'测试写日志函数');
    }

    public function testGetCurrentIsFinished(){
//        $dirName = \Snake\Services\SLog::createOneDir();
//        $fileName = $dirName . DIRECTORY_SEPARATOR . \Snake\Services\SLog::BRANDLOG;
//        $r = \Snake\Services\SLog::writeINIFile($fileName);
//        $r = \Snake\Services\SLog::getCurrentIsFinished();
//        $this->assertFalse($r,'测试获得当前是否完成');
    }

    public function testABC(){
        $this->assertFalse(false,'clearCache');
    }
}
 