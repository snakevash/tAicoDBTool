<?php
/**
 * 系列服务类
 *
 * User: snake
 * Date: 14-6-13
 * Time: 下午4:16
 */

namespace Snake\Services;


class SeriesServices
{

    public function getFileContent($file)
    {

        $PHPExcel = \PHPExcel_IOFactory::load($file);
        $sheetData = $PHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $clearedData = array();

        foreach($sheetData as $lineindex => $row){
            if($lineindex >= \SeriesConfig::$StartLine ){
                # 开始收集数据
                $tmp = array();
                foreach(\SeriesConfig::$fileConfig as $key => $value){
                    $tmp[$key] = $row[$value];
                }
                # 过滤数据
                $tmpSeriesString = str_replace(' ','',$tmp['SeriesString']);
                # 如果

                array_push($clearedData,$tmp);
            }
        }

        return $clearedData;
    }
} 