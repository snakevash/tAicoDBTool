<?php

/**
 * 规则配置表
 *
 * User: snake
 * Date: 14/11/14
 * Time: 下午5:10
 */
class RuleConfig
{
    public static $rules = array(
        # 规则所针对的类型
        '电视'=>array(
            # 普通类型
            'normal'=>array(
                # 开始行数
                'startline'=>3,
                # 结束行数
                'endline'=>26,
                # 其他行数
                'other'=>27,
            ),
            # 特殊规则
            'spec'=>true
        ),
        '有线电视机顶盒'=>array(
            # 普通类型
            'normal'=>array(
                # 开始行数
                'startline'=>3,
                # 结束行数
                'endline'=>26,
                # 其他行数
                'other'=>27,
            ),
            # 特殊规则
            'spec'=>true
        ),
        '机顶盒'=>array(
            # 普通类型
            'normal'=>array(
                # 开始行数
                'startline'=>3,
                # 结束行数
                'endline'=>26,
                # 其他行数
                'other'=>27,
            ),
            # 特殊规则
            'spec'=>true
        ),
        'DVD'=>array(
            # 普通类型
            'normal'=>array(
                # 开始行数
                'startline'=>3,
                # 结束行数
                'endline'=>34,
                # 其他行数
                'other'=>35,
            ),
            # 特殊规则
            'spec'=>null
        ),
        '投影机'=>array(
            # 普通类型
            'normal'=>array(
                # 开始行数
                'startline'=>3,
                # 结束行数
                'endline'=>26,
                # 其他行数
                'other'=>27,
            ),
            # 特殊规则
            'spec'=>null
        ),
        '热水器'=>array(
            # 普通类型
            'normal'=>array(
                # 开始行数
                'startline'=>3,
                # 结束行数
                'endline'=>7,
                # 其他行数
                'other'=>8,
            ),
            # 特殊规则
            'spec'=>null
        ),
        '功放'=>array(
            # 普通类型
            'normal'=>array(
                # 开始行数
                'startline'=>3,
                # 结束行数
                'endline'=>38,
                # 其他行数
                'other'=>39,
            ),
            # 特殊规则
            'spec'=>null
        ),
        '风扇等'=>array(
            # 普通类型
            'normal'=>array(
                # 开始行数
                'startline'=>3,
                # 结束行数
                'endline'=>5,
                # 其他行数
                'other'=>6,
            ),
            # 特殊规则
            'spec'=>null
        ),
        '按键对照表'=>array(
            # 普通类型
            'normal'=>array(
                # 开始行数
                'startline'=>2,
                # 结束行数
                'endline'=>1815,
                # 其他行数
                'other'=>null,
            ),
            # 特殊规则
            'spec'=>null
        ),
    );
}