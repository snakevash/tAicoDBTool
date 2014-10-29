<?php
/**
 * 品牌数据类
 *
 * User: snake
 * Date: 14-6-12
 * Time: 上午11:35
 */

namespace Snake;


class BrandDB
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
     * 插入品牌到数据库
     *
     * @param string $BrandName
     * @param string $BrandShortName
     * @param string $DisplayNameCN
     * @param string $BrandLogo
     * @param int $Country
     * @param string $BrandWebSite
     * @return array
     */
    public function insert(
        $BrandName = '',
        $BrandShortName = '',
        $DisplayNameCN = '',
        $BrandLogo = '',
        $Country = 0,
        $BrandWebSite = '')
    {
        $BrandName = strtoupper($BrandName);
        $id = $this->db->insert('brand', array(
            'BrandName' => $BrandName,
            'BrandShortName' => $BrandShortName,
            'DisplayNameCN' => $DisplayNameCN,
            'BrandLogo' => $BrandLogo,
            'Country' => $Country,
            'BrandWebSite' => $BrandWebSite
        ));

        return $id;
    }

    /**
     * 品牌是否已经存在数据库
     *
     * @param $DisplayNameCN
     * @return bool
     */
    public function isInserted($DisplayNameCN)
    {
        $r = $this->db->select('brand', '*', array('DisplayNameCN' => $DisplayNameCN));
        if (count($r) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 品牌是否已经存在数据库 中文品牌和英文品牌
     *
     * @param $DisplayNameCN
     * @param $BrandName
     * @return bool
     */
    public function isInsertedCNAndEn($DisplayNameCN, $BrandName)
    {
        $r = $this->db->select('brand', '*', array(
            "AND" => array(
                'DisplayNameCN' => $DisplayNameCN,
                'BrandName' => $BrandName
            )
        ));

        if (count($r) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 品牌是否已经存在数据库
     *
     * @param string $BrandName 英文版本
     * @return bool
     */
    public function isInsertedByEN($BrandName)
    {
        $r = $this->db->select('brand', '*', array('BrandName' => $BrandName));
        if (count($r) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获得品牌的ID
     *
     * @param $DisplayNameCN
     * @return bool
     */
    public function getBrandID($DisplayNameCN)
    {
        $r = $this->db->select('brand', '*', array(
            'DisplayNameCN' => $DisplayNameCN
        ));
        if (count($r) > 0) {
            return $r[0]['BrandID'];
        } else {
            return false;
        }
    }

    /**
     * 获得品牌的ID
     *
     * @param string $BrandName 英文
     * @return bool
     */
    public function getBrandIDByEn($BrandName)
    {
        $r = $this->db->select('brand', '*', array(
            'BrandName' => $BrandName
        ));
        if (count($r) > 0) {
            return $r[0]['BrandID'];
        } else {
            return false;
        }
    }

    /**
     * 维护设备-品牌关系表
     *
     * @param $BrandID
     * @param $DeviceID
     * @return array
     */
    public function insertTDeviceBrand($BrandID, $DeviceID)
    {
        $r = $this->db->insert('t_device_brand', array(
            'BrandID' => $BrandID,
            'DeviceID' => $DeviceID
        ));

        return $r == '0';
    }

    /**
     * 是否已经存在设备-品牌关系
     *
     * @param $BrandID
     * @param $DeviceID
     * @return array|bool
     */
    public function isInsertedTDeviceBrand($BrandID, $DeviceID)
    {
        $r = $this->db->select('t_device_brand', "*", array(
            'AND' => array(
                'BrandID' => $BrandID,
                'DeviceID' => $DeviceID
            )
        ));
        if (count($r) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获得品牌的数量
     *
     * @return int
     */
    public function getBrandsNumber(){
        return $this->db->count('brand','*');
    }

    /**
     * 获得最近上传品牌
     *
     * @param int $limit
     * @return array
     */
    public function getBrandDescLimit100($limit = 100){
        $sql = "
            SELECT b.BrandID,b.BrandName,b.DisplayNameCN,d.DeviceName,d.DisplayNameCN as DisplayNameCNDevice,b.LastModAt
            FROM brand b

            left join t_device_brand tdb
                on tdb.BrandID = b.BrandID
            left join device d
                on tdb.DeviceID = d.DeviceID

            order by b.BrandID desc limit {$limit}
        ";

        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 更新品牌时间 目的是为了品牌更新的时候，可以立即显示
     *
     * @param $BrandID
     * @return int
     */
    public function touchBrandTime($BrandID){
        return $this->db->update('brand',array(
            'LastModAt'=>date('Y-m-d H:i:s',time())
        ),array('BrandID'=>$BrandID));
    }
} 