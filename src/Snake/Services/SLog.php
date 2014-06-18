<?php
/**
 * 日志服务类
 *
 * User: snake
 * Date: 14-6-18
 * Time: 下午1:56
 */

namespace Snake\Services;


use Snake\Log\StreamHandler;
use Monolog\Logger;

class SLog
{

    /**
     * 创建一个由时间命名的文件夹
     *
     * @return bool|string
     */
    public static function createOneDir()
    {
        date_default_timezone_set('Asia/Shanghai');
        $time = date('Y_m_d_H_i_s', time());
        $dirpath = \OtherConfig::LOGS . DIRECTORY_SEPARATOR . $time;
        $r = mkdir($dirpath);
        return $r ? $time : false;
    }

    /**
     * 保存中间结果到文件
     *
     * @param $currentFile
     * @param bool $flag
     * @return bool
     */
    public static function writeINIFile($currentFile, $flag = false)
    {
        $file = \OtherConfig::LOGS . DIRECTORY_SEPARATOR . \OtherConfig::INIFile;
        # 是否存在文件
        if (file_exists($file)) {
            $content = file_get_contents($file);
            $tmp = json_decode($content, true);
            # 判断文件名字是否相同
            if ($tmp['current']['dirName'] == $currentFile) {
                # 一样就重新标记是否完成
                $tmp['current']['isFinished'] = $flag;
            } else {
                # 不一样就归档增加
                array_push($tmp['old'], $tmp['current']);
                $tmp['current']['dirName'] = $currentFile;
                $tmp['current']['isFinished'] = $flag;
            }

            return !!file_put_contents($file, json_encode($tmp));
        } else {
            # 如果没有相关文件
            # 那么就重新构建
            $tmp = array(
                'current' => array(
                    'dirName' => $currentFile,
                    'isFinished' => $flag
                ),
                'old' => array()
            );
            return !!file_put_contents($file, json_encode($tmp));
        }
    }


    public static function writeLog($filename, array $arrLog = array())
    {
        $log = new Logger('SnakeLog');
        $log->pushHandler(new StreamHandler($filename,Logger::DEBUG));
        $log->pushProcessor(function($record){
            $record['extra']['dummy'] = array(
                'aaa'=>'bbb',
                'ccc'=>'ddd'
            );
            return $record;
        });
        $log->addInfo('这里是测试bbbb',array(
            'a'=>'b',
            'c'=>'d',
            'e'=>'f'
        ));
        $ps = $log->getProcessors();
    }
}