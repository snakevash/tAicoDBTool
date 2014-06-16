<?php

/**
 * 红外代码数据配置
 *
 * User: snake
 * Date: 14-6-13
 * Time: 下午1:55
 */
class CodeBaseConfig
{
    /**
     * @var array 遥控器信息
     */
    public static $controllerConfig = array(
        'ControllerType' => array(
            'Y' => '2',
            'X' => '1'
        ),
        'ControllerName' => array(
            'Y' => '2',
            'X' => '2'
        ),
        'ControllerSeries' => array(
            'Y' => '2',
            'X' => '3'
        ),
        'ControllerBrand' => array(
            'Y' => '2',
            'X' => '4'
        ),
        'ControllerDevice' => array(
            'Y' => '2',
            'X' => '5'
        ),
        'ControllerImage' => array(
            'Y' => '2',
            'X' => '6'
        ),
        'HasNumber' => array(
            'Y' => '2',
            'X' => '7'
        )
    );

    /**
     * @var array 红外代码配置信息
     */
    public static $codebaseConfig = array(
        'CodeDisplayName' => '1',
        'Protocol' => '2',
        'UserCode' => '3',
        'CodeKeyTrue' => '4',
        'Cycle' => '5',
        'ControllerProtocolFlag' => '6',
        'RetransFrame' => '7',
        'TVFormat' => '8',
        'CarrierCycle' => '9',
        'DataCycle' => '10',
        'CodeName' => '11',
        'CodeOrder' => '12',
        'CodeGroup' => '13',
        'CodeDefaultIcon' => '14',
        'DataBits' => '15'
    );

    /**
     * @var string 内容起始行
     */
    public static $startLine = 4;
} 