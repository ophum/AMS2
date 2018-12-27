<?php
require_once('config.php');


function isUser($id){
	$ret = false;
	$id = h($id);
	try{
		$pdo = new PDO(DBHOST, DBUSER, DBPASS);
		$res = $pdo->prepare("select count(*) from users where id=:id");
		$res->bindParam(":id", $id);
		$res->execute();
		$num = $res->fetch(PDO::FETCH_NUM)[0];
		if($num == 1){
			$ret = true;
		}
		$res = null;
		$pdo = null;
	}catch(PDOException $e){
		exit();
	}
	return $ret;
}

$ret = array(
    'data' => 'false',
    'type' => 'bool'
);

if(verify($_POST['dbid'], $_POST['dbpass'])){
    if(isUser($_POST['id'])) $ret['data'] = 'true';
}

echo json_encode($ret);