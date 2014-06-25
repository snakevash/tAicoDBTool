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
            'endline' => 360,
            'DeviceID' => 6
        ),
        'DVD' => array(
            'startline' => 388,
            'endline' => 414,
            'DeviceID' => 10
        ),
        'Amp' => array(
            'startline' => 418,
            'endline' => 455,
            'DeviceID' => 8
        ),
        'Projector' => array(
            'startline' => 459,
            'endline' => 516,
            'DeviceID' => 12
        ),
        'Screeen' => array(
            'startline' => 518,
            'endline' => 530,
            'DeviceID' => 24
        ),
        'Hifi' => array(
            'startline' => 533,
            'endline' => 608,
            'DeviceID' => 20
        ),
        'Camera' => array(
            'startline' => 613,
            'endline' => 615,
            'DeviceID' => 22
        ),
        'Fan' => array(
            'startline' => 622,
            'endline' => 656,
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