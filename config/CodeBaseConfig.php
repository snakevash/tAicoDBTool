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
        ),
        'SourceFrom' => array(
            'Y' => '2',
            'X' => '8'
        )
    );

    /**
     * @var array 红外代码配置信息
     */
    public static $codebaseConfig = array(
        'CodeDisplayName' => '1',
        'Protocol' => '2',
        'UserCode' => '3',
        'KeyCode' => '4',
        'CodeKeyTrue' => '5',
        'Cycle' => '6',
        'ControllerProtocolFlag' => '7',
        'RetransFrame' => '8',
        'TVFormat' => '9',
        'CarrierCycle' => '10',
        'DataCycle' => '11',
        'CodeName' => '12',
        'CodeOrder' => '13',
        'CodeGroup' => '14',
        'CodeDefaultIcon' => '20',
        'DataBits' => '21'
    );

    /**
     * @var string 内容起始行
     */
    public static $startLine = 4;

    /**
     * @var int 遥控器信息行
     */
    public static $controllerLine = 2;
} 