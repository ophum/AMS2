<?php
require_once("config.php");
$ip = $_SERVER['REMOTE_ADDR'];

function getCount($ip){
	return post(DB.'getCount.php',
		array(
			'dbid' => 'admin',
			'dbpass' => '123qwEcc',
			'ip' => $ip
		)
	);
}

$cnt = getCount($ip);

if($cnt > LIMIT_ACCESS){
	header("location: limit.html");
	exit();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="css/css.css" type="text/css">
	<title>画像アップロード</title>
</head>
<body>

<div id="header"><?= HEADER ?></div>
<div class="container">
	<div id="content">
		<p>思い出の写真や本日の写真をスクリーンで紹介できるようなイベントです。</p>
		<p>写真は、以下のボタンを押して写真を選択し、編集後アップロードできます。</p>
		<p>写真は、あと<?= (LIMIT_ACCESS - $cnt) ?>回アップロードできます。</p>
	<div class="container"><canvas id="canvas"></canvas></div>
	<div class="container container-column">
	<form action="<?= IS_Server . 'save.php';?>" method="POST" enctype="multipart/form-data">
		<label id="filedesign" for="file">
		写真をアップロード
		<input type="file" style="display:none" name="file" id="file">
		</label>
		<input type="submit" id="upload-button" value="次へ">
		</form>
	</div>
	
	</div>
</div>
<div id="footer">copyright(c) humSoft</div>

<script>

var file = document.getElementById("file");
var uploadImgSrc;
var canvas = document.getElementById("canvas");
let canvasWidth = canvas.width;
let canvasHeight;


var ctx = canvas.getContext('2d');


function loadImage(e){

	var fileData = e.target.files[0];
	if(!fileData.type.match('image.*')){
		alert('指定の画像は対応していません');
		return;
	}

	document.getElementById("filedesign").style.display = "none";
	var reader = new FileReader();

	reader.onload = function(){
		uploadImgSrc = reader.result;
		canvasDraw();
	};
	reader.readAsDataURL(fileData);
	document.getElementById("upload-button").style.display = "block";
}

file.addEventListener('change', loadImage, false);
function canvasDraw(){
	var img = new Image();
	img.src = uploadImgSrc;
	img.onload = function(){
		canvas.height = this.height * (canvasWidth / this.width);
		ctx.drawImage(img, 0, 0, canvasWidth, this.height * (canvasWidth / this.width));
	};
}

</script>
</body>
</html>
