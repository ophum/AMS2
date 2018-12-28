<?php

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