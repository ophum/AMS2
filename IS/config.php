<?php

// ImageSaveのアドレス
define('ADDR', 'http://IPAddress or host/IS/');	// ex. http://10.0.0.1/

// アクセス数制御　IUのLIMIT_ACCESSと揃える
define('LIMIT_ACCESS', 5);

// 画像を保存する場所
define('SAVE_DIR', 'images/');

// 画像を保存したあとリダイレクトするページ
define('SAVED_REDIRECT', 'http://IPAddress or host/IU/index.php');

// DataBase サーバのIPアドレスをhttp://から記入
define('DB', 'http://IPAddress or host/DB/');

define('DBID', "");
define('DBPASS', "");

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