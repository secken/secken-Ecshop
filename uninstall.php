<?php

$table = $GLOBALS['ecs']->table('yangcong');
$sql = "DROP TABLE $table";
$GLOBALS['ecs']->query($sql);

$table = $GLOBALS['ecs']->table('yangcong_settings');
$sql = "DROP TABLE $table";
$GLOBALS['ecs']->query($sql);

echo '洋葱数据表已经删除成功';
