<?php
require_once("config.php");

function verify($id, $pass){
	$id = h($id);
	$pass = h($pass);
	return post(DB."verify.php",
		array(
			'dbid' => DBID,
			'dbpass' => DBPASS,
			'id' => $id,
			'pass' => $pass
		)
	);
}

if(verify($_POST['id'], $_POST['pass'])){
	$file = "";

	$file = post(DB."getImageFilename.php",
			array(
				'dbid' => DBID,
				'dbpass' => DBPASS,
				'host' => ADDR
			)
		);

	if($file != "" && $file != null){
		$file = SAVE_DIR.$file;
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$mime_type = $finfo->file($file);
		$img = base64_encode(file_get_contents($file));
		echo "data:$mime_type;base64,$img";
	}
}
