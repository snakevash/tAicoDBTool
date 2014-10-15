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
     * @param $CodeID
     * @return array
     */
    public function getUserScenarioAffected($UserID,$CodeID){
        $sql = "
            SELECT EventID
            FROM user_event
            WHERE UserID = $UserID
            AND (EventCode LIKE '%" . $CodeID ."%')
            AND EventType = 4
        ";

        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }


}