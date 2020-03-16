<?php 
	session_start(); 
	//Vars
	require_once('./include/setting_oj.inc.php');
	//Prepares
	if (isset($_SESSION['user_id'])) {
        header('location:index.php');
    }
	//Page Includes
	require("./pages/login.php");
?>
