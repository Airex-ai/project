<?php
session_start();
//Vars & Functions
require_once('./include/setting_oj.inc.php');
require_once('./include/common_const.inc.php');
require_once('./include/contest_functions.inc.php');
require_once('./include/user_check_functions.php');

class Player
{
    var $solved = 0;
    var $time = 0;
    var $p_wa_num; //题目提交错误次数
    var $p_ac_sec; //每道题目AC的时间
    var $user_id;
    var $nick;
    function __construct()
    {
        $this->solved = 0;
        $this->time = 0;
        $this->p_wa_num = array(0);
        $this->p_ac_sec = array(0);
    }
    function Add($pid, $sec, $res)
    { //题号 时间 是否正确 当res==4时表示正确
        global $OJ_CE_PENALTY;
        if (isset($this->p_ac_sec[$pid]) && $this->p_ac_sec[$pid] > 0 || $res == 11)
            return;
        if ($res != 4) {
            if (isset($OJ_CE_PENALTY) && !$OJ_CE_PENALTY && $res == 11) return;  // ACM WF punish no ce
            if (isset($this->p_wa_num[$pid])) {
                $this->p_wa_num[$pid]++;
            } else {
                $this->p_wa_num[$pid] = 1;
            }
        } else {
            $this->p_ac_sec[$pid] = $sec;
            $this->solved++;
            if (!isset($this->p_wa_num[$pid])) $this->p_wa_num[$pid] = 0;
            $this->time += $sec + $this->p_wa_num[$pid] * 1200;
        }
    }
}

function s_cmp($A, $B)
{
    if ($A->solved != $B->solved) return $A->solved < $B->solved;
    else return $A->time > $B->time;
}

//Prepares
$cid = isset($_REQUEST['cid']) ? $_REQUEST['cid'] : "1001";

$highlightID = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";

$sql = $pdo->prepare("SELECT `start_time`,`title`,`end_time`,`password`,`private` FROM contest WHERE contest_id = ?");
$sql->execute(array($cid));
$contestItem = $sql->fetch(PDO::FETCH_ASSOC);

if ($contestItem) {
    $start_time = strtotime($contestItem['start_time']);
    $end_time = strtotime($contestItem['end_time']);
    $contest_title = $contestItem['title'];
} else {
    echo "Content Not Exist";
    exit(0);
}

if (!$OJ_LOCKRANK) $OJ_LOCKRANK_PERCENT = 0;
$lock_time = $end_time - ($end_time - $start_time) * $OJ_LOCKRANK_PERCENT;

//echo $lock_time.'-'.date("Y-m-d H:i:s",$lock_time);

//获取比赛题目的数量
$sql = $pdo->prepare("SELECT count(1) AS probCnt FROM `contest_problem` WHERE `contest_id`=?");
$sql->execute(array($cid));
$problemItem = $sql->fetch(PDO::FETCH_ASSOC);
$problemCount = $problemItem['probCnt'];


$sql = $pdo->prepare("SELECT users.user_id,users.nick,solution.result,solution.num,solution.in_date 
		FROM (
			SELECT * FROM solution WHERE solution.contest_id=? AND num>=0 and problem_id>0
		) solution INNER JOIN users ON users.user_id=solution.user_id  and users.defunct='N'
		ORDER BY users.user_id,in_date");
$sql->execute(array($cid));
$playerList = $sql->fetchAll(PDO::FETCH_ASSOC);
$playerCount = count($playerList);
$user_cnt = 0;
$user_name = '';


$playerArr = array(); //比赛人员信息
for ($i = 0; $i < $playerCount; $i++) {
    $onePlayer = $playerList[$i];
    $n_user = $onePlayer['user_id'];
    if (strcmp($user_name, $n_user)) {
        $user_cnt++;
        $playerArr[$user_cnt] = new Player();
        $playerArr[$user_cnt]->user_id = $onePlayer['user_id'];
        $playerArr[$user_cnt]->nick = $onePlayer['nick'];
        $user_name = $n_user;
    }

    if (time() < $end_time + 3600 && $lock_time < strtotime($onePlayer['in_date']))
        $playerArr[$user_cnt]->Add($onePlayer['num'], strtotime($onePlayer['in_date']) - $start_time, 0);
    else
        $playerArr[$user_cnt]->Add($onePlayer['num'], strtotime($onePlayer['in_date']) - $start_time, intval($onePlayer['result']));
}

usort($playerArr, "s_cmp");
$first_blood = array();
for ($i = 0; $i < $problemCount; $i++) {
    $sql = $pdo->prepare("SELECT user_id FROM solution WHERE contest_id=? AND result=4 AND num=? ORDER BY in_date LIMIT 1");
    $sql->execute(array($cid, $i));
    $fbResult = $sql->fetch(PDO::FETCH_ASSOC);
    $fbResultCount = count($fbResult);
    $first_blood[$i] = ($fbResultCount) ? $fbResult['user_id'] : "";
}

$except_users = array();
$tmpStr = 'e' . $cid;
$sql = $pdo->prepare("SELECT `user_id` FROM `privilege` WHERE `rightstr`=? order by user_id");
$sql->execute(array($tmpStr));
$result = $sql->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $one_user) {
    array_push($except_users, $one_user["user_id"]);
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php require_once('./include/common_head.inc.php'); ?>
    <title><?php echo L_RANKLIST . " - {$OJ_NAME}"; ?></title>
    <style>
        .well {
            background-image: none;
            padding: 1px;
        }

        html {
            overflow: -moz-hidden-unscrollable;
            height: 100%;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        body {
            -ms-overflow-style: none;
            height: 100%;
            width: calc(100vw + 18px);
            overflow: auto;
        }
    </style>
</head>

<body>
    <div class="title" style="text-align: center;">
        <h1>
            <?php echo $contest_title; ?>
        </h1>
    </div>
    <div class="main">
        <?php if (time() < strtotime($end_time) && time() > $lock_time) { ?>
            <br />
            <div class="alert alert-info" role="alert"><i class="fa fa-lock" aria-hidden="true"></i> <?php echo L_RANKLIST_LOCKED; ?>
            </div>
        <?php } ?>
        <?php if ($start_time <= time()) { ?>
            <table class="table table-striped table-hover table2excel" id="rank">
                <thead>
                    <tr>
                        <th width="3%" style="text-align: center;"><?php echo L_RANK; ?></th>
                        <th width="3%" style="text-align: center;"><?php echo L_UID; ?></th>
                        <th width="15%" style="text-align: center;"><?php echo L_NICK; ?></th>
                        <th width="3%" style="text-align: center;"><?php echo L_SOLVED; ?></th>
                        <th width="3%" style="text-align: center;"><?php echo L_PENALTY; ?></th>
                        <?php
                        for ($i = 0; $i < $problemCount; $i++) {
                            echo "<th style='text-align: center;'>$ALPHABET_N_NUM[$i]</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rank = 1;
                    for ($i = 0; $i < $user_cnt; $i++) { //player/team list
                        $cur_nick = $playerArr[$i]->nick;
                        $cur_name = $playerArr[$i]->user_id;
                        $cur_solved = $playerArr[$i]->solved;
                        ?>
                        <tr <?php if ($cur_name == $highlightID) echo "class='info'"; ?> align=center>
                            <td>
                                <?php
                                //Rank
                                if (!in_array($cur_name, $except_users)) echo $rank++;
                                else echo "*";
                                ?>
                            <td>
                                <?php
                                //User
                                echo $cur_name;
                                ?>
                            </td>
                            <td>
                                <?php
                                //Nick
                                echo $cur_nick;
                                ?>
                            </td>
                            <td>
                                <?php
                                //Solved
                                echo $cur_solved;
                                ?>
                            </td>
                            <td>
                                <?php echo round($playerArr[$i]->time / 60); ?>
                            </td>

                            <?php
                            //Problem
                            for ($j = 0; $j < $problemCount; $j++) {
                                $bg_color = "eeeeee";
                                if (isset($playerArr[$i]->p_ac_sec[$j]) && $playerArr[$i]->p_ac_sec[$j] > 0) {
                                    $aa = 0x33 + $playerArr[$i]->p_wa_num[$j] * 32;
                                    $aa = $aa > 0xaa ? 0xaa : $aa;
                                    $aa = dechex($aa);
                                    $bg_color = "$aa" . "ff" . "$aa";

                                    if ($cur_name == $first_blood[$j]) {
                                        $bg_color = "aaaaff";
                                    }
                                } else {
                                    if (isset($playerArr[$i]->p_wa_num[$j]) && $playerArr[$i]->p_wa_num[$j] > 0) {
                                        $aa = 0xaa - $playerArr[$i]->p_wa_num[$j] * 10;
                                        $aa = $aa > 16 ? $aa : 16;
                                        $aa = dechex($aa);
                                        $bg_color = "ff{$aa}{$aa}";
                                    }
                                }
                                echo "<td class=well style='background-color:#$bg_color'>";
                                if (isset($playerArr[$i])) {
                                    if (isset($playerArr[$i]->p_ac_sec[$j]) && $playerArr[$i]->p_ac_sec[$j] > 0) echo round(($playerArr[$i]->p_ac_sec[$j]) / 60);
                                    if (isset($playerArr[$i]->p_wa_num[$j]) && $playerArr[$i]->p_wa_num[$j] > 0) echo "(+" . $playerArr[$i]->p_wa_num[$j] . ")";
                                }
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    <?php }
                ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
    </div>
    </div>
    <!--main wrapper end-->
    <script>
        $(function() {
            setInterval(function() {
                window.location.reload();
            }, 10000);
        });

        $(document).ready(function() {
            metal();
        });

        function getTotal(rows) {
            var total = 0;
            for (var i = 0; i < rows.length && total == 0; i++) {
                try {
                    total = parseInt(rows[rows.length - i].cells[0].innerHTML);
                    if (isNaN(total)) total = 0;
                } catch (e) {}
            }
            return total;
        }

        function metal() {
            var tb = window.document.getElementById('rank');
            var rows = tb.rows;
            try {
                var total = getTotal(rows);
                for (var i = 1; i < rows.length; i++) {
                    var cell = rows[i].cells[0];
                    var acc = rows[i].cells[3];
                    var ac = parseInt(acc.innerText);
                    if (isNaN(ac)) ac = parseInt(acc.textContent);
                    if (cell.innerHTML != "*" && ac > 0) {
                        var r = parseInt(cell.innerHTML);
                        if (r == 1) {
                            cell.innerHTML = "Winner";
                            cell.className = "badge btn-warning";
                        }
                        if (r > 1 && r <= 3)
                            cell.className = "badge btn-warning";
                        if (r > 3 && r <= 7)
                            cell.className = "badge";
                        if (r > 7 && r <= 12)
                            cell.className = "badge btn-danger";
                        if (r > 12 && ac > 0)
                            cell.className = "badge badge-info";
                    }
                }
            } catch (e) {}
        }
    </script>
</body>

</html>