<?php
/**
 * 红外代码服务类
 *
 * User: snake
 * Date: 14-6-15
 * Time: 下午7:52
 */

namespace Snake\Services;


class CodebaseServices
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
        $clearedData = array(
            'controllerData' => array(),
            'codebasesData' => array()
        );

        # 读取表单数据
        # 读取红外代码所属遥控器


        # 读取红外代码行
//        for($i = \CodeBaseConfig::$startLine; $i){
//
//        }
//        foreach (\CodeBaseConfig::$codebaseConfig['StartLine'] as $k => $v) {
//        }
//
//        return $clearedData;
        return $sheetData;
    }
} 