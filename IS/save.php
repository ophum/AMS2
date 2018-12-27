<?php
require_once("config.php");

function getCount($ip){
	return post(DB.'getCount.php',
		array(
			'dbid' => DBID,
			'dbpass' => DBPASS,
			'ip' => $ip
		)
	);
}

function addCount($ip){
	post(DB."addCount.php",
		array(
			'dbid' => DBID,
			'dbpass' => DBPASS,
			'ip' => $ip
		)
	);
}
$ip = $_SERVER['REMOTE_ADDR'];
$cnt = getCount($ip);

if($cnt > LIMIT_ACCESS){
	header("location: limit.html");
	exit();
}else {
	addCount($ip);
}

if(is_uploaded_file($_FILES['file']['tmp_name'])){
	if(!preg_match('/png$|gif$|jpg$|jpeg$/i', $_FILES['file']['name'])){
		echo 'errorhoge';
		exit();
	}

	$file = sha1(uniqid(time() . mt_rand(), true));
	$tmpname = $_FILES['file']['name'];
	$path = SAVE_DIR . $file;
	if(!move_uploaded_file($_FILES['file']['tmp_name'], $path)){
		echo 'move_uploaded_file error';
		exit();
	}

	if(!preg_match('/jpeg$|jpg$/i', $tmpname)){
		if(preg_match('/png$/i', $tmpname)){
			$image = @imagecreatefrompng($path);
		}else if(preg_match('/gif$/i', $tmpname)){
			$image = @imagecreatefromgif($path);
		}
		imagejpeg($image, $path);
		imagedestroy($image);
	}

	$image = @imagecreatefromjpeg($path);
	imagepng($image, $path);
	imagedestroy($image);

	// リサイズ
	resizeImage($path, 480, 320);

	// databaseに登録
	post(DB."setImageDetail.php",
		array(
			'dbid' => DBID,
			'dbpass' => DBPASS,
			'host' => ADDR,
			'file' => $file
		)
	);
}
header("location: ".SAVED_REDIRECT);
exit();
