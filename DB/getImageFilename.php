<?php
require_once('config.php');
require_once('lib.php');

function getImageFilename($host){
    $file = "";
    $host = h($host);
    try{
		$pdo = new PDO(DBHOST, DBUSER, DBPASS);
		$res = $pdo->prepare("select * from urls where host=:host order by cnt limit 1");
		$res->bindValue(":host", $host);
		$res->execute();
			
		$row = $res->fetch(PDO::FETCH_ASSOC);
		$file = $row['file'];
		$num = $row['num'];

		$res = $pdo->prepare("select max(cnt) from urls where host=:host");
		$res->bindValue(":host", $host);
		$res->execute();

		$cnt = $res->fetch(PDO::FETCH_NUM)[0] + 1;

		$res = $pdo->prepare("update urls set cnt=:cnt where num=:num");
		$res->bindParam(":cnt", $cnt);
		$res->bindParam(":num", $num);
		$res->execute();
		$res = null;

		$pdo = null;
	}catch(PDOException $e){
		exit();
    }
    return $file;
}

$ret = array(
    'data' => '',
    'type' => 'string'
);

if(verify($_POST['dbid'], $_POST['dbpass'])){
    $ret['data'] = getImageFilename($_POST['host']);
}

echo json_encode($ret);