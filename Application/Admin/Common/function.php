<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 11:40
 */


//递归方法实现无限级分类
function getTree($list, $pid=0, $level=0){
    static $tree = [];
    foreach($list as $val){
        if($val['pid'] == $pid){
            $val['level'] = $level;
            $tree[] = $val;
            getTree($list, $val['id'], $level+1);
        }
    }
    return $tree;
}




