<?php
session_start();

if(!isset($_SESSION['id'])){
	header("location:login.php");
	exit();
}

?>
<html>
<head>
	<meta charset="utf-8">
	<title>slide</title>
	<script src="jquery.js"></script>
	<script src="jquery.row-grid.min.js"></script>
</head>
<style>

*{
	margin: 0;
	padding: 0;
	overflow: hidden;
}

body{
	background-color: #ffedfa;
}
#content{
	width: 100vw;
	height: 100vh;
	margin: 0 auto 0 auto;
}
img{
	width: auto;
	height: auto;
	max-width: 100%;
	max-height: 100%;
}

.container{
	display: flex;
	justify-content: space-around;
	flex-wrap: wrap;
	background: #eee;
}

.container:before,
.container:after {
	content: "";
	display: table;
}

.item{
	width: 33vw;
	height: 33vh;
	margin-bottom: 10px;
	vertical-align: middle;
	text-align: center;
}

.first-item{
	clear: both;
}

.last-row, .last-row ~ .item{
	margin-bottom: 0;
}
</style>
<body>

<div id="content">
<div class="container">
<div class="item">
<img id="image0" src="" alt="1">
</div>
<div class="item">
<img id="image1" src="" alt="2">
</div>
<div class="item">
<img id="image2" src="" alt="3">
</div>
<div class="item">
<img id="image3" src="" alt="4">
</div>
<div class="item">
<img id="image4" src="" alt="5">
</div>
<div class="item">
<img id="image5" src="" alt="6">
</div>
<div class="item">
<img id="image6" src="" alt="7">
</div>
<div class="item">
<img id="image7" src="" alt="8">
</div>
<div class="item">
<img id="image8" src="" alt="9">
</div>

</div>
</div>
</body>
<script>

var cnt = 0;
var start = 0;
var end = 0;
setInterval(function(){ cnt++; }, 1000);
$(function(){
	$('.container').hide();

	function changeImage(){
		var arr = [];
		start = cnt;
		$.post("getImageDataList.php", {"num": 9}, function(ds){
			arr = ds.split("\n");
			$.when(
				$(".container").fadeOut(1500)
			).done(function(){
				for(var i = 0; i < 9; i++){
					$("#image" + i).attr("src", arr[i]);
				}
			}).done(function(){
				setTimeout(function(){$('.container').fadeIn(1500)}, 500);	
			}).done(function(){
				end = cnt;
				console.log("span: " + (end - start));
				var sleeptime = 3 - end - start;
				sleeptime = sleeptime > 0 ? sleeptime : 0;
				setTimeout(changeImage, sleeptime * 1000);
			});
		});
	
	}
	changeImage();
});
</script>
</html>
