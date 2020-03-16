<?php
    session_start();
    //Vars
    require_once('./include/setting_oj.inc.php');
    require_once('./include/user_check_functions.php');

    //Prepares
    $nid=isset($_GET['nid']) ? intval($_GET['nid']) : 0;

    if ($nid==0) {
    exit("404 No such news");
    }

    $sql=$pdo->prepare("SELECT * FROM `news` WHERE `news_id` =?");
    $sql->execute(array($nid));
    $result=$sql->fetch(PDO::FETCH_ASSOC);

    if(!$result || $result['defunct'] !='N') {
        exit("404 No such news");
    }
    //Page Includes
    require("./pages/news.php");
?>