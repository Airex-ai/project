<!--Created by PhpStorm.-->
<!--User: Chen-->
<!--Date: 2019/4/21-->
<!--Time: 9:14-->
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
                <table class="table table-striped table-hover table2excel" id="rank">
                    <thead>
                    <tr>
                        <th width="16%"><?php echo L_TIME_COST; ?></th>
                        <th width="8%"><?php echo L_PROBLEM; ?></th>
                        <th width="56%"><?php echo L_TITLE; ?></th>
                        <th width="14%"><?php echo L_AUTHOR; ?></th>
                        <th width="6%"><?php echo L_REPLY; ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($topic as $row) { ?>
                        <tr>
                            <td>
                                <?php
                                //User
                                echo $row['posttime'];
                                ?>
                            </td>
                            <td>
                                <?php
                                //User
                                echo "<a href='contest_problem.php?cid={$cid}&pid={$row['pid']}'>{$ALPHABET_N_NUM[$row['pid']]}</a>";
                                ?>
                            </td>
                            <td>
                                <?php
                                //User
                                echo "<a href='contest_viewtopic.php?cid={$cid}&tid={$row['tid']}'>{$row['title']}</a>";
                                ?>
                            </td>
                            <td>
                                <?php
                                //User
                                echo $row['author_id'];
                                ?>
                            </td>
                            <td>
                                <?php
                                //User
                                echo $row['count']-1;
                                ?>
                            </td>

                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <hr>
                <?php if(time()>strtotime($contestItem['start_time'])&&time()<strtotime($contestItem['end_time'])){?>
                <form id="postThreadForm" class="form-group">
                    <h3>Post a new topic:</h3>
                    <input type="hidden" class="form-control" name="do" value="postthread">
                    <input type="hidden" class="form-control" name="cid" value="<?php echo $cid;?>">
                    <label for="titleInput">Problem:</label>
                    <select name="pid" class="form-control">
                        <?php
                        for($i=0;$i<$problemCount;$i++){
                            echo "<option value='{$i}'>{$ALPHABET_N_NUM[$i]}</option>";
                        }
                        ?>
                    </select>
                    <label for="titleInput">Title:</label>
                    <input type="text" class="form-control" id="titleInput" name="title" placeholder="Title">
                    <label for="contentInput">Content:</label>
                    <textarea class="form-control" id="contentInput" name="content" rows="6"></textarea>
                </form>
                <button class="btn btn-primary" id="doPostBtn" style="margin: .4em 0;"><?php echo L_SUBMIT;?></button>
                <?php }?>
            </div>
        </div>
    </div>
</div><!--main wrapper end-->
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="dialogModel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="dialogTitle">Hey!</h4>
            </div>
            <div class="modal-body" id="dialogText"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo L_CLOSE;?></button>
                <a type="button" class="btn btn-primary" id="btnPostSuccess"><?php echo L_REFRESH;?></a>
            </div>
        </div>
    </div>
</div>

<?php require("./pages/components/footer.php"); ?>
<script>
    $(document).ready(function () {
        $('#doPostBtn').click(button_doPostBtn_onClick);
    });

    function button_doPostBtn_onClick() {
        <?php if (isset($_SESSION["user_id"])) { ?>
        var $divModal = $("#dialogModel");
        $.post('./api/ajax_discuss.php',
            $('#postThreadForm').serialize(),
            function (data, status) {
                $("#dialogTitle").text("Post success!");
                $("#dialogText").text("Press the F5.\n" +
                    "Refresh the page.\n");
                $("#btnPostSuccess").attr("href", "contest_listtopic.php?cid=" + data.result.cid).show();
                $divModal.modal("show");
            }
        ).error(function (data, status) {
            var ret = $.parseJSON(data.responseText);
            $("#dialogTitle").text("Post failed!");
            $("#dialogText").text(ret.message);
            $("#btnPostSuccess").hide();
            $divModal.modal("show");
        });
        <?php } ?>
    }

</script>
</body>
</html>