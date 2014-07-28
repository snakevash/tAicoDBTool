<?php
/**
 * 工具启动文件
 *
 * User: snake
 * Date: 14-6-3
 * Time: 下午1:53
 */
require_once 'vendor/autoload.php';

# 导入品牌文件
# 导入品牌第一个文件
//$sBrand = new \Snake\Services\BrandServices();
//$sfiles = \Snake\FileInfo::getFilePathInfo(OtherConfig::BRANDS);
//$sBrand->runInsertBrandMain($sfiles[0]);

# 导入所有的红外代码
# 遍历codebasebefore下所有的红外代码
$sCodeBaes = new \Snake\Services\CodebaseServices();
$files = \Snake\FileInfo::getFilePathInfo(OtherConfig::CODEBASEBEFORE);
foreach ($files as $file) {
    $r = $sCodeBaes->runInsertCodebaseMain($file);
}

# 导入系列
//$sSeries = new \Snake\Services\SeriesServices();
//$sfiles = \Snake\FileInfo::getFilePathInfo(OtherConfig::BRANDBEFORE);
//foreach($sfiles as $file){
//    $r = $sSeries->runInsertSeriesMain($file);
//}