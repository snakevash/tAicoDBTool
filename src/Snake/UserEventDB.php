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
     * 获得用户受到影响的CodeID
     *
     * @param $UserID
     * @param $CodeIds
     */
    public function getUserAffectedControllers($UserID,$CodeIds){

    }
} 