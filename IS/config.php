<?php

// ImageSaveのアドレス
define('ADDR', 'http://IPAddress or host/IS/');	// ex. http://10.0.0.1/

// アクセス数制御　IUのLIMIT_ACCESSと揃える
define('LIMIT_ACCESS', 5);

// 画像を保存する場所
define('SAVE_DIR', 'images/');

// 画像情報を保存するsqliteのファイル
define('SQLITE_DB', 'sqlite:'. SAVE_DIR . 'images.db');

// 画像を保存したあとリダイレクトするページ
define('SAVED_REDIRECT', 'http://IPAddress or host/IU/index.php');

// DataBase サーバのIPアドレスをhttp://から記入
define('DB', 'http://IPAddress or host/DB/');

define('DBID', "");
define('DBPASS', "");
