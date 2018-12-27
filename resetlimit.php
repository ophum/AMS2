<?php
require_once("config.php");

try{
	$pdo = new PDO(DBHOST, DBUSER, DBPASS);
	$pdo->query("update ips set cnt=0");
	$pdo =null;
}catch(PDOException $e){
	exit();
}

echo "Success";
