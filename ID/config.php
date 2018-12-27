<?php

// ImageSave　サーバのIPアドレスをhttp://から記入
// save.phpがある場所
define('IS_Server', 'http://IPAddress or host/IS/');

// DataBase サーバのIPアドレスをhttp://から記入
define('DB', 'http://IPAddress or host/DB/');

define('DBID', "");
define('DBPASS', "");

function h($s){
	return htmlspecialchars(trim($s), ENT_QUOTES, 'utf-8');
}

function post($addr, $data){

	$content = http_build_query($data);
	$headers = implode("\r\n", array('Content-Type: application/x-www-form-urlencoded',));
	$options = array(
		'http' => array(
			'method' => 'POST',
			'content' => $content,
			'header' => $headers
	));

    $ret = json_decode(file_get_contents($addr, false, stream_context_create($options)), true);
    
    switch($ret['type']){
    case 'bool':
        if($ret['data'] == 'true') return true;
        else return false;
    case 'string':
        return $ret['data'];
    case 'number':
        return intval($ret['data']);
    }
}