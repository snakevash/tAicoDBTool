<?php
/**
 * 清理数据库中 协议-遥控器 关系表中多余的映射
 *
 * User: snake
 * Date: 14-9-5
 * Time: 下午3:07
 */

namespace Snake\Services;


class ClearProtocol {

    /**
     * 任务开始
     */
    public static function run(){
        # 收集一个遥控器所有的按键中所使用到的协议ID


        # 收集关系表中该遥控器所映射的协议ID


        # 差集对比 处理多余的关系表


        # 清理协议表中由于上一步处理清空之后孤单协议的清除
    }
} 