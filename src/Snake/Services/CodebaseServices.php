<?php
/**
 * 红外代码服务类
 *
 * User: snake
 * Date: 14-6-15
 * Time: 下午7:52
 */

namespace Snake\Services;


use Snake\BrandDB;
use Snake\CodebaseDB;
use Snake\ControllerDB;
use Snake\ControllerProtocolDB;
use Snake\DeviceInfo;
use Snake\FileInfo;
use Snake\TControllerProtocol;

class CodebaseServices
{
    /**
     * 获得表格数据
     *
     * @param $file
     * @return array
     */
    public function getFileContent($file)
    {
        $csvFile = new \Keboola\Csv\CsvFile($file);
        $clearedData = array(
            'controllerData' => array(),
            'codebasesData' => array()
        );

        # 读取表单数据
        foreach ($csvFile as $index => $row) {
            # 读取红外代码所属遥控器
            if ($index == \CodeBaseConfig::$controllerLine) {
                $tmp = array();
                foreach (\CodeBaseConfig::$controllerConfig as $key => $value) {
                    $tmp[$key] = trim($row[$value['X']]);
                }

                $clearedData['controllerData'] = $tmp;
            }

            # 读取红外代码行
            if ($index >= \CodeBaseConfig::$startLine) {
                # 判断是否已经属于空值
                if (empty($row[1]) && $row[1] != "0") {
                    break;
                }

                $tmp = array();
                foreach (\CodeBaseConfig::$codebaseConfig as $key => $value) {
                    $tmp[$key] = trim(str_replace(' ', '', $row[$value]));
                }

                # 组装CodeKey
                $tmp['CodeKey'] = $this->getCodeKey($tmp);
                array_push($clearedData['codebasesData'], $tmp);
            }

        }

        return $clearedData;
    }

    /**
     * 获得组装好的真正代码
     *
     * @param $unit
     * @return string
     */
    public function getCodeKey($unit)
    {
        $tmp = '';
        $tmp .= empty($unit['ControllerProtocolFlag']) ? '' : $unit['ControllerProtocolFlag'];
        $tmp .= empty($unit['RetransFrame']) ? '' : $unit['RetransFrame'];
        $tmp .= empty($unit['TVFormat']) ? '' : $unit['TVFormat'];
        $tmp .= empty($unit['CarrierCycle']) ? '' : $unit['CarrierCycle'];
        $tmp .= empty($unit['DataCycle']) ? '' : $unit['DataCycle'];
        $tmp .= empty($unit['CodeKeyTrue']) ? '' : $unit['CodeKeyTrue'];

        return $tmp;
    }

    /**
     * 插入红外代码数据库
     *
     * @param $file string 红外代码文件
     * @return array|bool
     */
    public function runInsertCodebaseMain($file)
    {
        # 数据库
        $db = new \medoo(\DBFileConfig::$dbinfo);
        # 清洗过的数据
        $data = $this->getFileContent($file);
        # 品牌ID
        $bdb = new BrandDB($db);
        # 查表获得品牌ID 用英文来匹配
        $ControllerBrandID = $bdb->getBrandIDByEn(strtoupper($data['controllerData']['ControllerBrand']));
        # 设备ID
        $ControllerDeviceID = DeviceInfo::$NameMap[$data['controllerData']['ControllerDevice']];
        # 协议ID
        # todo 协议id是根据协议代码库查询的
        # 该遥控器下面所属的协议
        $hasProtocol = array();

        # 协议录入部分
        # 数据记录该遥控器下面所有的协议名称
        $cpdb = new ControllerProtocolDB($db);
        foreach ($data['codebasesData'] as $index => $unit) {
            # 过滤空的协议
            if (empty($unit['Protocol']) && $unit['Protocol'] != "0") {
                continue;
            }
            # 是否存在该协议
            $insertedProtocoled = $cpdb->isInserted($unit['Protocol']);
            # 不存在该协议就插入数据库
            if (!$insertedProtocoled) {
                $tid = $cpdb->insert(
                    trim($unit['Protocol']),
                    #$unit['UserCode'],
                    trim($unit['ControllerProtocolFlag']),
                    trim($unit['RetransFrame']),
                    trim($unit['TVFormat']),
                    trim($unit['CarrierCycle']),
                    trim($unit['DataCycle']),
                    trim($unit['DataBits'])
                );
                # todo 插入协议数据日志
                array_push($hasProtocol, $tid);
            } else {
                $tid = $cpdb->getProtocolID($unit['Protocol']);
                array_push($hasProtocol, $tid);
            }
        }
        # todo 清理数组中重复的数据
        # todo 根据遥控器名称 品牌 设备 来判断

        # 把遥控器信息插入到数据库
        $cdb = new ControllerDB($db);
        $insertedController = $cdb->isInsertedByControllerBrandAndControllerDevice($data['controllerData']['ControllerName'], $ControllerBrandID, $ControllerDeviceID);
        if (!$insertedController) {
            # 注意 HasNumber的特殊处理
            $CodeController = $cdb->insert(
                '', # 由于有关系表 这个值被留空
                trim($data['controllerData']['ControllerType']),
                trim($data['controllerData']['ControllerName']),
                trim($data['controllerData']['ControllerSeries']),
                trim($ControllerBrandID),
                trim($ControllerDeviceID),
                'defaultcontrollericon',
                $data['controllerData']['HasNumber'] == '有' ? 1 : 0,
                trim($data['controllerData']['SourceFrom'])
            );

            $tcpdb = new TControllerProtocol($db);
            # 维护关系表
            foreach ($hasProtocol as $index => $value) {
                $insertedControllerProtocol = $tcpdb->isInserted($CodeController, $value);
                # todo 维护遥控器-协议关系表日志
                if (!$insertedControllerProtocol) {
                    $tcpdb->insert($CodeController, $value);
                }
            }
        } else {
            # 已经录入过了
            # 更新原来的数据
            # return false;
        }


        # 把红外代码数据插入到数据库
        # todo 增加出错处理
        $cbdb = new CodebaseDB($db);

        # 遥控器是否已经在数据
        # 不存在就直接insert
        # 存在就更新所有的值
        if (!$insertedController) {
            # 不存在
            foreach ($data['codebasesData'] as $index => $unit) {
                $resultInserted = $cbdb->insert(
                    trim($unit['CodeDisplayName']),
                    $CodeController,
                    trim($unit['UserCode']),
                    trim($unit['CodeName']),
                    trim($unit['CodeKey']),
                    trim($unit['CodeKeyTrue']),
                    trim($unit['CodeOrder']),
                    trim($unit['CodeDefaultIcon']),
                    trim($unit['CodeGroup']),
                    0
                );
                if (!$resultInserted) {
                    # 插入出错
                    return false;
                }
            }
        } else {
            # 存在
            $CodeController = $cdb->getControllerIDByControllerBrandAndControllerDevice($data['controllerData']['ControllerName'], $ControllerBrandID, $ControllerDeviceID);
            foreach ($data['codebasesData'] as $index => $unit) {
                $resultUpdated = $cbdb->update(
                    trim($unit['CodeDisplayName']),
                    $CodeController,
                    trim($unit['UserCode']),
                    trim($unit['CodeName']),
                    trim($unit['CodeKey']),
                    trim($unit['CodeKeyTrue']),
                    trim($unit['CodeOrder']),
                    trim($unit['CodeDefaultIcon']),
                    trim($unit['CodeGroup']),
                    0
                );

                if ($resultUpdated < 0) {
                    return false;
                }
            }
        }


        $r = FileInfo::rmCodeBaseFilePath($file);
        return $r;
    }

    /**
     * 遥控器信息日志
     *
     * @param string $ControllerType
     * @param string $ControllerName
     * @param string $ControllerSeries
     * @param string $ControllerBrand
     * @param string $ControllerDevice
     * @param string $ControllerImage
     * @param string $HasNumber
     * @param int $success
     */
    public function logConsoleController(
        $ControllerType = '',
        $ControllerName = '',
        $ControllerSeries = '',
        $ControllerBrand = '',
        $ControllerDevice = '',
        $ControllerImage = '',
        $HasNumber = '',
        $success = 1)
    {
        echo date('Y-m-d H:i:s') . ' ';
        echo '遥控器类型=' . (empty($ControllerType) ? 'null' : $ControllerType) . ' ';
        echo '遥控器名称=' . (empty($ControllerName) ? 'null' : $ControllerName) . ' ';
        echo '遥控器系列=' . (empty($ControllerSeries) ? 'null' : $ControllerSeries) . ' ';
        echo '遥控器品牌=' . (empty($ControllerBrand) ? 'null' : $ControllerBrand) . ' ';
        echo '遥控器设备=' . (empty($ControllerDevice) ? 'null' : $ControllerDevice) . ' ';
        echo '遥控器图片=' . (empty($ControllerImage) ? 'null' : $ControllerImage) . ' ';
        echo '是否有数字键盘' . (empty($HasNumber) ? 'null' : $HasNumber) . ' ';

        if ($success == 1) {
            echo '执行成功';
        }
        if ($success == 2) {
            echo '执行失败';
        }
        if ($success == 3) {
            echo '重复执行';
        }

        echo PHP_EOL;
    }

    /**
     * 红外代码信息日志
     *
     * @param string $CodeDisplayName
     * @param string $Protocol
     * @param string $UserCode
     * @param string $CodeKeyTrue
     * @param string $Cycle
     * @param string $ControllerProtocolFlag
     * @param string $RetransFrame
     * @param string $TVFormat
     * @param string $CarrierCycle
     * @param string $DataCycle
     * @param string $CodeName
     * @param string $CodeOrder
     * @param string $CodeGroup
     * @param string $CodeDefaultIcon
     * @param string $DataBits
     * @param int $success
     */
    public function logConsoleCodebase(
        $CodeDisplayName = '',
        $Protocol = '',
        $UserCode = '',
        $CodeKeyTrue = '',
        $Cycle = '',
        $ControllerProtocolFlag = '',
        $RetransFrame = '',
        $TVFormat = '',
        $CarrierCycle = '',
        $DataCycle = '',
        $CodeName = '',
        $CodeOrder = '',
        $CodeGroup = '',
        $CodeDefaultIcon = '',
        $DataBits = '',
        $success = 1)
    {
        echo date('Y-m-d H:i:s') . ' ';
        echo '按键显示的名称=' . (empty($CodeDisplayName) ? 'null' : $CodeDisplayName) . ' ';
        echo '协议名称=' . (empty($Protocol) ? 'null' : $Protocol) . ' ';
        echo '用户代码=' . (empty($UserCode) ? 'null' : $UserCode) . ' ';
        echo '按键代码值=' . (empty($CodeKeyTrue) ? 'null' : $CodeKeyTrue) . ' ';
        echo '载波=' . (empty($Cycle) ? 'null' : $Cycle) . ' ';
        echo '遥控器协议标记=' . (empty($ControllerProtocolFlag) ? 'null' : $ControllerProtocolFlag) . ' ';
        echo '重发帧数=' . (empty($RetransFrame) ? 'null' : $RetransFrame) . ' ';
        echo 'tv格式=' . (empty($TVFormat) ? 'null' : $TVFormat) . ' ';
        echo '载波周期=' . (empty($CarrierCycle) ? 'null' : $CarrierCycle) . ' ';
        echo '数据周期=' . (empty($DataCycle) ? 'null' : $DataCycle) . ' ';
        echo '按键真实的名称=' . (empty($CodeName) ? 'null' : $CodeName) . ' ';
        echo '按键排列序号=' . (empty($CodeOrder) ? 'null' : $CodeOrder) . ' ';
        echo '按键所属的分组=' . (empty($CodeOrder) ? 'null' : $CodeOrder) . ' ';
        echo '按键的类型=' . (empty($CodeGroup) ? 'null' : $CodeGroup) . ' ';
        echo '按键默认的图标=' . (empty($CodeDefaultIcon) ? 'null' : $CodeDefaultIcon);
        echo '数据位数=' . (empty($DataBits) ? 'null' : $DataBits);

        if ($success == 1) {
            echo '执行成功';
        }
        if ($success == 2) {
            echo '执行失败';
        }
        if ($success == 3) {
            echo '重复执行';
        }

        echo PHP_EOL;
    }
} 