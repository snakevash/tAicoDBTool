<?php
/**
 * 
 * User: snake
 * Date: 14-10-15
 * Time: 下午4:55
 */

namespace Snake\Services;


use Snake\UserEventDB;

class UserEventServices {

    public function getUserAffectedInfo($UserID,$ControllerID){
        $db = new \medoo(\DBFileConfig::$dbinfo);
        $model = new UserEventDB($db);

        $userLayouts = $model->getUserLayout($UserID,$ControllerID);

        $userHandledLayouts = array_map(function($ele){
            # 处理CodeMapID数据 变成数组
            $ele['codeids'] = explode(',',$ele['CodeMapID']);
        },$userLayouts);

        # 用UserID和分解出来的CodeID来匹配用户的场景和定时

        foreach($userHandledLayouts as $unitController){
            # 遍历单个遥控器下面用户所用到的按键
            foreach($unitController['codeids'] as $unitCodeID){

            }
        }
    }
} 