<?php

require(dirname(__FILE__) . '/secken.class.php');
require(dirname(__FILE__) . '/load_config.php');

$app_id = $GLOBALS['yangcong']['app_id'];
$app_key = $GLOBALS['yangcong']['app_key'];
$auth_id = $GLOBALS['yangcong']['auth_id'];

$yangcong = new secken($app_id, $app_key, $auth_id);

$user_id = $_SESSION['user_id'];

if($user_id){
    show_message('已经登录，正在跳转中...', 'user.php','user.php');
}

//登陆验证
if (!empty($_POST['event_id'])) {

    $info = $yangcong->getResult($_POST['event_id']);
	$code = $yangcong->getCode();

	if ($code == 200) {

		$sql = "select `uid` from  %s where `yangcong` =  '%s'";
        $sql = sprintf($sql, $GLOBALS['ecs']->table('yangcong'), $info['uid']);

		$var = $GLOBALS['db']->getRow($sql, array($info['uid']));

		if (!empty($var)) {

            $uid = $var['uid'];

            if ($uid) {

                //直接登录
                $sql = "select `user_name` from %s where `user_id`=%d";
                $sql = sprintf($sql, $GLOBALS['ecs']->table('users'), $uid);

                $user_info = $GLOBALS['db']->getRow($sql);

                $GLOBALS['user']->set_session($user_info['user_name']);
				$GLOBALS['user']->set_cookie($user_info['user_name']);

                update_user_info();
                recalculate_price();

                die(json_encode(array('status'=>1,'message'=>'登录成功','url'=>'user.php')));
            } else {
                die(json_encode(array('status'=>0,'message'=>'登录失败')));
			}
		} else {
            die(json_encode(array('status'=>0,'message'=>'您还未绑定洋葱','url'=>'user.php?act=register')));
		}

	} else {
        die(json_encode(array('status'=>0,'message'=>$yangcong->getMessage())));
	}
}else{

    //获取登录授权二维码
    $auth = $yangcong->getAuth();

    if($yangcong->getCode() == 200){
        $assign = array();
        $assign = array(
            'qrcode_url' => $auth['qrcode_url'],
            'message' => $yangcong->getMessage(),
            'event_id' => $auth['event_id']
        );
        $smarty->assign('auth', $assign);
    }

    $smarty->display('template/login.dwt');
}
