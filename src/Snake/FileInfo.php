<?php
/**
 * 文件信息工具
 *
 * User: snake
 * Date: 14-6-11
 * Time: 下午5:01
 */

namespace Snake;


class FileInfo
{
    /**
     * 获得相关文件夹里面的文件
     *
     * @param $dir
     * @return array
     */
    public static function getFilePathInfo($dir)
    {
        $filesArray = array();

        $tmpDir = dir($dir);
        while ($file = $tmpDir->read()) {
            if (!(is_dir("$dir" . DIRECTORY_SEPARATOR . "$file")) && ($file != '.') && ($file != '..')) {
                array_push($filesArray, "$dir/$file");
            }
        }

        $tmpDir->close();
        return $filesArray;
    }

    /**
     * 移动处理过的红外代码
     *
     * @param $file
     * @return bool
     */
    public static function rmCodeBaseFilePath($file){
        $fileinfo = explode(DIRECTORY_SEPARATOR,$file);
        $filename = array_pop($fileinfo);
        $newname = \OtherConfig::CODEBASEAFTER . DIRECTORY_SEPARATOR . $filename;

        $r = rename($file,$newname);
        return $r;
    }

    /**
     * 移动处理过的红外代码到失败文件夹
     *
     * @param $file
     * @return bool
     */
    public static function rmCodeBaseFileToFail($file){
        $fileinfo = explode(DIRECTORY_SEPARATOR,$file);
        $filename = array_pop($fileinfo);
        $newname = \OtherConfig::CODEBASEFAIL . DIRECTORY_SEPARATOR . $filename;

        $r = rename($file,$newname);
        return $r;
    }

    /**
     * 移动处理过的系列文件
     *
     * @param $file
     * @return bool
     */
    public static function rmSeriesFilePath($file){
        $fileinfo = explode(DIRECTORY_SEPARATOR,$file);
        $filename = array_pop($fileinfo);
        $newname = \OtherConfig::BRANDAFTER . DIRECTORY_SEPARATOR . $filename;

        $r = rename($file,$newname);
        return $r;
    }
} 