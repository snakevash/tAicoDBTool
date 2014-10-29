<?php
/**
 * 品牌服务类
 *
 * User: snake
 * Date: 14-6-12
 * Time: 下午3:37
 */

namespace Snake\Services;


use Snake\BrandDB;
use Snake\FileInfo;

class BrandServices
{

    /**
     * 获得表格数据
     *
     * @param $file
     * @return array
     */
    public function getFileContent($file)
    {

        $PHPExcel = \PHPExcel_IOFactory::load($file);
        $sheetData = $PHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $clearedData = array();

        $tmp = array();
        foreach($sheetData as $line){
            array_push($tmp,array(
                'CN' => trim($line['B']),
                'EN' => trim(strtoupper($line['C']))
            ));
        }

        $clearedData[$sheetData[1]['A']] = array(
            'DeviceID' => \BrandConfig::$brands[$sheetData[1]['A']]['DeviceID'],
            'Data' => $tmp
        );

        return $clearedData;
    }

    /**
     * 插入品牌数据表
     *
     * @param $file
     * @param bool $isWeb
     * @param string $webpath
     * @return array
     */
    public function runInsertBrandMain($file,$isWeb = false, $webpath = '')
    {
        # 遍历数据结构
        $data = $this->getFileContent($file);

        $results = array();
        $db = new \medoo(\DBFileConfig::$dbinfo);
        $dbmodel = new BrandDB($db);
        foreach ($data as $t => $v) {
            foreach ($v['Data'] as $index => $vv) {
                $DeviceID = $v['DeviceID'];
                $BrandName = (is_null($vv['EN']) ? '' : trim($vv['EN']));
                $DisplayNameCN = trim($vv['CN']); # 增加空格过滤功能

                # 首先插入Brand信息
                # 判断品牌是否已经插入过
                if ($dbmodel->isInsertedCNAndEn($DisplayNameCN, $BrandName)) {
                    # 获得BrandID
                    $BrandID = $dbmodel->getBrandID($DisplayNameCN);
                    # 查看BrandID和DeviceID是否已经插入
                    if ($dbmodel->isInsertedTDeviceBrand($BrandID, $DeviceID)) {
                        # 如果插入了就什么就不用管了
                    } else {
                        # 如果没有插入，那么，就先插入那么就ok了
                        $r = $dbmodel->insertTDeviceBrand($BrandID, $DeviceID);

                        # debug信息
                        if ($r) {
                            # 更新BrandID时间戳 时间戳觉得遥控器是否被更新过
                            $dbmodel->touchBrandTime($BrandID);

                            #$this->logConsole($DisplayNameCN, $BrandName, $BrandID, $DeviceID);
                            $results[] = $this->logConsoleWeb($DisplayNameCN, $BrandName, $BrandID, $DeviceID);
                        } else {
                            #$this->logConsole($DisplayNameCN, $BrandName, $BrandID, $DeviceID);
                            $results[] = $this->logConsoleWeb($DisplayNameCN, $BrandName, $BrandID, $DeviceID,false);
                        }
                    }

                } else {
                    # 获得BrandID
                    $tmpBrandID = $dbmodel->insert(
                        $BrandName,
                        '',
                        $DisplayNameCN,
                        '',
                        0,
                        '');
                    $BrandID = $tmpBrandID;

                    # 查看BrandID和DeviceID是否已经插入
                    if ($dbmodel->isInsertedTDeviceBrand($BrandID, $DeviceID)) {
                        # 如果插入了 就记录一下日志
                        $results[] = $this->logConsoleWeb($DisplayNameCN,$BrandName,$BrandID,$DeviceID);
                    } else {
                        # 如果没有插入，那么，就先插入那么就ok了
                        $r = $dbmodel->insertTDeviceBrand($BrandID, $DeviceID);

                        # debug信息
                        if ($r) {
                            #$this->logConsole($DisplayNameCN, $BrandName, $BrandID, $DeviceID);
                            $results[] = $this->logConsoleWeb($DisplayNameCN, $BrandName, $BrandID, $DeviceID);
                        } else {
                            #$this->logConsole($DisplayNameCN, $BrandName, $BrandID, $DeviceID);
                            $results[] = $this->logConsoleWeb($DisplayNameCN, $BrandName, $BrandID, $DeviceID,false);
                        }
                    }
                }
            }
        }

        if($isWeb){
            FileInfo::rmBrandFilePathWeb($file,$webpath);
        } else {
            FileInfo::rmBrandFilePath($file);
        }

        return $results;
    }

    /**
     * 执行日志
     *
     * @param $DisplayNameCN
     * @param $BrandName
     * @param $BrandID
     * @param $DeviceID
     * @param bool $success
     */
    public function logConsole(
        $DisplayNameCN,
        $BrandName,
        $BrandID,
        $DeviceID,
        $success = true)
    {
        echo date('Y-m-d H:i:s') . ' ';
        echo '中文名称=' . $DisplayNameCN . ' ';
        echo '英文名称=' . (is_null($BrandName) ? 'null' : $BrandName) . ' ';
        echo '品牌ID=' . $BrandID . ' ';
        echo '设备ID=' . $DeviceID . ' ';
        echo $success ? '执行成功' : '执行失败';
        echo PHP_EOL;
    }

    /**
     * web端控制台输出
     *
     * @param $DisplayNameCN
     * @param $BrandName
     * @param $BrandID
     * @param $DeviceID
     * @param bool $success
     * @return string
     */
    public function logConsoleWeb(
        $DisplayNameCN,
        $BrandName,
        $BrandID,
        $DeviceID,
        $success = true)
    {
        $result = '';
        $result .= date('Y-m-d H:i:s') . ' ';
        $result .= '中文名称=' . $DisplayNameCN . ' ';
        $result .= '英文名称=' . (is_null($BrandName) ? 'null' : $BrandName) . ' ';
        $result .= '品牌ID=' . $BrandID . ' ';
        $result .= '设备ID=' . $DeviceID . ' ';
        $result .= $success ? '执行成功' : '执行失败';
        $result .= '<br/>';
        return $result;
    }
} 