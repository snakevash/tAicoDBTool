<?php

/**
 * 系列配置
 *
 * User: snake
 * Date: 14-6-13
 * Time: 下午4:26
 */
class SeriesConfig
{
    /**
     * @var array 文件配置信息
     */
    public static $fileConfig = array(
        'ControllerName' => 'A',
        'DisplayNameCN' => 'B',
        'BrandNameEN' => 'C',
        'ProtocolName' => 'D',
        'SeriesString' => 'E',
        'DeviceID' => 'F',
        'Site' => 'G',
        'ControllerLogo' => 'H',
    );

    /**
     * @var string 开始行
     */
    public static $StartLine = '2';

    /**
     * @var array 分隔符
     */
    public static $spiltFlag = array(',', '、', ' ');
} 