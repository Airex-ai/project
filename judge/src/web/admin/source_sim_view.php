<?php
session_start();
//Vars
require_once('../include/setting_oj.inc.php');
require_once('../include/common_const.inc.php');
require_once('../include/user_check_functions.php');
//Prepares

if (!isset($_GET['id'])) {
    echo "Null Source ID.";
    exit(0);
}
if (!havePrivilege("CONTEST_EDITOR")) {
    echo "403";
    exit(403);
}

//尚不准备关于代码权限访问相关的代码
//原代码id
$code_id = intval($_GET['id']);
$sql = $pdo->prepare("SELECT * FROM `solution` WHERE `solution_id`=?");
$sql->execute(array($code_id));
$codeInfo=$sql->fetch(PDO::FETCH_ASSOC);

$sql = $pdo->prepare("SELECT * FROM `source_code` WHERE `solution_id`=?");
$sql->execute(array($code_id));
$codeContent=$sql->fetch(PDO::FETCH_ASSOC);

$sql = $pdo->prepare("SELECT * FROM `sim` WHERE `s_id`=?");
$sql->execute(array($code_id));
$codeSim=$sql->fetch(PDO::FETCH_ASSOC);

//重复代码id
$code_id_sim = intval($codeSim['sim_s_id']); //获取重复代码id
$sql = $pdo->prepare("SELECT * FROM `solution` WHERE `solution_id`=?");
$sql->execute(array($code_id_sim));
$codeInfo_sim=$sql->fetch(PDO::FETCH_ASSOC);

$sql = $pdo->prepare("SELECT * FROM `source_code` WHERE `solution_id`=?");
$sql->execute(array($code_id_sim));
$codeContent_sim=$sql->fetch(PDO::FETCH_ASSOC);

//设置权限可见
$can_view = false;
if (havePrivilege("SOURCE_VIEWER")) $can_view=true;
if (isset($_SESSION['user_id'])&&$codeInfo['user_id']==$_SESSION['user_id']) $can_view=true;
//if (shared) $can_view = true;
if (!$can_view) {
    echo "No Permission to visit this code";
    exit(0);
}

//原代码id查询结果
$code_author = $codeInfo['user_id'];
$code_src = str_replace(array('<', '>'), array('&lt;', '&gt;'), $codeContent['source']);
$code_date = $codeInfo['in_date'];
$code_result = $JUDGE_RESULT[$codeInfo['result']];
$code_time = $codeInfo['time'];
$code_memory = $codeInfo['memory'];
$code_lang = $codeInfo['language'];

//重复代码id查询结果
$code_author_sim = $codeInfo_sim['user_id'];
$code_src_sim = str_replace(array('<', '>'), array('&lt;', '&gt;'), $codeContent_sim['source']);
$code_date_sim = $codeInfo_sim['in_date'];
$code_result_sim = $JUDGE_RESULT[$codeInfo_sim['result']];
$code_time_sim = $codeInfo_sim['time'];
$code_memory_sim = $codeInfo_sim['memory'];
$code_lang_sim = $codeInfo_sim['language'];
$code_sim_rate = $codeSim['sim'];

//if (shared from submit)
$code_title = "Problem ".$codeInfo['problem_id'];
$code_title_sim = "Problem ".$codeInfo_sim['problem_id'];

//Page Includes
require("./pages/source_sim_view.php");
?>
