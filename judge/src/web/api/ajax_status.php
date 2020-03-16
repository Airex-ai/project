<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/7/23
 * Time: 20:38
 */

session_start();

$ON_ADMIN_PAGE="Yap";
require_once("../include/setting_oj.inc.php");
require_once("../include/common_functions.inc.php");


if(!isset($_POST['sid'])) {
    fire(404,"error", "Missing Problem ID.");
}
// Prepare
$solution_id = $_POST['sid'];

// Query
$sql=$pdo->prepare("SELECT `solution_id`,`time`,`memory`,`result` FROM `solution`  WHERE `solution_id`={$solution_id}");
$sql->execute();
$res=$sql->fetchAll(PDO::FETCH_ASSOC);

fire(200, "success", $res[0]);