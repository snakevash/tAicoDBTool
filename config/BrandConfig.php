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
            'endline' => 68,
            'DeviceID' => 2
        ),
        'Aircon' => array(
            'startline' => 72,
            'endline' => 123,
            'DeviceID' => 4
        ),
        'STB' => array(
            'startline' => 136,
            'endline' => 339,
            'DeviceID' => 6
        ),
        'CableTV' => array(
            'startline' => 342,
            'endline' => 376,
            'DeviceID' => 5
        ),
        'DVD' => array(
            'startline' => 385,
            'endline' => 413,
            'DeviceID' => 10
        ),
        'Amp' => array(
            'startline' => 419,
            'endline' => 453,
            'DeviceID' => 8
        ),
        'Projector' => array(
            'startline' => 456,
            'endline' => 515,
            'DeviceID' => 12
        ),
        'Screeen' => array(
            'startline' => 521,
            'endline' => 534,
            'DeviceID' => 24
        ),
        'Hifi' => array(
            'startline' => 536,
            'endline' => 607,
            'DeviceID' => 20
        ),
        'Camera' => array(
            'startline' => 612,
            'endline' => 615,
            'DeviceID' => 22
        ),
        'Fan' => array(
            'startline' => 621,
            'endline' => 653,
            'DeviceID' => 16
        ),
        'Other' => array(
            'startline' => 654,
            'endline' => 671,
            'DeviceID' => 40
        ),
        'Heater' => array(
            'startline' => 685,
            'endline' => 686,
            'DeviceID' => 14
        ),
        'VCR' => array(
            'startline' => 695,
            'endline' => 696,
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