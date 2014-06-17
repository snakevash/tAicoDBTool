<?php
/**
 * 遥控器-协议 关系表
 *
 * User: snake
 * Date: 14-6-17
 * Time: 上午9:47
 */

namespace Snake;


class TControllerProtocol {
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
     * 建立关系
     *
     * @param $ControllerID
     * @param $ProtocolID
     * @return array
     */
    public function insert($ControllerID,$ProtocolID){
        $r = $this->db->insert('t_controller_protocol',array(
            'ControllerID'=>$ControllerID,
            'ProtocolID'=>$ProtocolID
        ));

        return $r;
    }

    /**
     * 是否建立过关系
     *
     * @param $ControllerID
     * @param $Protocol
     * @return bool
     */
    public function isInserted($ControllerID,$Protocol){
        $r = $this->db->select('t_controller_protocol',"*",array(
            'AND'=>array(
                'ControllerID'=>$ControllerID,
                'Protocol'=>$Protocol
            )
        ));
        if(count($r) > 0){
            return true;
        } else {
            return false;
        }
    }
} 