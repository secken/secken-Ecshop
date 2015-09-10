<?php

/**
 * ECSHOP 插件入口文件
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/* 载入语言文件 */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');


$act = isset($_GET['act']) ? trim($_GET['act']) : '';
if($act != '' && strpos($act, '_') >=0){

    assign_template();

    $smarty->assign('action', $act);
    $smarty->assign('lang',$_LANG);

    list($plugin_name, $ac) = explode('_', $act);

    //配置插件目录
    $smarty->template_dir   = ROOT_PATH . 'plugins/'. $plugin_name;

    $plugin_file = sprintf(ROOT_PATH."plugins/%s/%s.php", $plugin_name, $ac);

    if(is_file($plugin_file)){
        require_once $plugin_file;
    }
}
