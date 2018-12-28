<?php
require_once('config.php');
require_once('lib.php');

$ret = array(
    'data' => 0,
    'type' => 'number'
);

if(verify($_POST['dbid'], $_POST['dbpass'])){
    $ret['data'] = getCount($_POST['ip']);
}

echo json_encode($ret);