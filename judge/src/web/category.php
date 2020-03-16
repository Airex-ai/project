<?php
    /**
     * Created by PhpStorm.
     * User: Chen
     * Date: 2018/7/5
     * Time: 19:15
     */
    session_start();
    //Vars
    require_once("./include/setting_oj.inc.php");
    require_once('./include/common_const.inc.php');
    require_once('./include/user_check_functions.php');

    $view_category="";
    $sql=$pdo->prepare("SELECT DISTINCT `source` FROM `problem` ORDER BY `problem_id` DESC LIMIT 500");
    $sql->execute();
    $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row){
        $cate=explode(" ",$row['source']);
        foreach($cate as $cat){
            if (!is_numeric($cat))
                $category[]=trim($cat);
        }
    }
    $category=array_unique($category);
    if (!$result){
        $view_category= "<h3>No Category Now!</h3>";
    }else{
        $view_category.= "<div><p>";
        foreach ($category as $cat){
            if(trim($cat)=="") continue;
            $view_category.= "<a class='btn btn-primary' href='problemset.php?wd=".htmlentities($cat,ENT_QUOTES,'UTF-8')."'>".$cat."</a>&nbsp;";
        }
        $view_category.= "</p></div>";
    }

//Page Includes
require("./pages/category.php");
?>