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

    public function insert(
        $ControllerProtocol,
        $ControllerType,
        $ControllerName,
        $ControllerSeries,
        $ControllerBrand,
        $ControllerDevice,
        $ControllerImage,
        $HasNumberPad){
        $id = $this->db->insert('controller',array(
            'ControllerProtocol'=>$ControllerProtocol,
            'ControllerType'=>$ControllerType
        ));
    }
} 