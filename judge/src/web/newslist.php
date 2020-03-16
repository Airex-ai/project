<?php
    session_start();
    //Vars
    require_once('./include/setting_oj.inc.php');
    require_once('./include/user_check_functions.php');
    //Prepares
    $sql=$pdo->prepare("SELECT * 
    FROM  `news` 
    WHERE  `defunct` !=  'Y'
    ORDER BY `importance` DESC,`time` DESC ");
    $sql->execute();
    $newsList=$sql->fetchAll(PDO::FETCH_ASSOC);

    //Page Includes
    require("./pages/newslist.php");
?>