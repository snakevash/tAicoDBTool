<?php
/**
 * 协议-代码 帮助类
 *
 * User: snake
 * Date: 14-9-5
 * Time: 下午4:02
 */

namespace Snake\Services;


class ProtocolHelp {

    /**
     * 拼装协议
     *
     * @param array $protocolUnit
     * @return string
     */
    public static function AssembledProtocol(array $protocolUnit = array()){
        $tmp = '';
        $tmp .= empty($protocolUnit['ControllerProtocolFlag']) ? '' : $protocolUnit['ControllerProtocolFlag'];
        $tmp .= empty($protocolUnit['RetransFrame']) ? '' : $protocolUnit['RetransFrame'];
        $tmp .= empty($protocolUnit['TVFormat']) ? '' : $protocolUnit['TVFormat'];
        $tmp .= empty($protocolUnit['CarrierCycle']) ? '' : $protocolUnit['CarrierCycle'];
        $tmp .= empty($protocolUnit['DataCycle']) ? '' : $protocolUnit['DataCycle'];
        $tmp .= empty($protocolUnit['DataBits']) ? '' : $protocolUnit['DataBits'];

        return $tmp;
    }


} 