<?php
/**
 * 自定义文件日志类
 * 增加向console打印消息的功能
 *
 * User: snake
 * Date: 14-6-18
 * Time: 下午5:20
 */

namespace Snake\Log;


use Monolog\Logger;

class StreamHandler extends \Monolog\Handler\StreamHandler {

    /**
     * 父类构造
     *
     * @param string $stream
     * @param bool|int $level
     * @param bool $bubble
     * @param null $filePermission
     */
    public function __construct($stream, $level = Logger::DEBUG, $bubble = true,$filePermission = null)
    {
        parent::__construct($stream,$level,$bubble,$filePermission);
    }

    /**
     * 往console里面写日志
     *
     * @param array $record
     */
    protected function write(array $record){
        parent::write($record);
        echo $record['formatted'] . PHP_EOL;
    }
} 