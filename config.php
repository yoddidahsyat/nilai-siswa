<?php 

define('BASEURL', 'http://192.168.100.7/educate');

// DB
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'educate');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

?>