<?php
/**
 * 品牌服务类测试
 *
 * User: snake
 * Date: 14-6-12
 * Time: 下午3:53
 */

class BrandServicesTest extends \PHPUnit_Framework_TestCase {
    public function testGetFileContent(){
//        $model = new \Snake\Services\BrandServices();
//        $files = \Snake\FileInfo::getFilePathInfo(OtherConfig::BRANDS);
//        $data = $model->getFileContent($files[0]);
//        var_dump($data);
    }

    public function testRunInsertBrandMain()
    {
//        $s = new \Snake\Services\BrandServices();
//        $files = \Snake\FileInfo::getFilePathInfo(OtherConfig::BRANDS);
//        $s->runInsertBrandMain($files[0]);
    }

    public function testLogConsole(){
        $s = new \Snake\Services\BrandServices();
        $files = \Snake\FileInfo::getFilePathInfo(OtherConfig::BRANDS);
        $s->logConsole('索尼','sony',1,1);
    }
} 