<?php 
	session_start();
	//Vars
	require_once('./include/setting_oj.inc.php');
	require_once('./include/memcache.php');
	require_once('./include/common_const.inc.php');
	require_once('./include/user_check_functions.php');
	
	//Prepares
	$pid=isset($_GET['pid']) ? intval($_GET['pid']) : -1;
	$gpid=isset($_GET['gpid']) ? intval($_GET['gpid']) : -1;
	if ($gpid==-1 && $pid==-1) {
		exit("404 No such problem");
	}
	$cid=isset($_GET['cid']) ? intval($_GET['cid']) : 0;
	if ($cid==0) {
		exit("404 No such contest");
	}
$isProblemManager = havePrivilege("PROBLEM_EDITOR");

if($OJ_MEMCACHE){
	$sql="SELECT * FROM contest WHERE contest_id = {$cid}";
	$result = mysql_query_cache($sql);
	$contestItem=$result[0];

	$sql= "SELECT * FROM `problem` WHERE `defunct`='N' AND `problem_id`=(
			SELECT `problem_id` FROM `contest_problem` WHERE `contest_id`={$cid} AND `num`={$pid}
		)";
	$result=mysql_query_cache($sql);
	$problemItem=$result[0];
	}
else
{
$sql=$pdo->prepare("SELECT * FROM contest WHERE contest_id = ?");
	$sql->execute(array($cid));
	$contestItem=$sql->fetch(PDO::FETCH_ASSOC);
	$sql=$pdo->prepare(
		"SELECT * FROM `problem` WHERE `defunct`='N' AND `problem_id`=(
			SELECT `problem_id` FROM `contest_problem` WHERE `contest_id`=? AND `num`=?
		)"
	);
	$sql->execute(array($cid,$pid));
	$problemItem=$sql->fetch(PDO::FETCH_ASSOC);
}
	//Page Includes
	require("./pages/contest_problem.php");
?>
