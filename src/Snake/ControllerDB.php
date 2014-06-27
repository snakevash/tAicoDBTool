<?php
/**
 * 遥控器数据库
 *
 * User: snake
 * Date: 14-6-13
 * Time: 下午5:56
 */

namespace Snake;


class ControllerDB {
    private $db;

    /**
     * 构造函数
     *
     * @param \medoo $db 数据库实例
     */
    function __construct(\medoo $db)
    {
        $this->db = $db;
    }

    /**
     * 插入一条遥控器数据
     *
     * @param $ControllerProtocol
     * @param $ControllerType
     * @param $ControllerName
     * @param $ControllerSeries
     * @param $ControllerBrand
     * @param $ControllerDevice
     * @param $ControllerImage
     * @param $HasNumberPad
     * @param $SourceFrom
     * @return array
     */
    public function insert(
        $ControllerProtocol,
        $ControllerType,
        $ControllerName,
        $ControllerSeries,
        $ControllerBrand,
        $ControllerDevice,
        $ControllerImage,
        $HasNumberPad,
        $SourceFrom)
    {
        $id = $this->db->insert('controller',array(
            'ControllerProtocol'=>$ControllerProtocol,
            'ControllerType'=>$ControllerType,
            'ControllerName'=>$ControllerName,
            'ControllerSeries'=>$ControllerSeries,
            'ControllerBrand'=>$ControllerBrand,
            'ControllerDevice'=>$ControllerDevice,
            'ControllerImage'=>$ControllerImage,
            'HasNumberPad' => $HasNumberPad,
            'SourceFrom' => $SourceFrom
        ));

        return $id;
    }

    /**
     * 是否已经插入过
     *
     * @param $ControllerName
     * @return bool
     */
    public function isInserted($ControllerName){
        $r = $this->db->select('controller','*',array(
            'ControllerName'=>$ControllerName
        ));

        if(count($r) > 0){
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获得遥控器ID
     *
     * @param $ControllerNameß
     * @return bool
     */
    public function getControllerID($ControllerNameß){
        $r = $this->db->select('controller', '*', array(
            'ControllerName' => $ControllerNameß
        ));
        if (count($r) > 0) {
            return $r[0]['ControllerID'];
        } else {
            return false;
        }
    }
} 