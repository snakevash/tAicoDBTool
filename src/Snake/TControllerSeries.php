<?php
/**
 * 遥控器-系列 关系表
 *
 * User: snake
 * Date: 14-6-16
 * Time: 下午10:08
 */

namespace Snake;


class TControllerSeries {
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
     * @param $SeriesID
     * @return array
     */
    public function insert($ControllerID,$SeriesID){
        $r = $this->db->insert('t_controller_series',array(
            'ControllerID'=>$ControllerID,
            'SeriesID'=>$SeriesID
        ));

        return $r;
    }

    /**
     * 是否建立过关系
     *
     * @param $ControllerID
     * @param $SeriesID
     * @return bool
     */
    public function isInserted($ControllerID,$SeriesID){
        $r = $this->db->select('t_controller_series',"*",array(
            'AND'=>array(
                'ControllerID'=>$ControllerID,
                'SeriesID'=>$SeriesID
            )
        ));
        if(count($r) > 0){
            return true;
        } else {
            return false;
        }
    }
} 