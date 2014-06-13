<?php
/**
 * 系列数据库
 *
 * User: snake
 * Date: 14-6-13
 * Time: 下午3:44
 */

namespace Snake;


class SeriesDB {
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
     * 插入系列到数据库
     *
     * @param $SName
     * @param $DeviceID
     * @param $BrandID
     * @return array
     */
    public function insert($SName,$DeviceID,$BrandID){
        $id = $this->db->insert('series', array(
            'SName' => $SName,
            'DeviceID' => $DeviceID,
            'BrandID' => $BrandID
        ));

        return $id;
    }

    /**
     * 检查是否已经插入过系列
     *
     * @param $SName
     * @return bool
     */
    public function isInsertedBySName($SName){
        $r = $this->db->select('series', '*', array('SName' => $SName));
        if (count($r) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获得系列的ID
     *
     * @param $SName
     * @return bool
     */
    public function getSeriesID($SName){
        $r = $this->db->select('series', '*', array('SName' => $SName));
        if (count($r) > 0) {
            return $r[0]['SID'];
        } else {
            return false;
        }
    }
} 