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
            'Y' => '1',
            'X' => 'B'
        ),
        'ControllerName' => array(
            'Y' => '1',
            'X' => 'C'
        ),
        'ControllerSeries' => array(
            'Y' => '1',
            'X' => 'D'
        ),
        'ControllerBrand' => array(
            'Y' => '1',
            'X' => 'E'
        ),
        'ControllerDevice' => array(
            'Y' => '1',
            'X' => 'B'
        ),
        'ControllerImage' => array(
            'Y' => '1',
            'X' => 'B'
        ),
        'HasNumber' => array(
            'Y' => '1',
            'X' => 'B'
        )
    );

    /**
     * @var array 红外代码配置信息
     */
    public static $codebaseConfig = array(
        'CodeDisplayName' => 'B',
        'Protocol' => 'C',
        'UserCode' => 'D',
        'CodeKeyTrue' => 'E',
        'Cycle' => 'F',
        'ControllerProtocolFlag' => 'G',
        'RetransFrame' => 'H',
        'TVFormat' => 'I',
        'CarrierCycle' => 'J',
        'DataCycle' => 'K',
        'CodeName' => 'L',
        'CodeOrder' => 'M',
        'CodeGroup' => 'N',
        'CodeDefaultIcon' => 'T',
        'DataBits' => 'U'
    );

    /**
     * @var string 内容起始行
     */
    public static $startLine = 5;
} 