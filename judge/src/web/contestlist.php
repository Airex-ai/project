<?php
session_start();
//Vars
require_once('./include/setting_oj.inc.php');
require_once('./include/memcache.php');
require_once('./include/contest_functions.inc.php');

//Prepare
$p = isset($_GET['p']) ? $_GET['p'] : 1;
if ($p < 1) {
    $p = 1;
}
$front = intval(($p - 1) * $PAGE_ITEMS);
$privateFliter = isset($_GET['private']) ? intval($_GET['private']) : 3; // Default(2):All 0:Public 1: Private&Password
switch ($privateFliter) {
    case 0:// Public
        $privateFliterSQL = " AND contest.`private`=0 ";
        break;
    case 1:// Private&Password
        $privateFliterSQL = " AND contest.`private`=1 ";
        break;
    case 2:// Register
        $privateFliterSQL = " AND contest.`private`=2 ";
        break;
    default:// All
        $privateFliterSQL = "";
        break;
}

if($OJ_MEMCACHE){
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $sql = "select * from privilege where rightstr like 'c%' and user_id  = {$user_id}";
        $result = mysql_query_cache($sql.false,60);
        $priList = array();
        foreach ($result as &$row) {
            array_push($priList, substr($row['rightstr'], 1));
        }
    }

    $sql = "select * from contest left join (
                                select * from privilege where rightstr like 'm%'
                            ) p on concat('m',contest_id)=rightstr
                            where contest.`defunct`='N' {$privateFliterSQL} order by contest_id desc limit $front,$PAGE_ITEMS ";

    $contestList = mysql_query_cache($sql,false,60);
    $contestCount = count($contestList);

    $sql = "select count(*) as count from contest where `defunct`='N' {$privateFliterSQL}";
    $result=mysql_query_cache($sql);
    $totalCount = $result[0];
}
else{
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $sql = $pdo->prepare("select * from privilege where rightstr like 'c%' and user_id  = ?");
        $sql->execute(array($user_id));
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        $priList = array();
        foreach ($result as &$row) {
            array_push($priList, substr($row['rightstr'], 1));
        }
    }

    $sql = $pdo->prepare("select * from contest left join (
                                select * from privilege where rightstr like 'm%'
                            ) p on concat('m',contest_id)=rightstr
                            where contest.`defunct`='N' {$privateFliterSQL} order by contest_id desc limit $front,$PAGE_ITEMS ");
    $sql->execute();
    $contestList = $sql->fetchAll(PDO::FETCH_ASSOC);
    $contestCount = count($contestList);
    //var_dump($contestList);

    $sql = $pdo->prepare("select count(*) as count from contest where `defunct`='N' {$privateFliterSQL}");
    $sql->execute();
    $totalCount = $sql->fetch(PDO::FETCH_ASSOC);
}
$totalCount = intval($totalCount['count']);
$pageCnt = ceil((double)$totalCount / $PAGE_ITEMS);

foreach ($contestList as &$row) {
    $start_time = strtotime($row["start_time"]);
    $end_time = strtotime($row["end_time"]);
    $now = time();
    $length = $end_time - $start_time;
    $left = $end_time - $now;
    // past
    if ($now > $end_time) {
        $row['content_status'] = "<span class='label label-success'>" . L_Ended . "</span>&nbsp;<span class='label label-success'>" . $row["end_time"] . "</span>";
        // pending
    } else if ($now < $start_time) {
        $row['content_status'] = "<span class='label label-primary'>" . L_Start . "</span>&nbsp;<span class='label label-info'>" . $row["start_time"] . "</span>&nbsp;";
        $row['content_status'] .= "<span class='label label-success'>" . L_TOTAL . formatTimeLength($length) . "</span>";
        // running
    } else {
        $row['content_status'] = "<span class='label label-danger'>" . L_Running . "</span>&nbsp;";
        $row['content_status'] .= "<span class='label label-success'>" . L_LeftTime . ":" . formatTimeLength($left) . " </span>";
    }
    $private = intval($row["private"]);
    if ($private == 0)
        $row['private'] = "<span class='label label-primary'>" . L_Public . "</span>";
    else if ($private == 1)
        $row['private'] = "<span class='label label-danger'>" . L_Private . "</span>";
    else {
        if (isset($_SESSION['user_id']) && in_array($row['contest_id'], $priList)) {
            $row['private'] = "<span class='label label-info'>" . L_Register . "</span>&nbsp;";
        } else {
            $row['private'] = "<span class='label label-info'> <a href='./api/contest_register.php?do=r&cid={$row['contest_id']}'>" . L_Register . "</a></span>&nbsp;";
        }
        $row['private'] .= "<span class='label label-info'> <a href='contest_user.php?cid={$row['contest_id']}'> " . "报名表" . "</a></span>";
    }
}

unset($row); // avoid last row overwritten.

//Page Includes
require("./pages/contestlist.php");
?>
