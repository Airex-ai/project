<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 18-9-10
 * Time: 上午3:00
 */

	session_start();
	$ON_ADMIN_PAGE="Yap";
	//Vars
	require_once('../include/setting_oj.inc.php');
	require_once("../include/user_check_functions.php");

	//Privilege Check
	if (!havePrivilege("SUPERUSER")) {
		echo "403";
		exit(403);
	}
	//Prepares
	$sql=$pdo->prepare("SELECT * FROM `team_user` ORDER by user_id");// limit $front,$PAGE_ITEMS
	$sql->execute();
	$users=$sql->fetchAll();
	//Page Includes
	require("./pages/users.php");
?>
