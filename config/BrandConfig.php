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
            'endline' => 387,
            'DeviceID' => 6
        ),
        'DVD' => array(
            'startline' => 407,
            'endline' => 433,
            'DeviceID' => 10
        ),
        'Amp' => array(
            'startline' => 437,
            'endline' => 474,
            'DeviceID' => 8
        ),
        'Projector' => array(
            'startline' => 478,
            'endline' => 535,
            'DeviceID' => 12
        ),
        'Screeen' => array(
            'startline' => 537,
            'endline' => 549,
            'DeviceID' => 24
        ),
        'Hifi' => array(
            'startline' => 552,
            'endline' => 627,
            'DeviceID' => 20
        ),
        'Camera' => array(
            'startline' => 632,
            'endline' => 634,
            'DeviceID' => 22
        ),
        'Fan' => array(
            'startline' => 641,
            'endline' => 675,
            'DeviceID' => 16
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