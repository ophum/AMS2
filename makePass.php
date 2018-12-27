<?php

$options = array(
	'salt' => random_bytes(22), 
	'cost' => 12
);

$pass = "";

echo password_hash($pass, PASSWORD_DEFAULT, $options);
