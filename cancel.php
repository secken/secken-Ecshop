<?php
require(dirname(__FILE__) . '/secken.class.php');
require(dirname(__FILE__) . '/load_config.php');

$app_id = $GLOBALS['yangcong']['app_id'];
$app_key = $GLOBALS['yangcong']['app_key'];
$auth_id = $GLOBALS['yangcong']['auth_id'];

$yangcong = new secken($app_id, $app_key, $auth_id);

$user_id = $_SESSION['user_id'];

if(empty($user_id)){
	show_message('请先登录', 'user.php?act=login', 'user.php?act=login');
}

if (!empty($_POST['event_id'])) {

	$info = $yangcong->getResult($_POST['event_id']);
	if (!empty($info['uid'])) {
		$sql = "DELETE FROM %s WHERE uid=%d AND yangcong='%s'";
		$sql = sprintf($sql, $GLOBALS['ecs']->table('yangcong'), $user_id,$info['uid']);

		$GLOBALS['db']->query($sql);

		die(json_encode(array('status'=>1,'message'=>'绑定取消成功', 'url'=>'plugin.php?act=yangcong_bind')));

	} else {
		if ($yangcong->getCode() == 602) {
			die(json_encode(array('status'=>0,'message'=>'请求已推送到您的洋葱App,请打开确认')));
		} else {
			die(json_encode(array('status'=>0,'message'=>$yangcong->getMessage())));
		}
	}
}else{

	$sql = "select * from %s where `uid` = %d";
	$sql = sprintf($sql, $GLOBALS['ecs']->table('yangcong'), $user_id);

	$yangcong_info = $GLOBALS['db']->getRow($sql);
	$yangcong_uid = !empty($yangcong_info) ? $yangcong_info['yangcong'] : '';

	$smarty->assign('realtimeAuth', $yangcong->realtimeAuth($yangcong_uid));
	$smarty->display('template/cancel.dwt');
}
