<?php
/**
 * 清理数据库中 协议-遥控器 关系表中多余的映射
 *
 * User: snake
 * Date: 14-9-5
 * Time: 下午3:07
 */

namespace Snake\Services;


use Snake\CodebaseDB;
use Snake\ControllerProtocolDB;
use Snake\TControllerProtocol;

class ClearProtocol {

    /**
     * 执行清理程序
     *
     * @param bool $isWeb
     */
    public static function run($isWeb = false){

        $db = new \medoo(\DBFileConfig::$dbinfo);
        $tcp = new TControllerProtocol($db);
        $cdb = new CodebaseDB($db);
        $cpdb = new ControllerProtocolDB($db);

        $controllerids = $tcp->getControllerProtocolMore2();
        $result = array(); # 结果收集器

        foreach($controllerids as $controllerid){
            $logunit = array();
            $logunit[] = "遥控器ID:{$controllerid}";

            # 收集一个遥控器所有的按键中所使用到的协议ID
            $protocolFromCodebase = $cdb->getProtocolInfoFromControllerID($controllerid);
            $logunit[] = "该遥控器下面所有的正在使用中的协议:";
            foreach($protocolFromCodebase as $e){
                $logunit[] = "{$e['CodeID']}  {$e['ProtocolContent']}  {$e['CodeController']}";
            }

            # 收集关系表中该遥控器所映射的协议ID
            $protocolFromProtocol = $cpdb->getProtocolIDsByControllerID($controllerid);
            $logunit[] = "该遥控器下面所有有关系的协议:";
            foreach($protocolFromProtocol as $e){
                $logunit[] = "{$e['ProtocolID']}  {$e['ProtocolContent']}  {$e['ControllerID']}";
            }

            # 差集对比 处理多余的关系表
            $diff = array_diff(
                array_map(function ($unit){
                    return $unit['ProtocolContent'];
                },$protocolFromProtocol),
                array_map(function ($unit){
                    return $unit['ProtocolContent'];
                },$protocolFromCodebase));

            if(count($diff) > 0){
                $logunit[] = "差集:";
                foreach($diff as $e){
                    $logunit[] = $e;
                }
            }

            # 清理协议表中由于上一步处理清空之后孤单协议的清除
            foreach($diff as $p){
                $logunit[] = "清理过程";
                $protocolUnit = array_filter($protocolFromProtocol,function($unit) use ($p){
                    return $unit['ProtocolContent'] == $p;
                });
                $protocolUnit = array_values($protocolUnit);

                # 删除该关系
                $r = $tcp->delete($controllerid,$protocolUnit[0]['ProtocolID']);
                $logunit[] = "删除关闭表中的内容: " . $r ? "成功":"失败";
                # 检查该协议是否被其他遥控器使用 如果没有 删除
                if(!$cpdb->isProtocolInUsed($protocolUnit[0]['ProtocolID'])){
                    $r = $cpdb->delete($protocolUnit[0]['ProtocolID']);
                    $logunit[] = "删除协议表中的内容: " . $r ? "成功":"失败";
                }
            }

            $logunit[] = ""; # 空一行
            $result[] = $logunit;
        }

        foreach($result as $unit){
            foreach($unit as $line){
                if($isWeb){
                    echo $line . "</br>";
                } else {
                    echo $line . PHP_EOL;
                }
            }
        }
    }
} 