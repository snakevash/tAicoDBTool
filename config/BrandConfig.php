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
            'endline' => 65,
            'DeviceID' => 2
        ),
        'Aircon' => array(
            'startline' => 71,
            'endline' => 116,
            'DeviceID' => 4
        ),
        'STB' => array(
            'startline' => 120,
            'endline' => 319,
            'DeviceID' => 6
        ),
        'CableTV' => array(
            'startline' => 326,
            'endline' => 333,
            'DeviceID' => 5
        ),
        'DVD' => array(
            'startline' => 338,
            'endline' => 366,
            'DeviceID' => 10
        ),
        'Amp' => array(
            'startline' => 372,
            'endline' => 406,
            'DeviceID' => 8
        ),
        'Projector' => array(
            'startline' => 409,
            'endline' => 468,
            'DeviceID' => 12
        ),
        'Screeen' => array(
            'startline' => 474,
            'endline' => 487,
            'DeviceID' => 24
        ),
        'Hifi' => array(
            'startline' => 489,
            'endline' => 560,
            'DeviceID' => 20
        ),
        'Camera' => array(
            'startline' => 565,
            'endline' => 568,
            'DeviceID' => 22
        ),
        'Fan' => array(
            'startline' => 574,
            'endline' => 606,
            'DeviceID' => 16
        ),
        'Other' => array(
            'startline' => 607,
            'endline' => 624,
            'DeviceID' => 40
        ),
        'Heater' => array(
            'startline' => 638,
            'endline' => 639,
            'DeviceID' => 14
        ),
        'VCR' => array(
            'startline' => 648,
            'endline' => 649,
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