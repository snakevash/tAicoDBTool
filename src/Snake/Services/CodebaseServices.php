<?php
/**
 * 红外代码服务类
 *
 * User: snake
 * Date: 14-6-15
 * Time: 下午7:52
 */

namespace Snake\Services;


use Snake\ControllerDB;

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
        foreach($csvFile as $index => $row){
            # 读取红外代码所属遥控器
            if($index == \CodeBaseConfig::$controllerLine){
                $tmp = array();
                foreach(\CodeBaseConfig::$controllerConfig as $key => $value){
                    $tmp[$key] = $row[$value['X']];
                }

                $clearedData['controllerData'] = $tmp;
            }

            # 读取红外代码行
            if($index >= \CodeBaseConfig::$startLine){
                # 判断是否已经属于空值
                if(empty($row[1])){
                    break;
                }

                $tmp = array();
                foreach(\CodeBaseConfig::$codebaseConfig as $key => $value){
                    $tmp[$key] = $row[$value];
                }
                array_push($clearedData['codebasesData'],$tmp);
            }

        }

        return $clearedData;
    }

    public function runInsertCodebaseMain($file){
        # 数据库
        $db = new \medoo(\DBFileConfig::$dbinfo);
        # 清洗过的数据
        $data = $this->getFileContent($file);
        # 品牌ID
        $CodeController = '';
        # 设备ID
        $ControllerDevice = '1';


        # 把遥控器信息插入到数据库
        $cdb = new ControllerDB($db);
        $r = $cdb->isInserted($data['controllerData']['ControllerName']);
        if($r){
            $CodeController = $cdb->insert(
                $data['controllerData']['ControllerProtocol'],
                $data['controllerData']['ControllerType'],
                $data['controllerData']['ControllerName'],
                $data['controllerData']['ControllerSeries'],
                $data['controllerData']['ControllerBrand'],
                $data['controllerData']['ControllerDevice'],
                $data['controllerData']['ControllerImages'],
                $data['controllerData']['HasNumberPad']);
        } else {
            # 已经录入过了
            return false;
        }
        # 把红外代码数据插入到数据库
        # todo 增加出错处理
        $cbdb = new CodebaseDB($db);
        foreach ($data['codebasesData'] as $index => $unit) {
            $r = $cbdb->insert(
                $data['codebasesData']['CodeDisplayName'],
                $CodeController,
                $data['codebasesData']['CodeName'],
                $data['codebasesData']['CodeKey'],
                $data['codebasesData']['CodeKeyTrue'],
                $data['codebasesData']['CodeOrder'],
                $data['codebasesData']['CodeDefaultIcon'],
                $data['codebasesData']['CodeGroup'],
                ($data['codebasesData']['CodeIsNeedIndex'] == "有") ? 1 : 0
            );
            if(!$r){
                # 插入出错
                return false;
            }
        }
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
        $success = 1){
        echo date('Y-m-d H:i:s') . ' ';
        echo '遥控器类型=' . (empty($ControllerType) ? 'null' : $ControllerType) . ' ';
        echo '遥控器名称=' . (empty($ControllerName) ? 'null' : $ControllerName) . ' ';
        echo '遥控器系列=' . (empty($ControllerSeries) ? 'null' : $ControllerSeries) . ' ';
        echo '遥控器品牌=' . (empty($ControllerBrand) ? 'null' : $ControllerBrand) . ' ';
        echo '遥控器设备=' . (empty($ControllerDevice) ? 'null' : $ControllerDevice) . ' ';
        echo '遥控器图片=' . (empty($ControllerImage) ? 'null' : $ControllerImage) . ' ';
        echo '是否有数字键盘' . (empty($HasNumber) ? 'null' : $HasNumber) . ' ';

        if($success == 1){
            echo '执行成功';
        }
        if($success == 2){
            echo '执行失败';
        }
        if($success == 3){
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
        $success = 1){
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

        if($success == 1){
            echo '执行成功';
        }
        if($success == 2){
            echo '执行失败';
        }
        if($success == 3){
            echo '重复执行';
        }

        echo PHP_EOL;
    }
} 