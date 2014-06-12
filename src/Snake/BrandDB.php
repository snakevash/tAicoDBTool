<?php
/**
 * 品牌数据类
 *
 * User: snake
 * Date: 14-6-12
 * Time: 上午11:35
 */

namespace Snake;


class BrandDB
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
     * 插入品牌到数据库
     *
     * @param string $BrandName
     * @param string $BrandShortName
     * @param string $DisplayNameCN
     * @param string $BrandLogo
     * @param int $Country
     * @param string $BrandWebSite
     * @return array
     */
    public function insert(
        $BrandName = '',
        $BrandShortName = '',
        $DisplayNameCN = '',
        $BrandLogo = '',
        $Country = 0,
        $BrandWebSite = '')
    {
        $id = $this->db->insert('brand', array(
            'BrandName' => $BrandName,
            'BrandShortName' => $BrandShortName,
            'DisplayNameCN' => $DisplayNameCN,
            'BrandLogo' => $BrandLogo,
            'Country' => $Country,
            'BrandWebSite' => $BrandWebSite
        ));

        return $id;
    }

    /**
     * 品牌是否已经存在数据库
     *
     * @param $DisplayNameCN
     * @return bool
     */
    public function isInserted($DisplayNameCN)
    {
        $r = $this->db->select('brand', '*', array('DisplayNameCN' => $DisplayNameCN));
        if (count($r) > 0) {
            return true;
        } else {
            return false;
        }
    }
} 