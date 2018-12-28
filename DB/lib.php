<?php
require_once("config.php");

function h($s){
	return htmlspecialchars(trim($s), ENT_QUOTES, "utf-8");
}

function verify($id, $pass){
	$id = h($id);
	$pass = h($pass);
	$ret = false;
	try{
		$pdo = new PDO(DBHOST, DBUSER, DBPASS);
		$res = $pdo->prepare("select password from users where id=:id");
		$res->bindParam(":id", $id);
		$res->execute();
		$hash = $res->fetch(PDO::FETCH_ASSOC)['password'];
		if(password_verify($pass, $hash)){
			$ret = true;
		}

		
		$pdo = null;
	}catch(PDOException $e){
		echo 'error';
		exit();
	}
	return $ret;
}

function getCount($ip){
    $cnt = 0;
    try{
        $pdo = new PDO(DBHOST, DBUSER, DBPASS);
        $res = $pdo->prepare("select count(*) from ips where ip=:ip");
        $res->bindParam(":ip", $ip);
        $res->execute();
        $ex = $res->fetch(PDO::FETCH_NUM)[0];
        if($ex == 0){
            $res = $pdo->prepare("insert into ips (ip, cnt) values(:ip, :cnt)");
            $res->bindParam(":ip", $ip);
            $res->bindParam(":cnt", $cnt);
            $res->execute();
        }else {
            $res = $pdo->prepare("select cnt from ips where ip=:ip");
            $res->bindParam(":ip", $ip);
            $res->execute();
            $cnt = $res->fetch(PDO::FETCH_NUM)[0];
        }
        $res = null;
        $pdo = null;
    }catch(PDOException $e){
        exit();
    }
    return $cnt;
}