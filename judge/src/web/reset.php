<?php
session_start();
//Vars
require_once("./include/setting_oj.inc.php");
require_once('./include/common_const.inc.php');
require_once('./include/user_check_functions.php');
//Prepares

if(isset($_GET['token'])&&isset($_GET['email']))
{
    $token = stripslashes(trim($_GET['token']));
    $email = stripslashes(trim($_GET['email']));
}
else{
    exit("illegal");
}

$sql = $pdo->prepare("SELECT user_id,nick,password,getpasstime FROM `users` WHERE email=?");
$sql->execute(array($email));
$row = $sql->fetch(PDO::FETCH_ASSOC);

$hasAuth = false;
if($row){
	$mt = md5($row['user_id'].$row['nick'].$row['password']);
	if($mt==$token){
		if(time()-strtotime($row['getpasstime'])>24*60*60){
			$msg = '该链接已过期！';
		}else{
			$hasAuth = true;
		}
	}else{
		$msg =  '无效的链接';
	}
}else{
	$msg =  '错误的链接！';
}

if(!$hasAuth) exit($msg);

//Page Includes
require("./pages/reset.php");
?>
