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

        foreach (\BrandConfig::$brands as $k => $v) {
            $tmp = array();
            for ($i = $v['startline']; $i < $v['endline']; $i++) {
                $ttmp = array(
                    'CN' => trim($sheetData[$i][\BrandConfig::$columns['CN']]),
                    'EN' => trim($sheetData[$i][\BrandConfig::$columns['EN']])
                );
                array_push($tmp, $ttmp);
            }

            $clearedData[$k] = array(
                'DeviceID' => $v['DeviceID'],
                'Data' => $tmp
            );
        }

        return $clearedData;
    }

    /**
     * 插入品牌数据表
     *
     * @param $file
     */
    public function runInsertBrandMain($file)
    {
        # 遍历数据结构
        $data = $this->getFileContent($file);

        $db = new \medoo(\DBFileConfig::$dbinfo);
        $dbmodel = new BrandDB($db);
        foreach ($data as $t => $v) {
            foreach ($v['Data'] as $index => $vv) {
//                echo '插入的数据是: 序号=' . $index .
//                    ' CN=' . $vv['CN'] .
//                    ' EN=' . (is_null($vv['EN']) ? 'null' : $vv['EN']) .
//                    ' DeviceID=' . $v['DeviceID'] . PHP_EOL;
                # todo 只做了品牌的英文名称和中文名称
                $DeviceID = $v['DeviceID'];
                $BrandName = (is_null($vv['EN']) ? '' : $vv['EN']);
                $DisplayNameCN = $vv['CN'];

                # 首先插入Brand信息
                # 判断品牌是否已经插入过
                if ($dbmodel->isInserted($DisplayNameCN)) {
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
                            $this->logConsole($DisplayNameCN, $BrandName, $BrandID, $DeviceID);
                        } else {
                            $this->logConsole($DisplayNameCN, $BrandName, $BrandID, $DeviceID);
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
                        # 如果插入了就什么就不用管了
                    } else {
                        # 如果没有插入，那么，就先插入那么就ok了
                        $r = $dbmodel->insertTDeviceBrand($BrandID, $DeviceID);

                        # debug信息
                        if ($r) {
                            $this->logConsole($DisplayNameCN, $BrandName, $BrandID, $DeviceID);
                        } else {
                            $this->logConsole($DisplayNameCN, $BrandName, $BrandID, $DeviceID);
                        }
                    }
                }
            }
        }
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
} 