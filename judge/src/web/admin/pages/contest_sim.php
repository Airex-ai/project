<!DOCTYPE html>
<html>
<head>
    <?php require_once('../include/admin_head.inc.php'); ?>
    <?php require_once('../include/common_const.inc.php'); ?>
    <title><?php echo LA_SIM." - {$OJ_NAME}";?></title>
</head>
<body>
<?php require('./pages/components/offcanvas.php');?>
<div class="container" id="mainContent">
    <div class="page-header">
        <h1><?php echo LA_SIM;?> <small>Code re-check</small></h1>
    </div>
    <p class="lead">
        <?php echo LA_SIM_HEAD;?>
    </p>
    <ul class="nav nav-pills nav-justified">
        <li><a href="./contest_list.php"><?php echo LA_CONT_LIST;?></a></li>
        <li><a href="./contest_manager.php"><?php echo LA_MORE_OPTIONS;?></a></li>
    </ul>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover" id="tableID">
                <thead>
                <tr>
                    <th ><?php echo L_RUN_ID;?></th>
                    <th><?php echo L_UID;?></th>
                    <th><?php echo L_NICK;?></th>
                    <th><?php echo L_PROB_ID;?></th>
                    <th><?php echo L_RESULT;?></th>
                    <th><?php echo L_SIM;?></th>
                    <th><?php echo L_COMPILER;?></th>
                    <th><?php echo L_SUBMIT_TIME;?></th>
                </tr>
                </thead>
                <tbody id="oj-statue-list">
                <?php
                foreach($statusResult as $row) {
                    $resUrl = "<span class='label label-danger'>{$row['sim_s_id']}</span>";
                    $resSim = "<span class='label label-warning'>{$row['sim']}</span>";
                    $codeUrl = "{$LANGUAGE_NAME[$row['language']]}";
                    ?>
                    <?php
                    //通过id获取用户呢称
                    $sql_str="SELECT * FROM `solution` WHERE problem_id>0 and contest_id is null ";
                    $sql_str = "SELECT * FROM `users` WHERE user_id='{$row['user_id']}';";
                    $sql=$pdo->prepare($sql_str);
                    $sql->execute();
                    $user=$sql->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <tr>
                        <td class="solution_id"><?php echo $row['solution_id']; ?></td>
                        <td><?php echo "<a href='../userinfo.php?uid={$row['user_id']}'>{$user[0]['user_id']}</a>";?></td>
                        <td><?php echo "<a href='../userinfo.php?uid={$row['user_id']}'>{$user[0]['nick']}</a>";?></td>
                        <td><?php echo "<a href='../problem.php?pid={$row['problem_id']}'>{$row['problem_id']}</a>";?></td>
                        <td class="result"><?php echo "<a href='source_sim_view.php?id={$row['solution_id']}'>{$resUrl}</a>"; ?></td>
                        <td><?php echo "<a href='source_sim_view.php?id={$row['solution_id']}'>{$resSim}</a>"; ?></td>
                        <td><?php echo $codeUrl; ?></td>
                        <td><?php echo $row['in_date']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $(".btn").click(function(){
            $(".table2excel").table2excel({
                // 不被导出的表格行的CSS class类
                exclude: ".noExl",
                // 导出的Excel文档的名称
                name: "代码查重",
                // Excel文件的名称
                filename: "代码查重",
                //文件后缀名
                fileext: ".xls",
                //是否排除导出图片
                exclude_img: false,
                //是否排除导出超链接
                exclude_links: false,
                //是否排除导出输入框中的内容
                exclude_inputs: false
            });
        });
    });
    ;(function(){
        var tbody = document.querySelector('#tableSort').tBodies[0];
        var th = document.querySelector('#tableSort').tHead.rows[0].cells;
        var td = tbody.rows;
        for(var i = 0;i < th.length;i++){
            th[i].flag = 1;
            th[i].onclick = function(){
                sort(this.getAttribute('data-type'),this.flag,this.cellIndex);
                this.flag = -this.flag;
            };
        };
        function sort(str,flag,n){
            var arr = [];
            for(var i = 0;i < td.length;i++){
                arr.push(td[i]);
            };
            arr.sort(function(a,b){
                return method(str,a.cells[n].innerHTML,b.cells[n].innerHTML) * flag;
            });
            for(var i = 0;i < arr.length;i++){
                tbody.appendChild(arr[i]);
            };
        };
        function method(str,a,b){
            switch(str){
                case 'num':
                    return a-b;
                    break;
                case 'string':
                    return a.localeCompare(b);
                    break;
                default:
                    return new Date(a.split('-').join('/')).getTime()-new Date(b.split('-').join('/')).getTime();
            };
        };
    })();
</script>


</body>
</html>