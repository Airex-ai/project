<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 18-9-9
 * Time: 下午1:36
 */
session_start();
$ON_ADMIN_PAGE="Yap";
require_once("../include/setting_oj.inc.php");
require_once("../include/file_functions.php");
require_once("../include/user_check_functions.php");

//Privilege Check
if (!havePrivilege("SUPERUSER")) {
    echo "403";
    exit(403);
}

require_once "../include/checkauth_post.php";

if (isset($_POST['from'])) {
    $from = intval($_POST['from']);
    $to = intval($_POST['to']);

    $row = 0;
    $sql = $pdo->query("select 1 from problem where problem_id='$to'");
    $result = $sql->fetchAll();
    if ($result) {
        $row = count($result);
    }
    $result=rename("$OJ_PROBLEM_DATA/$from", "$OJ_PROBLEM_DATA/$to");

    if ($row == 0 && $result) {
        $sql=$pdo->query("UPDATE `problem` SET `problem_id`='$to' WHERE `problem_id`='$from'");
        if ($sql->fetchAll()==0) {
            rename("$OJ_PROBLEM_DATA/$to", "$OJ_PROBLEM_DATA/$from");
            exit(1);
        }
        $sql=$pdo->query("UPDATE `solution` SET `problem_id`='$to' WHERE `problem_id`='$from'");
        $sql->fetchAll();

        $sql=$pdo->query("UPDATE `contest_problem` SET `problem_id`='$to' WHERE `problem_id`='$from'");
        $sql->fetchAll();

        $sql= $pdo->query("UPDATE `topic` SET `pid`='$to' WHERE `pid`='$from'");
        $sql->fetchAll();

        $sql = $pdo->query("select max(problem_id) from problem");
        $result= $sql->fetchAll();
        if($result)
        {
            $nextid = $result[0][0] + 1;
            intval($nextid);
            $sql=$pdo->query("ALTER TABLE `problem` AUTO_INCREMENT = {$nextid}");
            $sql->fetchAll();
        }
        echo "<script language='javascript'>\n";
        echo "alert('变更成功');\n";
        echo "history.go(-1);\n";
        echo "</script>";
    } else {
        echo "<script language='javascript'>\n";
        echo "alert('变更失败');\n";
        echo "history.go(-1);\n";
        echo "</script>";
    }
}