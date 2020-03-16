<?php

session_start();
//Vars
require_once('./include/setting_oj.inc.php');
require_once('./include/common_functions.inc.php');
require_once('./include/user_check_functions.php');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!isset($_SESSION['user_id'])) {
    echo "<script language='javascript'>\n";
    echo "alert('请先登录!');\n";
    echo "window.location.href='https://witacm.com/login.php';\n";
    echo "</script>";
}


if (isset($_SESSION['user_id'])&&isset($_POST['username'])) {
    require_once("include/checkauth_post.php");
    $userid = $_SESSION['user_id'];

    $sql= $pdo->prepare("SELECT * FROM `team_user` WHERE user_id=?");
    $sql->execute(array($userid));
    $result = $sql->fetchAll();

    if(count($result)){
        echo "<script language='javascript'>\n";
        echo "alert('你已经申请过了，请勿重复提交');\n";
        //echo "window.location.href='https://shang.qq.com/wpa/qunwpa?idkey=029751b32aaf50314fc8b83b8f51b46f33de5cfaa813c4b3b6b2c959ed0ddd9b';\n";
        echo "</script>";
    }
    $sql= $pdo->query("SELECT DISTINCT problem_id FROM `solution` WHERE user_id={$userid} AND result = 4");
    $result = $sql->fetchAll();

    if(count($result)>=10){
        $username=stripslashes($_POST['username']);
        $grade   =stripslashes($_POST['grade']);
        $major   =stripslashes($_POST['major']);
        $qq      =stripslashes($_POST['qq']);
        $tel     =stripslashes($_POST['tel']);
        $sql=$pdo->prepare("INSERT INTO `team_user` (`user_id`,`username`,`grade`,`major`,`qq`,`tel`) VALUES(?,?,?,?,?,?)");
        $sql->execute(array($userid,$username,$grade,$major,$qq,$tel));

        $sql=$pdo->prepare("UPDATE `users` set isteam='Y' WHERE user_id=?");
        $sql->execute(array($userid));

        echo "<script language='javascript'>\n";
        echo "alert('申请成功');\n";
        //echo "window.location.href='https://shang.qq.com/wpa/qunwpa?idkey=029751b32aaf50314fc8b83b8f51b46f33de5cfaa813c4b3b6b2c959ed0ddd9b';\n";
        echo "</script>";
    }
    else
    {   echo "<script language='javascript'>\n";
        echo "alert('您暂不符合条件，请确保至少AC了10题。请继续加油哦！');\n";
        echo "</script>";
    }
}

require_once("pages/joinus.php");
