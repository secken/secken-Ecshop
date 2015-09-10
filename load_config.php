<?php

function load_conf(){

    $sql = 'SELECT * FROM %s';
    $sql = sprintf($sql, $GLOBALS['ecs']->table('yangcong_settings'));
    return $GLOBALS['db']->getRow($sql);
}

$GLOBALS['yangcong'] = load_conf();
