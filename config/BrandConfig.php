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
     * 注意：
     * 最终行是+1的
     *
     * @var array 品牌文件相关配置文件
     */
    public static $brands = array(
        'TV' => array(
            'startline' => 2,
            'endline' => 67,
            'DeviceID' => 2
        ),
        'Aircon' => array(
            'startline' => 71,
            'endline' => 119,
            'DeviceID' => 4
        ),
        'STB' => array(
            'startline' => 125,
            'endline' => 324,
            'DeviceID' => 6
        ),
        'CableTV' => array(
            'startline' => 331,
            'endline' => 338,
            'DeviceID' => 5
        ),
        'DVD' => array(
            'startline' => 343,
            'endline' => 371,
            'DeviceID' => 10
        ),
        'Amp' => array(
            'startline' => 377,
            'endline' => 411,
            'DeviceID' => 8
        ),
        'Projector' => array(
            'startline' => 414,
            'endline' => 473,
            'DeviceID' => 12
        ),
        'Screeen' => array(
            'startline' => 479,
            'endline' => 492,
            'DeviceID' => 24
        ),
        'Hifi' => array(
            'startline' => 494,
            'endline' => 565,
            'DeviceID' => 20
        ),
        'Camera' => array(
            'startline' => 570,
            'endline' => 573,
            'DeviceID' => 22
        ),
        'Fan' => array(
            'startline' => 579,
            'endline' => 611,
            'DeviceID' => 16
        ),
        'Other' => array(
            'startline' => 612,
            'endline' => 629,
            'DeviceID' => 40
        ),
        'Heater' => array(
            'startline' => 643,
            'endline' => 644,
            'DeviceID' => 14
        ),
        'VCR' => array(
            'startline' => 653,
            'endline' => 654,
            'DeviceID' => 28
        )
    );

    /**
     * @var array 列定义
     */
    public static $columns = array(
        'CN' => 'B', # 品牌中文列表
        'EN' => 'C', # 品牌英文列表
        'Stop' => 'F', # 停产品牌
    );
} 