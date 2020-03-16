<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2019/4/21
 * Time: 9:15
 */
	session_start();
	//Vars
	require_once('./include/setting_oj.inc.php');
require_once('./include/memcache.php');
require_once('./include/user_check_functions.php');
	//Prepares

	if(!(isset($_GET["tid"])&&isset($_GET["cid"]))) exit(0);


	//Prepares
	$cid = intval($_GET['cid']);

	$sql = $pdo->prepare("SELECT * FROM contest WHERE contest_id = ?");
	$sql->execute(array($cid));
	$contestItem = $sql->fetch(PDO::FETCH_ASSOC);


//Page Includes
	require("./pages/contest_viewtopic.php");
?>
