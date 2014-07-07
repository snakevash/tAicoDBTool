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


    public function deleteByCodeIDs(array $codeIDs)
    {
        foreach ($codeIDs as $codeid) {

        }
    }
}