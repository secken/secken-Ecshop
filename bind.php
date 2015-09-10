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

//进行绑定请求
if (!empty($_POST['event_id'])) {
	//查询详细事件信息
	$info = $yangcong->getResult($_POST['event_id']);

	if (!empty($info['uid'])) {

		$sql = "select `uid` from %s where `uid` = %d AND `yangcong` = '%s'";
		$sql = sprintf($sql, $GLOBALS['ecs']->table('yangcong'), $user_id, $info['uid']);

		$var = $GLOBALS['db']->getRow($sql);

		//如果已经绑定，跳转到解绑页面
		if (!empty($var['uid'])) {
			die(json_encode(array('status'=>0,'message'=>'账号已经绑定','url'=>'plugin.php?act=yangcong_bind')));
		}

		//更新绑定纪录
		$table = $GLOBALS['ecs']->table('yangcong');

		if (!empty($var['uid'])) {

			$fields = array('yangcong'=> $info['uid']);

			$GLOBALS['db']->autoExecute($table, $fields, 'UPDATE', "uid=$user_id");
		} else {

			$fields = array('uid' => $user_id, 'yangcong' => $info['uid']);

			$GLOBALS['db']->autoExecute($table, $fields, 'INSERT');
		}

		die(json_encode(array('status'=>1,'message'=>'绑定成功','url'=>'plugin.php?act=yangcong_bind')));

	} else {
		die(json_encode(array('status'=>0,'message'=>$yangcong->getMessage())));
	}
}else{

	$sql = "select `yangcong` from %s where `uid` = %d";
	$sql = sprintf($sql, $GLOBALS['ecs']->table('yangcong'), $user_id);

	$smarty->assign('bind_info', $GLOBALS['db']->getRow($sql));

	//获取绑定二维码
    $auth = $yangcong->getBinding();

    if($yangcong->getCode() == 200){
        $assign = array();
        $assign = array(
            'qrcode_url' => $auth['qrcode_url'],
            'message' => $yangcong->getMessage(),
            'event_id' => $auth['event_id']
        );
        $smarty->assign('auth', $assign);
    }

    $smarty->display('template/bind.dwt');

}
