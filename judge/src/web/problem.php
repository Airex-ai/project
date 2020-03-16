<?php
session_start();
//Vars
require_once('./include/setting_oj.inc.php');
require_once('./include/user_check_functions.php');

//Prepares
$pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
$curTime = strftime("%Y-%m-%d %H:%M", time());
$isProblemManager = isProblemOperator($pid);

if ($pid == 0) {
    exit("404 No such problem");
}

$any_running_contest = "
		SELECT `problem_id` FROM `contest_problem` WHERE `contest_id` IN (
			SELECT `contest_id` FROM `contest` WHERE 
			(`end_time`>'{$curTime}') AND `defunct`='N'
		)";

if (!isProblemOperator($pid)) {
    $sql = $pdo->prepare("SELECT * FROM problem WHERE `defunct`='N' AND problem_id = ? AND `problem_id` NOT IN({$any_running_contest})");
} else {
    $sql = $pdo->prepare("SELECT * FROM problem WHERE problem_id = ?");// limit $front,$PAGE_ITEMS
}

$sql->execute(array($pid));
$problemItem = $sql->fetch(PDO::FETCH_ASSOC);

$sql=$pdo->prepare("SELECT * FROM splice_code WHERE problem_id = ?");
$sql->execute(array($pid));
$problemsplice=$sql->fetch(PDO::FETCH_ASSOC);

$PROB_SCJ = 0;
$PROB_SCJH = '';
$PROB_SCJF = '';
if($problemsplice){
    $PROB_SCJ = $problemsplice['scj'];
    $PROB_SCJH = $problemsplice['scjh'];
    $PROB_SCJF = $problemsplice['scjf'];
}

if ($problemItem == false) exit("403 No such problem.");

//Page Includes
require("./pages/problem.php");
?>