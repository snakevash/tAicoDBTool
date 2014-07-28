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
        'NetSTB' => array(
            'startline' => 92,
            'endline' => 319,
            'DeviceID' => 5
        ),
        'STB' => array(
            'startline' => 332,
            'endline' => 334,
            'DeviceID' => 6
        ),
        'DVD' => array(
            'startline' => 346,
            'endline' => 372,
            'DeviceID' => 10
        ),
        'Amp' => array(
            'startline' => 376,
            'endline' => 409,
            'DeviceID' => 8
        ),
        'Projector' => array(
            'startline' => 413,
            'endline' => 469,
            'DeviceID' => 12
        ),
        'Screeen' => array(
            'startline' => 471,
            'endline' => 483,
            'DeviceID' => 24
        ),
        'Hifi' => array(
            'startline' => 486,
            'endline' => 557,
            'DeviceID' => 20
        ),
        'Camera' => array(
            'startline' => 563,
            'endline' => 565,
            'DeviceID' => 22
        ),
        'Fan' => array(
            'startline' => 572,
            'endline' => 609,
            'DeviceID' => 16
        ),
        'Other' => array(
            'startline' => 611,
            'endline' => 618,
            'DeviceID' => 40
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