<?php

function h($s){
	return htmlspecialchars(trim($s), ENT_QUOTES, "utf-8");
}

function post($addr, $data){

	$content = http_build_query($data);
	$headers = implode("\r\n", array('Content-Type: application/x-www-form-urlencoded',));
	$options = array(
		'http' => array(
			'method' => 'POST',
			'content' => $content,
			'header' => $headers
    ));
    
    $ret = json_decode(file_get_contents($addr, false, stream_context_create($options)), true);
    
    switch($ret['type']){
    case 'bool':
        if($ret['data'] == 'true') return true;
        else return false;
    case 'string':
        return $ret['data'];
    case 'number':
        return intval($ret['data']);
    }
}

function resizeImage($path, $maxwidth, $maxheight){
    list($width, $height, $type, $attr) = getimagesize($path);

    $newwidth = $maxwidth;
    $newheight = $maxheight;

    if($maxheight < $height && $maxwidth < $width){
        if($maxwidth < $maxheight){
            $newheight = $height * ($maxwidth / $width);
        }else if($maxheight < $maxwidth){
            $newwidth = $width * ($maxheight / $height);
        }else {
            if($width < $height){
                $newwidth = $width * ($maxheight / $height);
            }else {
                $newheight = $height * ($maxwidth / $width);
            }
        }
    }else if($height < $maxheight && $width > $maxwidth){
        $newwidth = $width;
        $newheight = $height;
    }else if($maxheight < $height && $width <= $maxwidth){
        $newwidth = $width * ($maxheight / $height);
    }else if($height <= $h && $maxwidth < $width){
        $newheight = $height * ($maxwidth / $width);
    }else if($height < $maxheight && $width < $maxwidth){
        $newwidth = $width * ($maxheight / $height);
    }else if($height < $maxheight && $width == $maxwidth){
        $newheight = $hight * ($maxwidth / $width);
    }else {
        $newwidth = $width;
        $newheight = $height;
    }

    $image = imagecreatefrompng($path);
    $canvas = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($canvas, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    imagejpeg($canvas, $path);
    imagedestroy($image);
    imagedestroy($canvas);
}

function setImageDetail($file){

    try{
        $pdo = new PDO(SQLITE_DB);
        $res = $pdo->prepare("insert into urls(host, file, cnt) values(:host, :file, :cnt);");
		
		$res->bindValue(":host", ADDR, PDO::PARAM_STR);
		$res->bindValue(":file", $file, PDO::PARAM_STR);
		$res->bindValue(":cnt", 0, PDO::PARAM_INT);
        $res->execute();
        
        $res = null;
        $pdo = null;
    }catch(PDOException $e){
        exit();
    }
}

function getImageFilename(){
    $host = ADDR;
    try{
        $pdo = new PDO(SQLITE_DB);
        $pdo->beginTransaction();
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
        $pdo->commit();
        $res = null;
        $pdo = null;
    }catch(PDOException $e){
        exit();
    }
    return $file;
}