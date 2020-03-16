<!DOCTYPE html>
<html>
<head>
    <?php require_once('./include/common_head.inc.php'); ?>
        <script src="./static/js/jquery.fullscreen-min.js"></script>
    <title><?php echo L_RANKLIST . " - {$OJ_NAME}"; ?></title>
    <style>
        .well {
            background-image: none;
            padding: 1px;
        }
        .float-button {
            position: fixed;
            bottom: 50px;
            right: 50px;
            margin: 1rem 0 0;
            padding: 0;
            width: 3.33rem;
            height: 3.33rem;
            line-height: 1;
            color: #909090;
            background-color: #fff;
            border: 1px solid #f1f1f1;
            border-radius: 50%;
            box-shadow: 0 0 5px rgba(0,0,0,.05);
            cursor: pointer;

        }
        #rank:fullscreen {
            background-color: rgba(255,255,255);
        }
        #rank:-webkit-full-screen {
            background-color: rgba(255,255,255);
        }
        #rank:-moz-full-screen {
            background-color: rgba(255,255,255);
        }
    </style>
</head>
<body>
<?php require("./pages/components/navbar.php"); ?>
<div class="main">
    <div class="container">
        <?php require("./pages/components/contest_heading.php"); ?>
        <div class="row">
            <div class="col-md-12">
                <?php if (time() < strtotime($end_time) && time() > $lock_time) { ?>
                    <br/>
                    <div class="alert alert-info" role="alert"><i class="fa fa-lock"
                                                                  aria-hidden="true"></i> <?php echo L_RANKLIST_LOCKED; ?>
                    </div>
                <?php } ?>
                <?php if ($start_time <= time()) { ?>
                    <?php if (havePrivilege('CONTEST_EDITOR')){ ?>
                <input class="btn btnExport" type="button" value="Export">
                    <script>
                        $(function () {
                            $(".btnExport").click(function () {
                                $(".table2excel").table2excel({
                                    // 不被导出的表格行的CSS class类
                                    exclude: ".noExl",
                                    // 导出的Excel文档的名称
                                    name: <?php echo time();?>,
                                    // Excel文件的名称
                                    filename: <?php echo time();?>,
                                    //文件后缀名
                                    fileext: ".xlsx",
                                    //是否排除导出图片
                                    exclude_img: true,
                                    //是否排除导出超链接
                                    exclude_links: true,
                                    //是否排除导出输入框中的内容
                                    exclude_inputs: true
                                });
                            });
                        });
                    </script>
                <?php } ?>
                    <table class="table table-striped table-hover table2excel" id="rank">
                        <thead>
                        <tr>
                            <th width="3%"><?php echo L_RANK; ?></th>
                            <th width="5%"><?php echo L_UID; ?></th>
                            <th width="10%"><?php echo L_NICK; ?></th>
                            <th width="3%"><?php echo L_SOLVED; ?></th>
                            <th width="5%"><?php echo L_PENALTY; ?></th>
                            <?php
                            for ($i = 0; $i < $problemCount; $i++) {
                                echo "<th style='text-align: center;'><a href='contest_problem.php?cid=$cid&pid=$i'>$ALPHABET_N_NUM[$i]</a></th>";
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
                                    echo "<a name=\"$cur_nick\" href='userinfo.php?uid={$cur_name}'>{$cur_name}</a>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    //Nick
                                    echo "<a name=\"$cur_nick\" href='userinfo.php?uid={$cur_name}'>{$cur_nick}</a>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    //Solved
                                    echo "<a name=\"$cur_nick\" href='contest_status.php?uid={$cur_name}&cid={$cid}'>{$cur_solved}</a>";
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
                                            $bg_color = "ff$aa$aa";
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
                        <?php } //topic list end --------------------------------------- ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
        <button title="全屏" class="btn float-button" id="fullscreen">
        </button>

    </div><!--main wrapper end-->
</div>

<?php //if (havePrivilege("CONTEST_EDITOR") && (time() > strtotime($start_time) && time() < $lock_time)) { ?>
<?php if (isset($_GET['af'])) { ?>
    <script>
        $(function () {
            setInterval(function () {
                window.location.reload();
            }, <?php echo $_GET['af']*1000;?>);
        });
    </script>
<?php } ?>
<script>

    $(document).ready(function () {
        $("#fullscreen").on("click",function () {
            element = document.getElementById("rank");
            showName(element);
            }
        );
        metal();
    });

    function showName(element) {
        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullScreen();
        }
    }

    function getTotal(rows) {
        var total = 0;
        for (var i = 0; i < rows.length && total == 0; i++) {
            try {
                total = parseInt(rows[rows.length - i].cells[0].innerHTML);
                if (isNaN(total)) total = 0;
            } catch (e) {
            }
        }
        return total;
    }

    function metal() {
        var tb = window.document.getElementById('rank');
        var rows = tb.rows;
        try {
            var total = getTotal(rows);
//alert(total);
            for (var i = 1; i < rows.length; i++) {
                var cell = rows[i].cells[0];
                var acc = rows[i].cells[3];
                var ac = parseInt(acc.innerText);
                if (isNaN(ac)) ac = parseInt(acc.textContent);
                if (cell.innerHTML != "*" && ac > 0) {
                    var r = parseInt(cell.innerHTML);
                    if (r == 1) {
                        cell.innerHTML = "Winner";
// cell.style.cssText="background-color:gold;color:red";
                        cell.className = "badge btn-warning";
                    }
                    if (r > 1 && r <= total * .1 + 1)
                        cell.className = "badge btn-warning";
                    if (r > total * .1 + 1 && r <= total * .30 + 1)
                        cell.className = "badge";
                    if (r > total * .30 + 1 && r <= total * .60 + 1)
                        cell.className = "badge btn-danger";
                    // if (r > total * .60 + 1 && ac > 0)
                    //     cell.className = "badge badge-info";
                }
            }
        } catch (e) {
//alert(e);
        }
    }
</script>
<?php require("./pages/components/footer.php"); ?>
</body>
</html>