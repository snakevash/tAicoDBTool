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
     * 日志模块名称
     */
    const BRANDLOG = 'BrandModule';
    const CODEBASELOG = 'CodebaseModule';
    const CONTROLLERLOG = 'ControllerModule';
    const SERIESLOG = 'SeriesModule';

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
     * @param string $currentFile 当前日志文件的文件目录/文件名称
     * @param bool $flag 完成度
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

    /**
     * 写日志
     *
     * @param $modulename
     * @param string $message
     * @param array $arrLog
     * @return bool
     */
    public static function writeLog($modulename, $message = '', array $arrLog = array())
    {
        # 如果文件不存在 创建文件
        if (!file_exists($modulename)) {
            @touch($modulename);
        }

        # 得到文件名
        $fileTrueName = array_shift(explode('.',array_pop(explode(DIRECTORY_SEPARATOR, $modulename))));

        $log = new Logger($fileTrueName);
        $log->pushHandler(new StreamHandler($modulename, Logger::DEBUG));
        $r = $log->addInfo($message, $arrLog);
        return $r;
    }

    /**
     * 当前文件是否完成
     *
     * @return bool
     */
    public static function getCurrentIsFinished(){
        $file = \OtherConfig::LOGS . DIRECTORY_SEPARATOR . \OtherConfig::INIFile;

        if(file_exists($file)){
            $content = file_get_contents($file);
            $content = json_decode($content,true);
            return $content['current']['isFinished'];
        }else{
            return false;
        }
    }
}