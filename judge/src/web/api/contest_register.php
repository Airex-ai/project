<?php
session_start();
require_once("../include/setting_oj.inc.php");
require_once("../include/common_const.inc.php");
require_once("../include/file_functions.php");
require_once("../include/common_functions.inc.php");
require_once("../include/user_check_functions.php");

if (!isset($_GET['cid']) || !isset($_GET['do'])) {
    exit('error');
}
if (!isset($_SESSION['user_id']) && !isset($_GET['uid'])) {
    header('location:../login.php');
}

$cid = $_GET['cid'];
$do = $_GET['do'];
$user_id = $do == 'r' ? $_SESSION['user_id'] : $_GET['uid'];

$sql = $pdo->prepare("SELECT * 
FROM  `contest` 
WHERE `contest_id`= ? AND `private`=2;
");
$sql->execute(array($cid));
$result = $sql->fetch(PDO::FETCH_ASSOC);
if (!$result) {
    exit('error');
}

if ($do == 'r') {
    $sql = $pdo->prepare("SELECT * FROM `privilege` WHERE `user_id`= ? AND `rightstr` = ?");
    $sql->execute(array($user_id, "c" . $cid));
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        $sql = $pdo->prepare("INSERT INTO privilege VALUES (?,?,?)");
        $sql->execute(array($user_id, "c" . $cid, 'P'));
        echo "<script language='javascript'>\n";
        echo "alert('报名成功！');\n";
        echo "history.go(-1);\n";
        echo "</script>";
    } else {
        echo "<script language='javascript'>\n";
        echo "alert('已经报名，请勿重复提交！');\n";
        echo "history.go(-1);\n";
        echo "</script>";
    }
} else {
    if (isOperator() || isset($_SESSION["c" . $cid]) && $_SESSION["c" . $cid]) {
        $sql = $pdo->prepare("DELETE FROM `privilege`  WHERE  `user_id` =  ? AND  `rightstr` = ?");
        $sql->execute(array($user_id, "c" . $cid));

        $sql = $pdo->prepare("INSERT INTO privilege VALUES (?,?,?)");
        $sql->execute(array($user_id, "c" . $cid, $do == 'a' ? 'N' : 'Y'));

        echo "<script language='javascript'>\n";
        echo "alert('修改成功！');\n";
        echo "history.go(-1);\n";
        echo "</script>";
    }
}