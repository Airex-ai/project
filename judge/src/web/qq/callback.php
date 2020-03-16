<?php
require_once("./API/qqConnectAPI.php");
require_once('../include/setting_oj.inc.php');
require_once("../include/common_functions.inc.php");
require_once("../include/user_check_functions.php");

$qc = new QC();
$access_token = $qc->qq_callback();
$openid = $qc->get_openid();
$sql = $pdo->prepare("SELECT * FROM `oauth` WHERE openid='{$openid}'");
$sql->execute();
$result = $sql->fetch(PDO::FETCH_ASSOC);
if ($result) {
    $user_id = $result['user_id'];
    $_SESSION['user_id'] = $user_id;
    $sql = $pdo->prepare("SELECT * FROM `users` WHERE `user_id`=?");
    $sql->execute(array($user_id));
    $res = $sql->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user_name'] = $res['nick'];
    $_SESSION['isqqbind'] = true;

    //权限部分
    $sql = $pdo->prepare("SELECT `rightstr` FROM `privilege` WHERE `user_id`='{$user_id}' AND `defunct`='N'");
    $sql->execute();
    $op_result = $sql->fetchAll(PDO::FETCH_ASSOC);
    $sql->closeCursor();
    foreach ($op_result as $row) {
        $rightStr = $row['rightstr'];
        $_SESSION[$rightStr] = true;
    }
    $_SESSION['is_operator'] = isOperator();

    $sql=$pdo->prepare("INSERT INTO `loginlog` VALUES(?,?,?,NOW())");
    $sql->execute(array($user_id,'qq',get_client_ip()));

    if ($OJ_LARGE_CONTEST_MODE == true && $OJ_LOGIN_FILTER != false) {
        if (!havePrivilege('SUPERUSER') && strpos($user_id, $OJ_LOGIN_FILTER) !== 0) {
            unset($_SESSION['user_id']);
            unset($_SESSION['is_operator']);
            session_destroy();
            exit("Large contest mode enabled, only appointed user can login.");
        }
    }
} else if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = $pdo->prepare("SELECT * FROM `oauth` WHERE user_id='{$user_id}'");
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        echo "<script language='javascript'>\n";
        echo "alert('该账号已绑定QQ登录，请取消之后再绑定其他QQ！');\n";
        echo "</script>";
    } else {
        $sql = $pdo->prepare("INSERT INTO `oauth` (`user_id`,`openid`,`access_token`,`site`) VALUES(?,?,?,'QQ')");
        $res = $sql->execute(array($user_id, $openid, $access_token));
        $_SESSION['isqqbind'] = true;
        echo "<script language='javascript'>\n";
        echo "alert('QQ绑定成功！');\n";
        echo "</script>";
    }
} else {
    echo "<script language='javascript'>\n";
    echo "alert('QQ未绑定账号，请登陆后绑定！');\n";
    echo "</script>";
}
echo "<script language='javascript'>\n";
echo "history.go(-2);\n";
echo "</script>";
