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
            'endline' => 55,
            'DeviceID' => 2
        ),
        'Aircon' => array(
            'startline' => 57,
            'endline' => 86,
            'DeviceID' => 4
        ),
        'STB' => array(
            'startline' => 92,
            'endline' => 331,
            'DeviceID' => 6
        ),
        'DVD' => array(
            'startline' => 359,
            'endline' => 385,
            'DeviceID' => 10
        ),
        'Amp' => array(
            'startline' => 389,
            'endline' => 422,
            'DeviceID' => 8
        ),
        'Projector' => array(
            'startline' => 426,
            'endline' => 482,
            'DeviceID' => 12
        ),
        'Screeen' => array(
            'startline' => 484,
            'endline' => 496,
            'DeviceID' => 24
        ),
        'Hifi' => array(
            'startline' => 499,
            'endline' => 574,
            'DeviceID' => 20
        ),
        'Camera' => array(
            'startline' => 579,
            'endline' => 581,
            'DeviceID' => 22
        ),
        'Fan' => array(
            'startline' => 588,
            'endline' => 625,
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