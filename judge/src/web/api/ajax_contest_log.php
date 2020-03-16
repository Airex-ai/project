<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2019/4/19
 * Time: 8:57
 */

require_once("../include/setting_oj.inc.php");
if (isset($_GET['cid'])) {
    $cid = $_GET['cid'];
    $sql = $pdo->prepare("SELECT * FROM contest_problem WHERE contest_id=$cid");
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    $problem_cnt = count($result);

    $sql = $pdo->prepare("SELECT UNIX_TIMESTAMP(start_time) FROM contest WHERE contest_id=$cid");
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    $start_time = $result['UNIX_TIMESTAMP(start_time)'];

    $json = array();
    $json['problem_count'] = intval($problem_cnt);

    $sql = $pdo->prepare("SELECT user_id FROM privilege WHERE rightstr = 'e'.$cid");
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    $is_exclude = array();
    foreach ($result as $row) {
        $is_exclude[$row['user_id']] = true;
    }


    $sql = $pdo->prepare("
			SELECT
				solution.solution_id,
				solution.user_id,
				users.nick,
				solution.num,
				solution.result,
				UNIX_TIMESTAMP(solution.in_date) AS in_date
			FROM
				solution,users
			WHERE
			    solution.user_id = users.user_id
				AND 
				solution.contest_id = $cid
			ORDER BY
				in_date");
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    $json['solutions'] = array();
    $json['users'] = array();
    $vis = array();
    $id = 1;
    foreach ($result as $row) {
        $temp = array();
        if (isset($vis[$row['user_id']])) ;
        else {
            $json['users']["$id"] = array(
                "name" => $row['user_id'],
                "college" =>  $row['nick'],
                "is_exclude" => isset($is_exclude[$row['user_id']])
            );
            $vis[$row['user_id']] = "$id";
            $id++;
        }
        $temp['user_id'] = $vis[$row['user_id']];
        $index = $row['num'] + 1;
        $temp['problem_index'] = "$index";
        $temp['verdict'] = $row['result'] == 4 ? "AC" : "WA";
        $temp['submitted_seconds'] = intval($row['in_date']) - intval($start_time);
        $run_id = $row['solution_id'];
        $json['solutions']["$run_id"] = $temp;
    }
    echo json_encode($json);
}
?>
