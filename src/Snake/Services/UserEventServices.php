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

        # 获得所有用户受到影响的codeids
        $userHandledLayouts = array_map(function(&$ele){
            # 处理CodeMapID数据 变成数组
            return explode(',',$ele['CodeMapID']);
        },$userLayouts);

        $userHandledCodeIDs = array();
        foreach($userHandledLayouts as $unitCodeIDs){
            foreach($unitCodeIDs as $unitCodeID){
                if(!in_array($unitCodeID,$userHandledCodeIDs)){
                   array_push($userHandledCodeIDs,$unitCodeID);
                }
            }
        }

        # 用户所有场景(包括已经被用户删除过的场景)
        $userScenarios = $model->getUserScenarios($UserID);

        $userAffectedEventIDsOfScenario = array_map(function($ele) use ($userHandledCodeIDs){
            if(count(array_intersect(
                json_decode($ele['EventCode'],true),
                $userHandledCodeIDs)) > 0){
                return $ele['EventID'];
            }
        },$userScenarios);
        $userAffectedEventIDsOfScenario = array_filter($userAffectedEventIDsOfScenario,function($ele){
            return !is_null($ele);
        });

        # 用户定时(包括场景和单个定时)
        $userTimingOnes = $model->getUserTimingOne($UserID);

        $userAffectedEventIDsOfTimingOne = array_map(function($ele) use ($userHandledCodeIDs){
            if(count(array_intersect(
                json_decode($ele['EventCode'],true),
                $userHandledCodeIDs)) > 0){
                return $ele['EventID'];
            }
        },$userTimingOnes);
        $userAffectedEventIDsOfTimingOne = array_filter($userAffectedEventIDsOfTimingOne,function($ele){
            return !is_null($ele);
        });


//        foreach($userHandledLayouts as $unitController){
//            # 遍历单个遥控器下面用户所用到的按键
//            foreach($unitController['codeids'] as $unitCodeID){
//
//            }
//        }
    }
} 