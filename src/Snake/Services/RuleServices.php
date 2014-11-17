<?php
/**
 *
 * 规则导入服务
 *
 * User: snake
 * Date: 14/11/14
 * Time: 下午3:11
 */

namespace Snake\Services;


class RuleServices {

    /**
     * @var mixed 被清洗过的数据
     */
    public $clearData;

    /**
     * @var string 规则地址文件
     */
    public $xlspath;

    function __construct($filename)
    {
        $this->xlspath = $filename;
        $this->clearData = array();
    }

    public function getClearData(){
        $objRead = \PHPExcel_IOFactory::createReader('Excel2007');
        $objRead->setLoadAllSheets();
        $objPHPExcel = $objRead->load($this->xlspath);

        $workSheetNames = $objPHPExcel->getSheetNames();

        foreach($workSheetNames as $workSheetName){
            $workSheet = $objPHPExcel->getSheetByName($workSheetName);
            $this->clearData[$workSheetName] = $workSheet->toArray(null,true,true,true);
        }

        return $this->clearData;
    }
}