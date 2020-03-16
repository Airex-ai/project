<?php 
	session_start(); $ON_ADMIN_PAGE="Yap";
	//Vars
	require_once('../include/setting_oj.inc.php');
	require_once("../include/user_check_functions.php");

	//Privilege Check

    if (!isset($_GET['nid'])) {
        exit("no nid founded");
    }
	if (!isProblemOperator($_GET['nid'])) {
		exit("403");
	}
	
	//Prepares

	$PROB_ID = intval($_GET['nid']);
	
	$sql=$pdo->prepare("SELECT * FROM problem WHERE problem_id = ?");
	$sql->execute(array($PROB_ID));
	$problemItem=$sql->fetch(PDO::FETCH_ASSOC);
	//var_dump($problemItem);
    $sql=$pdo->prepare("SELECT * FROM splice_code WHERE problem_id = ?");
    $sql->execute(array($PROB_ID));
    $problemsplice=$sql->fetch(PDO::FETCH_ASSOC);

	$page_helper = "Now you are editing problem {$PROB_ID}";
	$PROB_TITLE = $problemItem['title'];
	$PROB_TIME = $problemItem['time_limit'];
	$PROB_MEMORY = $problemItem['memory_limit'];
	$PROB_DESC = htmlspecialchars_decode($problemItem['description']);
	$PROB_INPUT = htmlspecialchars_decode($problemItem['input']);
	$PROB_OUTPUT = htmlspecialchars_decode($problemItem['output']);
	$PROB_SAMP_IN = $problemItem['sample_input'];
	$PROB_SAMP_OUT = $problemItem['sample_output'];
	$PROB_HINT = htmlspecialchars_decode($problemItem['hint']);
	$PROB_SOURCE = htmlspecialchars_decode($problemItem['source']);
	$PROB_SPJ = intval($problemItem['spj']);
    $PROB_SCJ = 0;
    $PROB_SCJH = '';
    $PROB_SCJF = '';
	if($problemsplice){
        $PROB_SCJ = intval($problemsplice['scj']);
        $PROB_SCJH = htmlspecialchars_decode($problemsplice['scjh']);
        $PROB_SCJF = htmlspecialchars_decode($problemsplice['scjf']);
    }

	//Page Includes
	require("./pages/problem_mod.php");
?>

