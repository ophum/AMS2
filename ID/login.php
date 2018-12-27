<?php
require_once('config.php');

session_start();

$message = "";

if(isset($_POST['id']) && isset($_POST['pass'])){
	$id = h($_POST['id']);
	$pass = h($_POST['pass']);
	$ret = post(DB."verify.php",
				array(
					'dbid' => DBID,
					'dbpass' => DBPASS,
					'id' => $id,
					'pass' => $pass
				)
			);

	if($ret){
		$_SESSION['id'] = $id;
		header("location:index.php");
		exit();
	}else {
		$message = "認証に失敗しました";
	}	
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>Login</title>
</head>
<body>
<h1>ログイン</h1>
<hr>
<p><?= $message; ?></p>
<form action="" method="POST">
<p><input type="text" name="id" placeholder="id"></p>
<p><input type="password" name="pass" placeholder="password"></p>
<p><input type="submit" value="ログイン"></p>
</form>
</body>
</html>
