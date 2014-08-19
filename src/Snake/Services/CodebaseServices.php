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
        $filecontent = file_get_contents($file);
        $codetype = array('ASCII','GB2312','GBK','UTF-8');

        # 检测是否需要重新编码
        $encodeType = mb_detect_encoding($filecontent, $codetype ,true);
        if($encodeType != 'UTF-8'){
            $filecontent = mb_convert_encoding($filecontent,'UTF-8',$encodeType);
        }

        # 检查写入文件成功
        if(!file_put_contents($file,$filecontent)){
            return false;
        }

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

                # 判断是否是有限机顶盒
                if(
                    isset($tmp['ControllerDevice'])
                    && $tmp['ControllerDevice'] == 'CableTV'
                )
                {
                    $tmpKeys = explode('~~',$tmp['ControllerName']);
                    $tmp['ControllerName'] = $tmpKeys[1];
                    $tmp['ControllerNameCN'] = $tmpKeys[0];
                } else {
                    $tmp['ControllerNameCN'] = ''; # 默认是为空
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
        $tmp .= empty($unit['DataBits']) ? '' : $unit['DataBits'];
        $tmp .= empty($unit['CodeKeyTrue']) ? '' : $unit['CodeKeyTrue'];

        return $tmp;
    }

    /**
     * 插入红外代码数据库
     *
     * @param $file
     * @param bool $isWeb
     * @param string $webpath web的文件地址
     * @return bool
     */
    public function runInsertCodebaseMain($file,$isWeb = false, $webpath = '')
    {
        # 数据库
        $db = new \medoo(\DBFileConfig::$dbinfo);
        # 清洗过的数据
        $data = $this->getFileContent($file);

        # 如果文件没有解析成功
        # 移动到fail文件夹
        if(!$data){
            if($isWeb){
                $r = FileInfo::rmCodeBaseFileToFailWeb($file,$webpath);
            } else {
                $r = FileInfo::rmCodeBaseFileToFail($file);
            }
            return array('result'=>$r,'operationType'=>'上传文件');
        }

        # 品牌ID
        $bdb = new BrandDB($db);
        # 查表获得品牌ID 用英文来匹配
        $ControllerBrandID = $bdb->getBrandIDByEn(strtoupper($data['controllerData']['ControllerBrand']));
        # 设备ID
        $ControllerDeviceID = DeviceInfo::$NameMap[$data['controllerData']['ControllerDevice']];

        # 该遥控器下面所属的协议
        $hasProtocol = array();

        # 协议录入部分开始

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

        # 该控制器下面所属的协议结束

        # 清理数组中重复的数据 提高性能
        $hasProtocol = array_unique($hasProtocol);

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
                trim($data['controllerData']['SourceFrom']),
                trim($data['controllerData']['ControllerNameCN'])
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
            # 只提供修补遥控器品牌的功能

            $CodeController = $cdb->getControllerIDByControllerBrandAndControllerDevice($data['controllerData']['ControllerName'], 0, $ControllerDeviceID);
            $CodeController = $cdb->update(
                $CodeController,
                '', # 由于有关系表 这个值被留空
                trim($data['controllerData']['ControllerType']),
                trim($data['controllerData']['ControllerName']),
                trim($data['controllerData']['ControllerSeries']),
                trim($ControllerBrandID),
                trim($ControllerDeviceID),
                'defaultcontrollericon',
                $data['controllerData']['HasNumber'] == '有' ? 1 : 0,
                trim($data['controllerData']['SourceFrom']),
                trim($data['controllerData']['ControllerNameCN'])
            );
        }


        # 把红外代码数据插入到数据库
        $cbdb = new CodebaseDB($db);
        $CodeGroup3Index = range(100, 149, 1);
        $CodeGroup4Index = range(150, 255, 1);
        # 可能会分配完，但是至今没有碰见过

        # 遥控器是否已经在数据
        # 不存在就直接insert
        # 存在就更新值 包括新增、修改、删除
        if (!$insertedController) {
            # 不存在
            foreach ($data['codebasesData'] as $index => $unit) {
                # $codeOrder 产生codeOrder
                if (empty($unit['CodeOrder'])) {
                    switch ($unit['CodeGroup']) {
                        case '3':
                            $unit['CodeOrder'] = array_shift($CodeGroup3Index);
                            break;
                        case '4':
                            $unit['CodeOrder'] = array_shift($CodeGroup4Index);
                            break;
                        default:
                            break;
                    }
                }

                $resultInserted = $cbdb->insert(
                    trim($unit['CodeDisplayName']),
                    $CodeController,
                    trim($unit['UserCode']),
                    trim($unit['KeyCode']),
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
            # 用于删除那些已经删除掉的代码
            $codeIDs = array();

            foreach ($data['codebasesData'] as $index => $unit) {
                # 查找codeid是否插入过
                $codeInserted = $cbdb->isInsertedByCodeDisplayNameAndCodeController($unit['CodeDisplayName'], $CodeController);

                if ($codeInserted) {
                    if (empty($unit['CodeOrder'])) {
                        switch ($unit['CodeGroup']) {
                            case '3':
                                $unit['CodeOrder'] = array_shift($CodeGroup3Index);
                                break;
                            case '4':
                                $unit['CodeOrder'] = array_shift($CodeGroup4Index);
                                break;
                            default:
                                break;
                        }
                    }

                    # 更新键值
                    $resultUpdated = $cbdb->update(
                        trim($unit['CodeDisplayName']),
                        $CodeController,
                        trim($unit['UserCode']),
                        trim($unit['KeyCode']),
                        trim($unit['CodeName']),
                        trim($unit['CodeKey']),
                        trim($unit['CodeKeyTrue']),
                        trim($unit['CodeOrder']),
                        trim($unit['CodeDefaultIcon']),
                        trim($unit['CodeGroup']),
                        0
                    );

                    # 如果发生错误 报错
                    # < 0 是因为 可能这个按键什么都没有更新
                    # 反正直接重新更新 优化速度
                    if ($resultUpdated < 0) {
                        return false; # todo 如果出错 那么怎么撤销之前的插入
                    }

                    # 增加相关codeid
                    $insertedCodeID = $cbdb->getCodeID(trim($unit['CodeDisplayName']), trim($CodeController));
                    array_push($codeIDs, $insertedCodeID);
                } else {

                    # 插入之前 根据CodeGroup来判断 应该给它随机产生什么值？
                    # 有一个问题在于 每次更新的时候，CodeOrder可能会改变
                    # codeGroup = 3、4的CodeOrder前台是不需要的
                    # 所以 codeGroup = 3、4的CodeOrder不能在前端使用

                    # 2014-08-08 代码插入数据库随机产生CodeOrder，CodeGroup为3，4
                    if (empty($unit['CodeOrder'])) {
                        switch ($unit['CodeGroup']) {
                            case '3':
                                $unit['CodeOrder'] = array_shift($CodeGroup3Index);
                                break;
                            case '4':
                                $unit['CodeOrder'] = array_shift($CodeGroup4Index);
                                break;
                            default:
                                break;
                        }
                    }

                    # 插入新的按键
                    $resultInserted = $cbdb->insert(
                        trim($unit['CodeDisplayName']),
                        $CodeController,
                        trim($unit['UserCode']),
                        trim($unit['KeyCode']),
                        trim($unit['CodeName']),
                        trim($unit['CodeKey']),
                        trim($unit['CodeKeyTrue']),
                        trim($unit['CodeOrder']),
                        trim($unit['CodeDefaultIcon']),
                        trim($unit['CodeGroup']),
                        0
                    );

                    # 把相关的代码id增加到对比数组中
                    array_push($codeIDs, $resultInserted);

                    if (!$resultInserted) {
                        # 插入出错
                        return false;
                    }
                }
            }
            # 删除数据库中多余的数据记录
            $databaseCodeIDs = $cbdb->getOneControllerAllCodeids($CodeController);
            $diffArray = array_diff($databaseCodeIDs, $codeIDs);
            if (count($diffArray) > 0) {
                $deleteResult = $cbdb->deleteByCodeIDs($diffArray);
            }
        }

        $r = false;
        if($isWeb){
            # 调用web端的文件夹移动
            $r = FileInfo::rmCodeBaseFilePathWeb($file,$webpath);
        } else {
            # 调用console端的文件夹移动
            $r = FileInfo::rmCodeBaseFilePath($file);
        }
        return array('result'=>$r,'operationType'=>'导入代码');
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