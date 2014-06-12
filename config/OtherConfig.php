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
     * 红外代码导入之前的文件夹
     */
    const CODEBASEBEFORE = './codebasebefore';

    /**
     * 所有品牌的单独文件
     */
    const BRANDS = './brands';
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