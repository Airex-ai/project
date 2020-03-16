<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2019/4/19
 * Time: 16:36
 */


require_once("../include/setting_oj.inc.php");

$a1 = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
$a2 = array(4, 5, 7, 8, 6, 10, 9, 11, 12, 13);
$answer = array();
for ($i = 0; $i < 10; $i++)
    $answer[$a2[$i]] = $a1[$i];

if (isset($_GET['cid'])) {
    $json = array();
    $json['submit'] = array();
    $json['teamlist'] = array();

    $cid = $_GET['cid'];
    $sql = $pdo->prepare("SELECT * FROM contest_problem WHERE contest_id=$cid");
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    $problem_cnt = count($result);
    $problem = array();
    foreach ($result as $row) {
        $problem[$row['problem_id']] = chr(65 + $row['num']);
    }

    $sql = $pdo->prepare("SELECT user_id FROM privilege WHERE rightstr = 'e'.$cid");
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    $is_exclude = array();
    foreach ($result as $row) {
        $is_exclude[$row['user_id']] = true;
    }

    $sql = $pdo->prepare("SELECT * FROM solution,users WHERE solution.contest_id=$cid and users.user_id = solution.user_id ORDER BY in_date");
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    $vis = array();
    $id = 1;
    foreach ($result as $row) {
        /**
         * Team对象
         * @param {int}     teamId      队伍ID
         * @param {String}  teamName    队伍名
         * @param {String}  teamMember  队员
         * @param {boolean} official     是否计入排名
         */

        if (isset($vis[$row['user_id']])) ;
        else {
            $json['teamlist']["$id"] = array(
                "teamId" => $id,
                "teamName" => $row['user_id'].'-'.$row['nick'],
                "teamMember" => "NULL",
                "official" => isset($is_exclude[$row['user_id']])
            );
            $vis[$row['user_id']] = "$id";
            $id++;
        }

        /**
         * Submit对象
         * @param {int}     submitId    全局runID
         * @param {int}     teamId      队伍ID
         * @param {String}  alphabetId  比赛中的题目ID：A,B,C...
         * @param {int}     subTime     提交时间
         * @param {int}     resultId    判题结果ID
         */

        $temp = array();
        $temp['submitId'] = $row['solution_id'];
        $temp['teamId']   = $vis[$row['user_id']];
        $temp['nick']     = $row['nick'];
        $temp['alphabetId'] = $problem[$row['problem_id']];
        $temp['subTime']  = $row['in_date'];
        $temp['resultId'] = $answer[$row['result']];

        array_push($json['submit'], $temp);
    }
}
echo json_encode($json);
?>
