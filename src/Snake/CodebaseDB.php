<?php
/**
 * 红外代码数据库
 *
 * User: snake
 * Date: 14-6-13
 * Time: 下午5:27
 */

namespace Snake;


class CodebaseDB
{
    private $db;

    /**
     * 构造函数
     *
     * @param \medoo $db 数据库实例
     */
    function __construct(\medoo $db)
    {
        $this->db = $db;
    }

    /**
     * 插入红外代码到数据库
     *
     * @param $CodeDisplayName
     * @param $CodeController
     * @param $UserCode
     * @param $KeyCode
     * @param $CodeName
     * @param $CodeKey
     * @param $CodeKeyTrue
     * @param $CodeOrder
     * @param $CodeDefaultIcon
     * @param $CodeGroup
     * @param $CodeIsNeedIndex
     * @return array
     */
    public function insert(
        $CodeDisplayName,
        $CodeController,
        $UserCode,
        $KeyCode,
        $CodeName,
        $CodeKey,
        $CodeKeyTrue,
        $CodeOrder,
        $CodeDefaultIcon,
        $CodeGroup,
        $CodeIsNeedIndex)
    {
        $id = $this->db->insert('codebase', array(
            'CodeDisplayName' => $CodeDisplayName,
            'CodeController' => $CodeController,
            'UserCode' => $UserCode,
            'KeyCode' => $KeyCode,
            'CodeName' => $CodeName,
            'CodeKey' => $CodeKey,
            'CodeKeyTrue' => $CodeKeyTrue,
            'CodeOrder' => $CodeOrder,
            'CodeDefaultIcon' => $CodeDefaultIcon,
            'CodeGroup' => $CodeGroup,
            'CodeIsNeedIndex' => $CodeIsNeedIndex
        ));

        return $id;
    }

    /**
     * 更新相关代码
     *
     * @param $CodeDisplayName
     * @param $CodeController
     * @param $UserCode
     * @param $KeyCode
     * @param $CodeName
     * @param $CodeKey
     * @param $CodeKeyTrue
     * @param $CodeOrder
     * @param $CodeDefaultIcon
     * @param $CodeGroup
     * @param $CodeIsNeedIndex
     * @return int
     */
    public function update(
        $CodeDisplayName,
        $CodeController,
        $UserCode,
        $KeyCode,
        $CodeName,
        $CodeKey,
        $CodeKeyTrue,
        $CodeOrder,
        $CodeDefaultIcon,
        $CodeGroup,
        $CodeIsNeedIndex)
    {
        $affected = $this->db->update('codebase', array(
            'UserCode' => $UserCode,
            'KeyCode' => $KeyCode,
            'CodeName' => $CodeName,
            'CodeKey' => $CodeKey,
            'CodeKeyTrue' => $CodeKeyTrue,
            'CodeOrder' => $CodeOrder,
            'CodeDefaultIcon' => $CodeDefaultIcon,
            'CodeGroup' => $CodeGroup,
            'CodeIsNeedIndex' => $CodeIsNeedIndex
        ), array(
            'AND' => array(
                'CodeDisplayName' => $CodeDisplayName,
                'CodeController' => $CodeController
            )
        ));

        return $affected;
    }

    /**
     * 获得代码ID
     *
     * @param $CodeDisplayName
     * @param $CodeController
     * @return bool
     */
    public function getCodeID($CodeDisplayName, $CodeController)
    {
        $recoder = $this->db->select('codebase', '*', array(
            'AND' => array(
                'CodeDisplayName' => $CodeDisplayName,
                'CodeController' => $CodeController
            )
        ));

        if ($recoder && count($recoder) == 1) {
            return $recoder[0]['CodeID'];
        } else {
            return false;
        }
    }


    /**
     * 批量删除id
     *
     * @param array $codeIDs
     * @return bool
     */
    public function deleteByCodeIDs(array $codeIDs)
    {
        foreach ($codeIDs as $codeid) {
            $r = $this->db->delete('codebase', array(
                'CodeID' => $codeid
            ));
            if ($r == 0) {
                return false;
            }
        }
        return true;
    }

    /**
     * 通过中文按键名字和遥控器id
     * 判断按键是否插入过
     *
     * @param $CodeDisplayName
     * @param $CodeController
     * @return bool
     */
    public function isInsertedByCodeDisplayNameAndCodeController($CodeDisplayName, $CodeController)
    {
        $r = $this->db->select('codebase', '*', array(
            'AND' => array(
                'CodeDisplayName' => $CodeDisplayName,
                'CodeController' => $CodeController
            )
        ));

        if ($r && count($r) == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获得相关遥控器的所有按键列表
     *
     * @param $CodeController
     * @return array|bool
     */
    public function getOneControllerAllCodeids($CodeController)
    {
        $r = $this->db->select('codebase', 'CodeID', array(
            'CodeController' => $CodeController
        ));

        if ($r && count($r) > 0) {
            return $r;
        } else {
            return false;
        }
    }

    /**
     * 获得遥控器代码的数量
     *
     * @return int
     */
    public function getCodesNumber(){
        return $this->db->count('codebase','*');
    }

    /**
     * 根据ControllerID
     *
     * @param $ControllerID
     * @return array
     */
    public function getProtocolInfoFromControllerID($ControllerID)
    {
        $sql = "
            select c.CodeID,substring(c.CodeKey,1,length(c.CodeKey) - length(CodeKeyTrue)) as ProtocolContent, c.CodeController

            from codebase as c

            where c.CodeController = ?
            group by ProtocolContent
        ";

        $sql = str_replace("?",$ControllerID,$sql);

        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }
}