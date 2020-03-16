<?php
// DB Connection
    define('DB_HOST',$SQL_DB_HOST);
    define('DB_PORT',$SQL_DB_PORT);
    define('DB_USER',$SQL_DB_USER);
    define('DB_PASS',$SQL_DB_PASS);
    define('DB_NAME',$SQL_DB_NAME);
	$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->query("set names utf8;");
?>