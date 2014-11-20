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

    /**
     * 获得清洗过的数据
     *
     * @return array|mixed
     */
    public function getClearData(){
        $objRead = \PHPExcel_IOFactory::createReader('Excel2007');
        $objRead->setLoadAllSheets();
        $objPHPExcel = $objRead->load($this->xlspath);

        $workSheetNames = $objPHPExcel->getSheetNames();

        foreach($workSheetNames as $workSheetName){
            $workSheet = $objPHPExcel->getSheetByName($workSheetName);
            $codes = $workSheet->toArray(null,true,true,true);
            $this->clearData[$workSheetName] = array();

            # 开始数据结构
            for($i=\RuleConfig::$rules[$workSheetName]['normal']['startline'];
                $i<=\RuleConfig::$rules[$workSheetName]['normal']['endline'];
                $i++){
                $temp = array();
                $temp['CodeDisplayName'] = $codes[$i]['A'];
                $temp['CodeName'] = $codes[$i]['B'];
                $temp['CodeOrder'] = $codes[$i]['C'];
                $temp['CodeGroup'] = $codes[$i]['D'];
                $temp['CodeDefaultIcon'] = $codes[$i]['E'];
                $this->clearData[$workSheetName]['codes'][] = $temp;
            }

            # 有无特殊规则


        }

        return $this->clearData;
    }

    public function modifyData(&$data){
//        if(isset($data['Menu']) && isset($data['Exit']) && isset($data['Back']) && isset($data['OK'])){
//
//        }
    }
}