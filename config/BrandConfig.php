<?php

/**
 * 品牌配置
 *
 * User: snake
 * Date: 14-6-12
 * Time: 下午5:06
 */
class BrandConfig
{
    /**
     * @var array 品牌文件相关配置文件
     */
    public static $brands = array(
        'TV' => array(
            'startline' => 2,
            'endline' => 56,
            'DeviceID' => 2
        ),
        'Aircon' => array(
            'startline' => 59,
            'endline' => 89,
            'DeviceID' => 4
        ),
        'STB' => array(
            'startline' => 95,
            'endline' => 203,
            'DeviceID' => 6
        ),
        'DVD' => array(
            'startline' => 207,
            'endline' => 233,
            'DeviceID' => 10
        ),
        'Amp' => array(
            'startline' => 237,
            'endline' => 260,
            'DeviceID' => 8
        ),
        'Projector' => array(
            'startline' => 263,
            'endline' => 320,
            'DeviceID' => 12
        ),
        'Screeen' => array(
            'startline' => 322,
            'endline' => 334,
            'DeviceID' => 24
        ),
        'Hifi' => array(
            'startline' => 337,
            'endline' => 412,
            'DeviceID' => 20
        ),
        'Camera' => array(
            'startline' => 417,
            'endline' => 419,
            'DeviceID' => 22
        )
    );

    /**
     * @var array 列定义
     */
    public static $columns = array(
        'CN' => 'B', # 品牌中文列表
        'EN' => 'C', # 品牌英文列表
        'Stop' => 'D', # 停产品牌
    );
} 