<?php
session_start();
$ON_ADMIN_PAGE="Yap";
require_once("../include/setting_oj.inc.php");
require_once("../include/login_functions.php");
require_once("../include/user_check_functions.php");

if(isset($_POST['password'])&&isset($_POST['repassword'])&&isset($_POST['email'])&&isset($_POST['token']))
{
    $newpwd = $_POST['password'];
    $renewpwd = $_POST['repassword'];
    $email = $_POST['email'];
    $token = $_POST['token'];
    if (get_magic_quotes_gpc ()) {
        $newpwd= stripslashes ($newpwd);
        $renewpwd= stripslashes ($renewpwd);
        $email= stripslashes ($email);
        $token= stripslashes ($token);
    }
}
else
{
    exit("What are you nongshane");
}

$sql = $pdo->prepare("SELECT user_id,nick,password,getpasstime FROM `users` WHERE email=?");
$sql->execute(array($email));
$row = $sql->fetch(PDO::FETCH_ASSOC);

$hasAuth = false;

if($row) {
    $mt = md5($row['user_id'] . $row['nick'] . $row['password']);
    if ($mt == $token) {
        if (time() - strtotime($row['getpasstime'] <= 24 * 60 * 60)) {
            $hasAuth = true;
        }
    }
}
if(!$hasAuth) exit('error');

if($newpwd == $renewpwd)
{
    $password=pwGen($newpwd);

    $sql=$pdo->prepare("UPDATE `users` SET `password`=? WHERE `email`=? ");
    $sql->execute(array($password,$email));
    $affected_rows = $sql->rowCount();
    if ($affected_rows == 1){
        echo 'success';
    }
}
else
{
    exit("error");
}

