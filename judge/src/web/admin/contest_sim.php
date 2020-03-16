<?php
session_start();
$ON_ADMIN_PAGE = "Yap";
//Vars
require_once('../include/setting_oj.inc.php');
require_once('../include/common_functions.inc.php');
require_once("../include/user_check_functions.php");
//Prepares

if (!havePrivilege("CONTEST_EDITOR")) {
    echo "403";
    exit(403);
}
if (!isset($_GET['cid'])) {
    exit("error");
}
$cid = $_GET['cid'];
$sim = isset($_GET['sim']) ? $_GET['sim'] : 0;
$sql = $pdo->prepare("select * from solution solution left join `sim` sim on solution.solution_id=sim.s_id where contest_id = ? and sim > ? order by `contest_id` desc");
$sql->execute(array($cid, $sim));
$statusResult = $sql->fetchAll(PDO::FETCH_ASSOC);

//var_dump($simList);

//Page Includes
require("./pages/contest_sim.php");
?>

