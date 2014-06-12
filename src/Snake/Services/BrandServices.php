<?php
/**
 * 品牌服务类
 *
 * User: snake
 * Date: 14-6-12
 * Time: 下午3:37
 */

namespace Snake\Services;


class BrandServices {

    /**
     * 获得表格数据
     *
     * @param $file
     * @return array
     */
    public function getFileContent($file){

        $PHPExcel = \PHPExcel_IOFactory::load($file);
        $sheetData = $PHPExcel->getActiveSheet()->toArray(null,true,true,true);

        return $sheetData;
    }
} 