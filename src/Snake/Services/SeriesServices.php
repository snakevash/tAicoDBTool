<?php
/**
 * 系列服务类
 *
 * User: snake
 * Date: 14-6-13
 * Time: 下午4:16
 */

namespace Snake\Services;


use Snake\BrandDB;
use Snake\ControllerDB;
use Snake\DeviceInfo;
use Snake\FileInfo;
use Snake\SeriesDB;
use Snake\TControllerSeries;

class SeriesServices
{
    /**
     * 获得表格数据
     *
     * @param $file
     * @return array
     */
    public function getFileContent($file)
    {

        $PHPExcel = \PHPExcel_IOFactory::load($file);
        $sheetData = $PHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $clearedData = array();

        foreach ($sheetData as $lineindex => $row) {
            if ($lineindex >= \SeriesConfig::$StartLine) {
                # 开始收集数据
                $tmp = array();
                foreach (\SeriesConfig::$fileConfig as $key => $value) {
                    $tmp[$key] = $row[$value];
                }
                # 过滤数据
                $tmpSeriesString = trim(str_replace(' ', '', $tmp['SeriesString']));
                # 检查是否存在中文都好和英文逗号
                $chars = array(',', '，');
                $tmpSeriesStringArr = ''; # 初始化系列数组
                foreach ($chars as $char) {
                    if (strpos($tmpSeriesString, $char)) {
                        $tmpSeriesStringArr = explode($char, $tmpSeriesString);
                        break;
                    }
                }
                $tmp['SeriesArray'] = $tmpSeriesStringArr;

                array_push($clearedData, $tmp);
            }
        }

        return $clearedData;
    }

    public function runInsertSeriesMain($file)
    {
        # 遍历数据结构
        $data = $this->getFileContent($file);
        $db = new \medoo(\DBFileConfig::$dbinfo);

        # 系列录入操作
        $bdb = new BrandDB($db);
        $sdb = new SeriesDB($db);
        $cdb = new ControllerDB($db);
        $tcsdb = new TControllerSeries($db);
        foreach ($data as $row) {
            # todo 使用英文匹配 而非中文匹配
            if (empty($row['DisplayNameCN'])) {
                continue;
            }
            # 查看是否收入相关品牌
            $isExistedBrand = $bdb->isInserted($row['DisplayNameCN']);
            if ($isExistedBrand) {
                # 插入相关系列名称
                $brandID = $bdb->getBrandID($row['DisplayNameCN']);
                $deviceID = 1;
                if (!empty($row['DeviceID'])) {
                    $deviceID = $row['DeviceID'];
                }

                # 遍历系列名称
                $isExistedController = $cdb->isInserted($row['ControllerName']);
                if (is_array($row['SeriesArray'])) {
                    foreach ($row['SeriesArray'] as $SeriesString) {
                        # 过滤掉空
                        if (empty($SeriesString)) {
                            continue;
                        }

                        $r = $sdb->isInsertedBySName($SeriesString);
                        $seriesID = '';
                        # 如果没有该系列 录入
                        if (!$r) {
                            $seriesID = $sdb->insert($SeriesString, $deviceID, $brandID);
                            # todo 日志
                        }
                        # 如果是之前已经录入过的系列 那么获得系列ID
                        if(empty($seriesID)){
                            $seriesID = $sdb->getSeriesID($SeriesString);
                        }

                        # 如果存在遥控器 而且 他们没有建立关系
                        $controllerID = $cdb->getControllerID($row['ControllerName']);
                        if($isExistedController){
                            $r = $tcsdb->isInserted($controllerID,$seriesID);
                            if(!$r){
                                $tcsdb->insert($controllerID,$seriesID);
                                # todo 日志 成功
                            }else{
                                # todo 日志 失败
                            }
                        }
                    }
                } else {
                    if (!empty($row['SeriesString'])) {
                        $r = $sdb->isInsertedBySName($row['SeriesString']);
                        $seriesID = '';
                        if (!$r) {
                            $seriesID = $sdb->insert($row['SeriesString'], $deviceID, $brandID);
                            # todo 日志
                        }

                        # 如果是之前已经录入过的系列 那么获得系列ID
                        if(empty($seriesID)){
                            $seriesID = $sdb->getSeriesID($row['SeriesString']);
                        }

                        # 如果存在遥控器 而且 他们没有建立关系
                        $controllerID = $cdb->getControllerID($row['ControllerName']);
                        if($isExistedController){
                            $r = $tcsdb->isInserted($controllerID,$seriesID);
                            if($r){
                                $tcsdb->insert($controllerID,$seriesID);
                                # todo 日志 成功
                            }else{
                                # todo 日志 失败
                            }
                        }
                    }
                }
            } else {
                # 没有查询到品牌
                $this->logConsole(2);
            }
        }

        $r = FileInfo::rmSeriesFilePath($file);
        return $r;
    }

    public function logConsole($flag = 1)
    {
        switch ($flag) {
            case 1:
                echo '执行成功!' . PHP_EOL;
                break;
            case 2:
                echo '品牌没有收入,该条程序不录入数据库!' . PHP_EOL;
                break;
            default:
                break;
        }
    }
} 