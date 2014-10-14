<?php
/**
 * 遥控器数据库
 *
 * User: snake
 * Date: 14-6-13
 * Time: 下午5:56
 */

namespace Snake;


class ControllerDB
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
     * 插入一条遥控器数据
     *
     * @param $ControllerProtocol
     * @param $ControllerType
     * @param $ControllerName
     * @param string $ControllerNameCN
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
        $SourceFrom,
        $ControllerNameCN
    )
    {
        $id = $this->db->insert('controller', array(
            'ControllerProtocol' => $ControllerProtocol,
            'ControllerType' => $ControllerType,
            'ControllerName' => $ControllerName,
            'ControllerSeries' => $ControllerSeries,
            'ControllerBrand' => $ControllerBrand,
            'ControllerDevice' => $ControllerDevice,
            'ControllerImage' => $ControllerImage,
            'HasNumberPad' => $HasNumberPad,
            'SourceFrom' => $SourceFrom,
            'ControllerNameCN' => $ControllerNameCN
        ));

        return $id;
    }

    /**
     * 更新遥控器
     *
     * @param $ControllerID
     * @param $ControllerProtocol
     * @param $ControllerType
     * @param $ControllerName
     * @param $ControllerSeries
     * @param $ControllerBrand
     * @param $ControllerDevice
     * @param $ControllerImage
     * @param $HasNumberPad
     * @param $SourceFrom
     * @param string $ControllerNameCN
     * @return bool
     */
    public function update(
        $ControllerID,
        $ControllerProtocol,
        $ControllerType,
        $ControllerName,
        $ControllerSeries,
        $ControllerBrand,
        $ControllerDevice,
        $ControllerImage,
        $HasNumberPad,
        $SourceFrom,
        $ControllerNameCN = ''
    )
    {
        $r = $this->db->update('controller', array(
            'ControllerProtocol' => $ControllerProtocol,
            'ControllerType' => $ControllerType,
            'ControllerName' => $ControllerName,
            'ControllerSeries' => $ControllerSeries,
            'ControllerBrand' => $ControllerBrand,
            'ControllerDevice' => $ControllerDevice,
            'ControllerImage' => $ControllerImage,
            'HasNumberPad' => $HasNumberPad,
            'SourceFrom' => $SourceFrom,
            'ControllerNameCN' => $ControllerNameCN
        ), array(
            'ControllerID' => $ControllerID
        ));

        return !!$r;
    }

    /**
     * 是否已经插入过
     *
     * @param $ControllerName
     * @return bool
     */
    public function isInserted($ControllerName)
    {
        $r = $this->db->select('controller', '*', array(
            'ControllerName' => $ControllerName
        ));

        if (count($r) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 是否已经插入过
     * 强条件 遥控器品牌 遥控器设备
     *
     * @param $ControllerName
     * @param $ControllerBrand
     * @param $ControllerDevice
     * @return bool
     */
    public function isInsertedByControllerBrandAndControllerDevice($ControllerName, $ControllerBrand, $ControllerDevice)
    {
        $r = $this->db->select('controller', '*', array(
            'AND' => array(
                'ControllerName' => $ControllerName,
                'ControllerBrand' => $ControllerBrand,
                'ControllerDevice' => $ControllerDevice
            )
        ));

        if (count($r) > 0) {
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
    public function getControllerID($ControllerNameß)
    {
        $r = $this->db->select('controller', '*', array(
            'ControllerName' => $ControllerNameß
        ));
        if (count($r) > 0) {
            return $r[0]['ControllerID'];
        } else {
            return false;
        }
    }

    /**
     * 获得遥控器的ID
     *
     * @param $ControllerName
     * @param $ControllerBrand
     * @param $ControllerDevice
     * @return bool
     */
    public function getControllerIDByControllerBrandAndControllerDevice($ControllerName, $ControllerBrand, $ControllerDevice)
    {
        $r = $this->db->select('controller', '*', array(
            'AND' => array(
                'ControllerName' => $ControllerName,
                'ControllerBrand' => $ControllerBrand,
                'ControllerDevice' => $ControllerDevice
            )
        ));

        if (count($r) > 0) {
            return $r[0]['ControllerID'];
        } else {
            return false;
        }
    }


    /**
     * 获得遥控器的数量
     *
     * @return int
     */
    public function getControllersNumber(){
        $r = $this->db->count('controller','*');
        return $r;
    }

    /**
     * 获得最近上传的100
     *
     * @param int $limit
     * @return array
     */
    public function getControllersDescLimit100($limit = 100){
        $sql = "
            select c.ControllerID,c.ControllerName,c.ControllerNameCN,b.BrandName,
            d.DeviceName,c.ControllerImage,c.HasNumberPad,c.SourceFrom,c.LastModAt
            from controller c

            left join brand b
                on b.BrandID = c.ControllerBrand
            left join device d
                on d.DeviceID = c.ControllerDevice

            order by c.ControllerID desc
            limit {$limit}
        ";

        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 获得遥控器所有的代码ID
     *
     * @param $ControllerID
     * @return array|bool
     */
    public function getControllerAllCodeIDs($ControllerID){
        return $this->db->select('codebase','CodeID',array('CodeController'=>$ControllerID));
    }
}