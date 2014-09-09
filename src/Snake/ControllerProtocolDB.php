<?php
/**
 * 遥控器数据协议类
 *
 * User: snake
 * Date: 14-6-16
 * Time: 下午9:52
 */

namespace Snake;


class ControllerProtocolDB
{
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
     * 插入一条协议
     *
     * @param string $Protocol
     * @param string $ControllerProtocolFlag
     * @param string $RetransFrame
     * @param string $TVFormat
     * @param string $CarrierCycle
     * @param string $DataCycle
     * @param string $DataBits
     * @return array
     */
    public function insert(
        $Protocol = '',
        $ControllerProtocolFlag = '',
        $RetransFrame = '',
        $TVFormat = '',
        $CarrierCycle = '',
        $DataCycle = '',
        $DataBits = '')
    {
        $id = $this->db->insert('protocol', array(
            'Protocol' => $Protocol,
            'ControllerProtocolFlag' => $ControllerProtocolFlag,
            'RetransFrame' => $RetransFrame,
            'TVFormat' => $TVFormat,
            'CarrierCycle' => $CarrierCycle,
            'DataCycle' => $DataCycle,
            'DataBits' => $DataBits
        ));

        return $id;
    }

    /**
     * 协议是否已经在数据库
     *
     * @param $Protocol
     * @return bool
     */
    public function isInserted($Protocol)
    {
        $r = $this->db->select('protocol', '*', array('Protocol' => $Protocol));
        if (count($r) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获得协议ID
     *
     * @param $Protocol
     * @return bool
     */
    public function getProtocolID($Protocol)
    {
        $r = $this->db->select('protocol', '*', array('Protocol' => $Protocol));
        if (count($r) > 0) {
            return $r[0]['ProtocolID'];
        } else {
            return false;
        }
    }

    /**
     * 删除协议
     *
     * @param $ProtocolID
     * @return int
     */
    public function delete($ProtocolID)
    {
        return $this->db->delete('protocol', array('ProtocolID' => $ProtocolID));
    }

    /**
     * 查找协议是否在被使用
     *
     * @param $ProtocolID
     * @return int
     */
    public function isProtocolInUsed($ProtocolID)
    {
        return $this->db->count('t_controller_protocol', 'ControllerID', array(
            'ProtocolID' => $ProtocolID
        ));
    }

    /**
     * 从协议中根据遥控器ID来获得相关的协议信息
     *
     * @param $ControllerID
     * @return array
     */
    public function getProtocolIDsByControllerID($ControllerID){
        $sql = "
        SELECT p.ProtocolID,concat(p.ControllerProtocolFlag,p.RetransFrame,p.TVFormat,p.CarrierCycle,p.DataCycle,p.DataBits) as ProtocolContent,tcp.ControllerID

        FROM aicodb.protocol as p

        left join t_controller_protocol as tcp
            on tcp.ProtocolID = p.ProtocolID

        where tcp.ControllerID = ?

        -- group by ProtocolContent
        ";

        $sql = str_replace("?",$ControllerID,$sql);

        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }
}