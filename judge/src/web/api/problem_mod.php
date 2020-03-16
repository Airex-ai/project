<?php
session_start();
$ON_ADMIN_PAGE = "Yap";
require_once("../include/setting_oj.inc.php");
require_once("../include/file_functions.php");
require_once("../include/user_check_functions.php");

$pid = intval($_POST['problem_id']);
$problem_title = $_POST['problem_title'];
$time_limit = $_POST['time_limit'];
$memory_limit = $_POST['memory_limit'];
$problem_desc = $_POST['problem_desc'];
$problem_input = $_POST['problem_input'];
$problem_output = $_POST['problem_output'];
$samp_in_data = $_POST['samp_in_data'];
$samp_out_data = $_POST['samp_out_data'];
$problem_hint = $_POST['problem_hint'];
$problem_spj = $_POST['problem_spj'];
$problem_source = $_POST['problem_source'];
$problem_scj = $_POST['problem_scj'];
$problem_scjh = $_POST['problem_scjh'];
$problem_scjf = $_POST['problem_scjf'];

$isAddProblem = ($pid == 0) ? true : false;

//Privilege Check
if (!isProblemOperator($pid) && (!$isAddProblem || !isOperator())) {
    exit("403");
}

if ($isAddProblem) {
    $sql = $pdo->prepare("INSERT into `problem`
						(`title`,`time_limit`,`memory_limit`,`description`,`input`,`output`,`sample_input`,`sample_output`,`hint`,`source`,`spj`,`in_date`,`defunct`)
						VALUES(?,?,?,?,?,?,?,?,?,?,?,NOW(),'Y')");
    $sql->execute(array($problem_title, $time_limit, $memory_limit, $problem_desc, $problem_input, $problem_output, $samp_in_data, $samp_out_data, $problem_hint, $problem_source, $problem_spj));
    $pid = $pdo->lastinsertid();

    $sql = $pdo->prepare("insert into `privilege` (`user_id`,`rightstr`) values(?,?)");
    $sql->execute(array($_SESSION['user_id'],"p$pid"));
    $_SESSION['p' . $pid] = true;

    if($problem_scj){
        $sql = $pdo->prepare("INSERT into `splice_code`
						(`problem_id`,`scj`,`scjh`,`scjf`)
						VALUES(?,?,?,?)");
        $sql->execute(array($pid,$problem_scj, $problem_scjh, $problem_scjf));
    }

    echo "Now Added Problem {$pid}<br/>";
} else {
    $sql = $pdo->prepare("UPDATE `problem` 
						SET `title`=?,`time_limit`=?,`memory_limit`=?,
						`description`=?,`input`=?,`output`=?,
						`sample_input`=?,`sample_output`=?,`hint`=?,
						`source`=?,`spj`=?,`in_date`=NOW()
						WHERE `problem_id`=?");
    $sql->execute(array($problem_title, $time_limit, $memory_limit, $problem_desc, $problem_input, $problem_output, $samp_in_data, $samp_out_data, $problem_hint, $problem_source, $problem_spj, $pid));

    $sql=$pdo->prepare("SELECT * FROM splice_code WHERE problem_id = ?");
    $sql->execute(array($pid));
    $problemsplice=$sql->fetch(PDO::FETCH_ASSOC);

    if(!$problemsplice) {
        if($problem_scj) {
            $sql = $pdo->prepare("INSERT into `splice_code`
						(`problem_id`,`scj`,`scjh`,`scjf`)
						VALUES(?,?,?,?)");
            $sql->execute(array($pid, $problem_scj, $problem_scjh, $problem_scjf));
        }
        }else{
            $sql = $pdo->prepare("UPDATE `splice_code` 
						SET `scj`=?,`scjh`=?,`scjf`=?
						WHERE `problem_id`=?");
            $sql->execute(array($problem_scj,$problem_scjh,$problem_scjf, $pid));
        }
    echo "Now Modifing Problem " . $pid . "<br/>";
}




$basedir = "$OJ_PROBLEM_DATA/$pid";

if ($isAddProblem) {
    mkdir($basedir);
    echo "Now Adding data at " . $basedir . "<br/>";
    if (strlen($samp_out_data) && !strlen($samp_in_data)) $samp_in_data = "0";
    if (strlen($samp_in_data)) mkdata($pid, "sample.in", $samp_in_data, $OJ_PROBLEM_DATA);
    if (strlen($samp_out_data)) mkdata($pid, "sample.out", $samp_out_data, $OJ_PROBLEM_DATA);
    echo "[$problem_title] data in $basedir <br/>";
    echo "<a href='../admin/problem_data.php?pid={$pid}'>添加测试数据</a><br/>";
} else {
    if ($samp_in_data) {
        echo "Now Updating data at: " . $basedir . "<br/>";
        $fp = fopen($basedir . "/sample.in", "w");
        fputs($fp, preg_replace("(\r\n)", "\n", $samp_in_data));
        fclose($fp);
        $fp = fopen($basedir . "/sample.out", "w");
        fputs($fp, preg_replace("(\r\n)", "\n", $samp_out_data));
        fclose($fp);
    }
    echo "[$problem_title] data in $basedir <br/>";
}
?>
