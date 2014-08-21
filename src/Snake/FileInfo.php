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
            # 增加git的过滤文件
            if (!(is_dir("$dir" . DIRECTORY_SEPARATOR . "$file"))
                && ($file != '.')
                && ($file != '..')
                && ($file != '.gitignore')
                ) {
                array_push($filesArray, "$dir/$file");
            }
        }

        $tmpDir->close();
        return $filesArray;
    }

    /**
     * 获得文件名称
     *
     * @param $file
     * @return mixed
     */
    public static function getFileName($file){
        $fileinfo = explode(DIRECTORY_SEPARATOR,$file);
        $filename = array_pop($fileinfo);

        return $filename;
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
     * 移动处理过的品牌文件
     *
     * @param $file
     * @return bool
     */
    public static function rmBrandFilePath($file){
        $fileinfo = explode(DIRECTORY_SEPARATOR,$file);
        $filename = array_pop($fileinfo);
        $newname = \OtherConfig::BRANDAFTER . DIRECTORY_SEPARATOR . $filename;

        $r = rename($file,$newname);
        return $r;
    }

    /**
     * web 移动处理完的代码文件
     *
     * @param string $file 完整地址的文件地址
     * @param string $path web端的地址用常量来表示的
     * @return bool
     */
    public static function rmCodeBaseFilePathWeb($file,$path){
        $fileinfo = explode(DIRECTORY_SEPARATOR,$file);
        $filename = array_pop($fileinfo);
        $newname = $path . DIRECTORY_SEPARATOR . $filename;

        $r = rename($file,$newname);
        return $r;
    }

    /**
     * web 移动处理完的品牌文件
     *
     * @param $file
     * @param $path
     * @return bool
     */
    public static function rmBrandFilePathWeb($file,$path){
        return static::rmCodeBaseFilePathWeb($file,$path);
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
     * web端 移动处理过的红外代码到失败文件夹
     *
     * @param $file
     * @param $path
     * @return bool
     */
    public static function rmCodeBaseFileToFailWeb($file,$path){
        $fileinfo = explode(DIRECTORY_SEPARATOR,$file);
        $filename = array_pop($fileinfo);
        $newname = $path . DIRECTORY_SEPARATOR . $filename;

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