<?php
require_once('config.php');
require_once('lib.php');

function addCount($ip){
	$cnt = getCount($ip) + 1;
	try{
		$pdo = new PDO(DBHOST, DBUSER, DBPASS);
		$res = $pdo->prepare("update ips set cnt=:cnt where ip=:ip");
		$res->bindParam(":cnt", $cnt);
		$res->bindParam(":ip", $ip);
		$res->execute();
		$res = null;
		$pdo = null;
	}catch(PDOException $e){
		exit();
	}	
}

if(verify($_POST['dbid'], $_POST['dbpass'])){
    addCount($_POST['ip']);
}

$ret = array(
    'data' => '',
    'type' => 'none'
);
echo json_encode($ret);