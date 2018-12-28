<?php
require_once('config.php');
require_once('lib.php');

$ret = array(
    'data' => 'false',
    'type' => 'bool'
);

if(verify($_POST['dbid'], $_POST['dbpass'])){
    if(verify($_POST['id'], $_POST['pass'])){
        $ret['data'] = 'true';
    }
}

echo json_encode($ret);
