<?php
// 保存15天
$lifeTime = 15 * 24 * 3600;
session_set_cookie_params($lifeTime);
session_start();
$ON_ADMIN_PAGE = "Yap";
require_once("../include/setting_oj.inc.php");
require_once("../include/login_functions.php");
require_once("../include/common_functions.inc.php");
require_once("../include/user_check_functions.php");
require_once("../include/gt3/lib/class.geetestlib.php");
require_once("../include/gt3/config/config.php");
$GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);


$data = array(
    "ip_address" => get_client_ip() # 请在此处传输用户请求验证时所携带的IP
);
//	$gkstatus = false;
//	if ($_SESSION['gtserver'] == 1) {   //服务器正常
//		$result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $data);
//		if ($result) {
//			$gkstatus = true;
//		}
//	}else{  //服务器宕机,走failback模式
//		if ($GtSdk->fail_validate($_POST['geetest_challenge'],$_POST['geetest_validate'],$_POST['geetest_seccode'])) {
//            $gkstatus = true;
//        }
//	}
//
//	if(!$gkstatus){
//		exit("Verify failed");
//	}

if (!isset($_SESSION['SessionAuth']) || !isset($_POST['pageauth'])) {
    exit("Auth failed");
}
if ($_SESSION['SessionAuth'] != $_POST['pageauth']) {
    exit("Auth failed");
}

$user_id = $_POST['username'];
$password = $_POST['password'];
if (get_magic_quotes_gpc()) {
    $user_id = stripslashes($user_id);
    $password = stripslashes($password);
}

$login = check_login($user_id, $password, $pdo, get_client_ip());

if ($login) {
    $_SESSION['user_id'] = $login;

    $sql = $pdo->prepare("SELECT * FROM `users` WHERE `user_id`=?");
    $sql->execute(array($login));
    $res = $sql->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user_name'] = $res['nick'];


    $sql = $pdo->prepare("SELECT * FROM `oauth` WHERE `user_id`=?");
    $sql->execute(array($login));
    $res = $sql->fetch(PDO::FETCH_ASSOC);
    if ($res) {
        $_SESSION['isqqbind'] = true;
    }
    //权限部分
    $sql = $pdo->prepare("SELECT `rightstr` FROM `privilege` WHERE `user_id`=? AND `defunct`='N'");
    $sql->execute(array($user_id));
    $op_result = $sql->fetchAll(PDO::FETCH_ASSOC);
    $sql->closeCursor();

    foreach ($op_result as $row) {
        $rightStr = $row['rightstr'];
        $_SESSION[$rightStr] = true;
    }
    $_SESSION['is_operator'] = isOperator();

    if ($OJ_LARGE_CONTEST_MODE == true && $OJ_LOGIN_FILTER != false) {
        if (!havePrivilege('SUPERUSER') && strpos($user_id, $OJ_LOGIN_FILTER) !== 0) {
            unset($_SESSION['user_id']);
            unset($_SESSION['is_operator']);
            session_destroy();
            exit("Large contest mode enabled, only appointed user can login.");
        }
    }
    echo "<script language='javascript'>\n";
    echo "history.go(-2);\n";
    echo "</script>";
} else {
    echo "<script language='javascript'>\n";
    echo "alert('用户名或密码错误!');\n";
    echo "history.go(-1);\n";
    echo "</script>";
}
?>
