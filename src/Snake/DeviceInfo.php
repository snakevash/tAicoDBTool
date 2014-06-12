<?php
/**
 * 设备信息
 *
 * User: snake
 * Date: 14-6-11
 * Time: 下午5:33
 */

namespace Snake;


class DeviceInfo
{
    /**
     * 文件名映射
     * 文件名=>'DeviceID'
     *
     * @var array 文件名字匹配
     */
    public static $NameMap = array(
        'TV' => '2',
        'Aircon' => '4',
        'STB' => '6',
        'Amp' => '8',
        'DVD' => '10',
        'Projector' => '12',
        'Heater' => '14',
        'Fan' => '16',
        'Toy' => '18',
        'Hifi' => '20',
        'Camera' => '22',
        'Screen' => '24',
        'Light' => '26',
        'VCR' => '28',
        'Other' => '30',
    );


} 