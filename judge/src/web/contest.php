<?php
session_start();
//Vars
require_once('./include/setting_oj.inc.php');
require_once('./include/memcache.php');
require_once('./include/user_check_functions.php');

//Prepares
$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
if ($cid == 0) {
    echo "No such contest";
    exit(0);
}

$sql = $pdo->prepare("SELECT * FROM contest WHERE contest_id = ?");
$sql->execute(array($cid));
$contestItem = $sql->fetch(PDO::FETCH_ASSOC);

$now = time();
$startTime = strtotime($contestItem['start_time']);
$endTime = strtotime($contestItem['end_time']);
$contestState = "";
$contestPrivate = $contestItem['private'] ? ($contestItem['private'] == 1 ? L_Private : L_Register) : L_Public;

if ($now > $endTime)
    $contestState = "<span class='text-muted'>" . L_Ended . "</span>";
else if ($now < $startTime)
    $contestState = "<span class='text-primary'>" . L_Not_Start . "</span>";
else {
    $contestState = "<span class='text-danger'>" . L_Running . "</span>";
}

if (isset($_POST['psw']) && ($contestItem['password'] != '')) {
    if ($_POST['psw'] == $contestItem['password']) {
        $_SESSION["c{$cid}"] = "true";
    }
}

//Page Includes
require("./pages/contest.php");
?>
