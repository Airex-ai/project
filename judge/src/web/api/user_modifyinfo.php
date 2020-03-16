<?php
session_start();

$ON_ADMIN_PAGE = "Yap";
require_once("../include/setting_oj.inc.php");
require_once("../include/common_functions.inc.php");
require_once('../include/safe_func.inc.php');
require_once("../include/login_functions.php");

if (!isset($_SESSION['SessionAuth']) || !isset($_POST['pageauth'])) {
    fire(403, "Direct access is forbidden");
}

if ($_SESSION['SessionAuth'] != $_POST['pageauth']) {
    fire(401, "Session not valid");
}

if ($OJ_LARGE_CONTEST_MODE == true) {
    fire(403, "Not able to modify information while large contest mode is enabled.");
}

$user_id = $_SESSION['user_id'];
$user_name = htmlentities(RemoveXSS($_POST['user_nick']));
$user_motto = strip_tags(RemoveXSS($_POST['user_motto']), "<font> <a> <b>");
$password = RemoveXSS($_POST['ori_pwd']);
$user_rname = RemoveXSS($_POST['user_rname']);
$user_major = RemoveXSS($_POST['user_major']);
$user_school = RemoveXSS($_POST['user_school']);
$user_email = RemoveXSS($_POST['user_email']);
$new_password = RemoveXSS($_POST['new_pwd']);
$new_password_ii = RemoveXSS($_POST['new_pwd_ii']);


if (get_magic_quotes_gpc()) {
    $user_id = stripslashes($user_id);
    $password = stripslashes($password);
}

$sql = $pdo->prepare("SELECT `user_id`,`password` FROM `users` WHERE `user_id`=?");
$sql->execute(array($user_id));
$result = $sql->fetch(PDO::FETCH_ASSOC);
if ($result && pwCheck($password, $result['password'])) $pwdCheck_ok = true;
else $pwdCheck_ok = false;
$sql->closeCursor();

if ($pwdCheck_ok) {
    if ($new_password != NULL) {
        if ($new_password != $new_password_ii) {
            fire(401, "New password not match.");
        }
        $password = pwGen($new_password);
    } else {
        $password = pwGen($password);
    }

    $sql = $pdo->prepare("UPDATE `users` 
			SET `password`=?, `nick`=?,`motto`=?, `school`=?, `email`=? ,`rname`=?,`major`=?
			WHERE `user_id`=?");
    $sql->execute(array($password, $user_name, $user_motto, $user_school, $user_email, $user_rname, $user_major, $user_id));

    $_SESSION['user_name'] = $user_name;

    fire(200, L_USERINFO_UPDATED);
} else {
    fire(401, L_INCORRECT_PSW);
}

?>
