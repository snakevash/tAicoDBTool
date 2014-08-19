<?php
/**
 * 额外功能服务类
 *
 * User: snake
 * Date: 14-8-19
 * Time: 下午4:42
 */

namespace Snake\Services;


use Snake\BrandDB;
use Snake\CodebaseDB;
use Snake\ControllerDB;

class OptionsServices {
    public $db;

    public function __construct()
    {
        $this->db = new \medoo(\DBFileConfig::$dbinfo);
    }

    /**
     * 获得三个指标
     *
     * @return array
     */
    public function getThreeTags(){
        $codedb = new CodebaseDB($this->db);
        $controllerdb = new ControllerDB($this->db);
        $branddb = new BrandDB($this->db);

        return array(
            'codebasesNumber' => $codedb->getCodesNumber(),
            'controllersNumber' => $controllerdb->getControllersNumber(),
            'brandsNumber' => $branddb->getBrandsNumber()
        );
    }


}