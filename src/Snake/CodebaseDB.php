<?php
/**
 * 红外代码数据库
 *
 * User: snake
 * Date: 14-6-13
 * Time: 下午5:27
 */

namespace Snake\Services;


class CodebaseDB {
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
        $CodeName,
        $CodeKey,
        $CodeKeyTrue,
        $CodeOrder,
        $CodeDefaultIcon,
        $CodeGroup,
        $CodeIsNeedIndex){
        $id = $this->db->insert('codebase',array(
            'CodeDisplayName'=>$CodeDisplayName,
            'CodeController'=>$CodeController,
            'CodeName'=>$CodeName,
            'CodeKey'=>$CodeKey,
            'CodeKeyTrue'=>$CodeKeyTrue,
            'CodeOrder'=>$CodeOrder,
            'CodeDefaultIcon'=>$CodeDefaultIcon,
            'CodeGroup'=>$CodeGroup,
            'CodeIsNeedIndex'=>$CodeIsNeedIndex
        ));

        return $id;
    }

    

} 