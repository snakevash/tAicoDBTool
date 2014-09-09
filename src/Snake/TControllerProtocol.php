<?php
/**
 * 遥控器-协议 关系表
 *
 * User: snake
 * Date: 14-6-17
 * Time: 上午9:47
 */

namespace Snake;


class TControllerProtocol
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
     * 建立关系
     *
     * @param $ControllerID
     * @param $ProtocolID
     * @return array
     */
    public function insert($ControllerID, $ProtocolID)
    {
        $r = $this->db->insert('t_controller_protocol', array(
            'ControllerID' => $ControllerID,
            'ProtocolID' => $ProtocolID
        ));

        return $r;
    }

    /**
     * 是否建立过关系
     *
     * @param $ControllerID
     * @param $ProtocolID
     * @return bool
     */
    public function isInserted($ControllerID, $ProtocolID)
    {
        $r = $this->db->select('t_controller_protocol', "*", array(
            'AND' => array(
                'ControllerID' => $ControllerID,
                'ProtocolID' => $ProtocolID
            )
        ));
        if (count($r) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 删除遥控器-协议关系
     *
     * @param $ControllerID
     * @param $ProtocolID
     * @return int
     */
    public function delete($ControllerID, $ProtocolID)
    {
        return $this->db->delete('t_controller_protocol', array(
            'AND' => array(
                'ControllerID' => $ControllerID,
                'ProtocolID' => $ProtocolID
            )
        ));
    }

    /**
     * 通过遥控器
     *
     * @param $ControllerID
     * @return array
     */
    public function getProtocolInfoFromControllerID($ControllerID)
    {
        $sql = "
            select p.ProtocolID,p.Protocol
            from protocol as p

            left join t_controller_protocol as tcp
                on tcp.ProtocolID = p.ProtocolID

            where tcp.ControllerID = ?
            order by p.ProtocolID
        ";

        $sql = str_replace('?', $ControllerID, $sql);

        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 获得关系表中遥控器拥有两个以上的遥控器ID
     *
     * @return array
     */
    public function getControllerProtocolMore2()
    {
        $sql = "
            SELECT ControllerID,count(ProtocolID) as ptimes

            FROM aicodb.t_controller_protocol

            group by ControllerID
            having ptimes >= 2
        ";

        $t = $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        $r = array_map(function ($unit) {
            return $unit['ControllerID'];
        }, $t);
        return array_unique($r);
    }


} 