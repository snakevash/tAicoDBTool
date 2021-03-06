<?php
/**
 * 用户事件模型
 *
 * User: snake
 * Date: 14-10-14
 * Time: 下午5:13
 */

namespace Snake;


class UserEventDB {
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
     * 获得受到删除遥控器影响的用户UID
     *
     * @param array $ControllerIDs
     * @return array
     */
    public function getUserAffectedControllers(array $ControllerIDs = array()){
        $strCIDs = implode(',',$ControllerIDs);

        $sql = "
            SELECT UserID
            FROM user_layout
            WHERE ControllerID IN (" . $strCIDs .")
            GROUP BY UserID
        ";

        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 获得用户下指定遥控器所使用到的相关信息
     *
     * @param $UserID
     * @param $ControllerID
     * @return array|bool
     */
    public function getUserLayout($UserID,$ControllerID){
        return $this->db->select('user_layout','*',array(
            'AND' => array(
                'UserID'=>$UserID,
                'ControllerID'=>$ControllerID
            )
        ));
    }

    /**
     * 获得用户场景影响
     *
     * @param $UserID
     * @return array
     */
    public function getUserScenarios($UserID){
        $sql = "
            SELECT *
            FROM user_event
            WHERE UserID = $UserID
            AND EventType = 4
        ";

        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 获得用户单次定时
     *
     * @param $UserID
     * @return array
     */
    public function getUserTimingOne($UserID){
        $sql = "
            SELECT *
            FROM user_event
            WHERE UserID = $UserID
            AND (EventType = 0 OR EventType = 2)
        ";

        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 获得用户场景定时
     *
     * @param $UserID
     * @return array
     */
    public function getUserTimingScenarios($UserID){
        $sql = "
            SELECT *
            FROM user_event
            WHERE UserID = $UserID
            AND (EventType = 1 OR EventType = 3)
        ";

        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function isScenarioExists($EventID){
        $sql = "
            SELECT *
            FROM user_event
        ";
    }
}