<?php
session_start();
$ON_ADMIN_PAGE = "Yap";
require_once("../include/setting_oj.inc.php");
require_once("../include/file_functions.php");
require_once("../include/user_check_functions.php");

//Admin Auth
if (!havePrivilege("SUPERUSER")) {
    echo "<a href='../login.php'>Please Login First!</a>";
    exit(1);
}

$op_user_id = $_GET['uid'];
$privilege = $_GET['privilege'];

// Delete a privilege
if ($_SESSION['SessionAuth'] != $_GET['getKey']) exit(403);

$canDelete = true;

$sql = $pdo->prepare("SELECT * FROM `privilege` WHERE `user_id`= ? AND `rightstr` = ?");
$sql->execute(array($op_user_id, 'administrator'));
$result = $sql->fetch(PDO::FETCH_ASSOC);

if ($result || havePrivilege('SUPERADMIN')) $canDelete = false;
if ($privilege != "administrator" || havePrivilege('SUPERADMIN')) $canDelete = true;

$sql = $pdo->prepare("SELECT * FROM `privilege` WHERE `user_id`= ? AND `rightstr` = ?");
$sql->execute(array($op_user_id, 'superadmin'));
$result = $sql->fetch(PDO::FETCH_ASSOC);
if ($result) $canDelete = false;

if ($canDelete) {
    $sql_str = "DELETE FROM `privilege` WHERE user_id='$op_user_id' and rightstr='$privilege'";
    $affectedRowCnt = $pdo->exec($sql_str);
    if ($affectedRowCnt > 0) echo "Delete " . $affectedRowCnt . " rows from Privilege database.<br/>";
} else {
    echo "failed";
}
?>
