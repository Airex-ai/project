<?php

define("OJ_INITED", "This const marks for we are included the setting_oj.inc.php file.");
$OJ_PATH = dirname(dirname(__FILE__));
if (!isset($ON_ADMIN_PAGE)) require_once("{$OJ_PATH}/include/waf.php");
require_once("{$OJ_PATH}/include/refresh.php");
require_once("{$OJ_PATH}/include/config.php");
require_once("{$OJ_PATH}/include/common_functions.inc.php");
require_once("{$OJ_PATH}/include/user_check_functions.php");
require_once("{$OJ_PATH}/include/setting_db.inc.php");
$language = isset($_COOKIE["language"])?$_COOKIE["language"]:'English';
require_once("{$OJ_PATH}/language/index.{$language}.inc.php");
require_once("{$OJ_PATH}/language/admin.inc.php");

//Web site upgrading
if ($OJ_UPGRADE && !isset($ON_ADMIN_PAGE)) {
    $url = "http://{$_SERVER ['HTTP_HOST']}/upgrade.php";
    header("location: {$url}");
    exit;
}

//contest mode
$JUDGE_CONTEST_ACCESS = Array("/contest_listtopic.php","/contest_viewtopic.php","/api/ajax_discuss.php","/login.php", "/api/user_login.php", "/contestlist.php", "/contest.php", "/contest_problemset.php", "/contest_status.php", "/contest_ranklist.php", "/contest_problem.php", "/problemsubmit.php","/api/problem_submit.php","/qq/login.php","/qq/callback.php");
if ($OJ_LARGE_CONTEST_MODE && !havePrivilege('SUPERUSER')) {
    if (!in_array($_SERVER['PHP_SELF'], $JUDGE_CONTEST_ACCESS)) {
        $url = "http://{$_SERVER ['HTTP_HOST']}/contestlist.php";
        header("location: {$url}");
        exit;
    }
}

if ($DEV_DISPLAY_ERRORS)
    ini_set("display_errors", "Off");

date_default_timezone_set("PRC");

?>