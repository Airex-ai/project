<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2019/4/21
 * Time: 9:14
 */

session_start();
//Vars & Functions
require_once('./include/setting_oj.inc.php');
require_once('./include/memcache.php');
require_once('./include/common_const.inc.php');
require_once('./include/contest_functions.inc.php');
require_once('./include/user_check_functions.php');
require_once("./include/common_functions.inc.php");


//Prepares
$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
if ($cid == 0) {
    echo "No such contest";
    exit(0);
}

$sql = $pdo->prepare("SELECT * FROM contest WHERE contest_id = ?");
$sql->execute(array($cid));
$contestItem = $sql->fetch(PDO::FETCH_ASSOC);

if ($contestItem) {
    $start_time=strtotime($contestItem['start_time']);
    $end_time=strtotime($contestItem['end_time']);
    $contest_title=$contestItem['title'];
} else {
    echo "Content Not Exist";
    exit(0);
}

if (!$OJ_LOCKRANK) $OJ_LOCKRANK_PERCENT = 0 ;
$lock_time=$end_time-($end_time-$start_time)*$OJ_LOCKRANK_PERCENT;

//获取比赛topic
$cidCondition = $cid ? "AND (`cid` = '{$cid}')" : "AND ISNULL(`cid`)";
$sqlStmt = "SELECT `tid`, `title`, `top_level`, `topic`.`status`, `cid`, `pid`, MIN(`reply`.`time`) `posttime`, MAX(`reply`.`time`) `lastupdate`, `topic`.`author_id`, COUNT(`rid`) `count` 
				FROM `topic`, `reply` 
				WHERE `topic`.`status`!=2 AND `reply`.`status`!=2 AND `tid` = `topic_id` {$cidCondition}
				GROUP BY `topic_id` ORDER BY `top_level`  DESC, MAX(`reply`.`time`) DESC";
$sql=$pdo->prepare($sqlStmt);
$sql->execute();
$result=$sql->fetchAll(PDO::FETCH_ASSOC);
$topic = $result;


//获取比赛题目的数量
$sql=$pdo->prepare("SELECT count(1) AS probCnt FROM `contest_problem` WHERE `contest_id`=?");
$sql->execute(array($cid));
$problemItem=$sql->fetch(PDO::FETCH_ASSOC);
$problemCount=$problemItem['probCnt'];


//Page Includes
require("./pages/contest_listtopic.php");
?>
