<?php
require_once('config.php');

function setImageDetail($host, $file){
    $host = h($host);
    $file = h($file);
    try{
		$pdo = new PDO(DBHOST, DBUSER, DBPASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false));
		$res = $pdo->prepare("insert into urls(host, file, cnt) values(:host, :file, :cnt);");
		
		$res->bindValue(":host", $host, PDO::PARAM_STR);
		$res->bindValue(":file", $file, PDO::PARAM_STR);
		$res->bindValue(":cnt", 0, PDO::PARAM_INT);
		$res->execute();
		$res = null;
		$pdo = null;
	}catch(PDOException $e){
		echo 'データベース接続エラー';
		exit();
	}
}

if(verify($_POST['dbid'], $_POST['dbpass'])){
    $host = h($_POST['host']);
    $file = h($_POST['file']);
    setImageDetail($host, $file);
}

$ret = array(
    'data' => '',
    'type' => 'none'
);
echo json_encode($ret);