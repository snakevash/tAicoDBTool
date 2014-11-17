<?php

/**
 * 其他配置
 *
 * User: snake
 * Date: 14-6-11
 * Time: 下午4:43
 */
class OtherConfig
{
    /**
     * 品牌导入之后的文件夹
     */
    const BRANDAFTER = './brandafter';

    /**
     * 品牌导入之前的文件夹
     */
    const BRANDBEFORE = './brandbefore';

    /**
     * 红外代码导入之后的文件夹
     */
    const CODEBASEAFTER = './codebaseafter';

    /**
     * 红外代码导入失败的文件夹
     */
    const CODEBASEFAIL = './codebasefail';

    /**
     * 红外代码导入之前的文件夹
     */
    const CODEBASEBEFORE = './codebasebefore';

    /**
     * 所有品牌的单独文件
     */
    const BRANDS = './brands';

    /**
     * 日志文件夹
     */
    const LOGS = './logs';

    /**
     * 临时文件
     */
    const INIFile = 'snakeini.txt';

    /**
     * 规则xls目录
     */
    const RULEXLS = './rulexls';

    /**
     * @var array 中英文对照
     */
    public static $CN = array(
        '电视' => 'TV',
        '有线电视机顶盒' => 'CableTV',
        '机顶盒' => 'STB',
        'DVD' => 'DVD',
        '投影机' => 'Projector',
        '热水器' => 'Heater',
        '功放' => 'Amp',
        '风扇等' => 'Other',
        '按键对照表' => 'MapTable'
    );
}

/**
 * 获得变量的名字
 *
 * @param $var
 * @param null $scope
 * @return mixed
 */
function getVariableName(&$var, $scope = null)
{
    if (null == $scope) {
        $scope = $GLOBALS;
    }
    $tmp = $var;
    $var = 'tmp_exists_' . mt_rand();
    $name = array_search($var, $scope, true);
    $var = $tmp;
    return $name;
}