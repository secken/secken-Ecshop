<?php

$table = $GLOBALS['ecs']->table('yangcong');

$sql ="
CREATE TABLE IF NOT EXISTS $table(
	`uid` int(11) NOT NULL,
	`yangcong` varchar(50) DEFAULT NULL,
	`pass` varchar(32) DEFAULT NULL,
	INDEX  (`yangcong`) comment ''
) ENGINE=`MyISAM` COMMENT='洋葱授权'
";

$GLOBALS['db']->query($sql);


$table = $GLOBALS['ecs']->table('yangcong_settings');

$sql = "
CREATE TABLE IF NOT EXISTS $table(
	`app_id` varchar(50) NOT NULL COMMENT 'app_id',
	`app_key` varchar(50) NOT NULL COMMENT 'app_key',
	`auth_id` varchar(50) NOT NULL COMMENT 'auth_id'
) ENGINE=`MyISAM` COMMENT='洋葱授权配置'
";

$GLOBALS['db']->query($sql);

echo '洋葱数据表已经创建成功';
