<?php
require_once('config.php');
require_once('lib.php');

session_start();


function isUser($id){
	$id = h($id);
	
	return post(DB."isUser.php",
				array(
					'dbid' => DBID,
					'dbpass' => DBPASS,
					'id' => $id
				)
			);
}

if(!isset($_SESSION['id']) && !isUser($_SESSION['id'])){
	header("location: login.php");
	exit();
}

$num = h($_POST['num']);

if(preg_match("/^[0-9]+$/", $num)){
	$data = array(
		'id' => DBID,
		'pass' => DBPASS
	);
	$content = http_build_query($data);
	$headers = implode("\r\n", array('Content-Type: application/x-www-form-urlencoded',));
	$options = array(
		'http' => array(
			'method' => 'POST',
			'content' => $content,
			'header' => $headers
	));
	
	for($i = 0; $i < $num; $i++){
		echo file_get_contents(IS_Server."getImage.php", false, stream_context_create($options));	
		echo "\n";
	}

}
