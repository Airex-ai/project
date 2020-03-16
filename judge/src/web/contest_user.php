<?php
session_start();
//Vars
require_once('./include/setting_oj.inc.php');
require_once('./include/memcache.php');
require_once('./include/contest_functions.inc.php');
require_once('./include/user_check_functions.php');

//Prepare
if (!isset($_GET['cid'])) {
    exit('error');
}
$cnt = 0;
$cid = $_GET['cid'];
$sql = $pdo->prepare("select users.*,privilege.* 
from users inner join privilege on users.user_id = privilege.user_id where rightstr =?");

$sql->execute(array("c" . $cid));

$contestUser = $sql->fetchAll(PDO::FETCH_ASSOC);

foreach ($contestUser as &$row) {

    if ($row['defunct'] == 'N')
        $row['status'] = "<span class='label label-success'>Accept</span>";
    else if ($row['defunct'] == 'Y')
        $row['status'] = "<span class='label label-danger'>Refuse</span>";
    else
        $row['status'] = "<span class='label label-default'>Pending</span>";
}

//var_dump($contestUser);

unset($row);
//Page Includes
require("./pages/contest_user.php");
?>