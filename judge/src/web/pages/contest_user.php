<!DOCTYPE html>
<html>
<head>
    <?php require_once('./include/common_head.inc.php'); ?>
    <?php require_once('./include/contest_functions.inc.php'); ?>
    <title><?php echo L_CONTEST . " - {$OJ_NAME}"; ?></title>
</head>
<body>
<?php require("./pages/components/navbar.php"); ?>
<div class="main">
    <div class="container">
        <input type="button" class="btn btn-default" value="<<返回" onClick="javascript:history.back()"
        <div class="row">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th class="col-md-1">ID</th>
                    <th class="col-md-2">User ID</th>
                    <th class="col-md-2 ">Nick name</th>
                    <th class="col-md-5 text-center">Info</th>
                    <th class="col-md-1">Status</th>
                    <?php
                    if (isOperator() || isset($_SESSION["c" . $cid]) && $_SESSION["c" . $cid]) {
                        echo "<th class='col-md-1'>Edit</th>";
                    } ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($contestUser as $row) { ?>
                    <tr class="min-td-padding">
                        <td><?php echo ++$cnt; ?></td>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['nick']; ?></td>
                        <td style="padding: 0px!important;">
                            <table class="table table-bordered" style="padding: 0px;margin: 0px;">
                                <tbody>
                                <tr class="min-td-padding">
                                    <td class="col-sm-4"><?php echo $row['rname'] ? $row['rname'] : "-"; ?></td>
                                    <td class="col-sm-4"><?php echo $row['school'] ? $row['school'] : "-" ?></td>
                                    <td class="col-sm-4"><?php echo $row['major'] ? $row['major'] : "-" ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <?php echo $row['status'] ?>
                        </td>
                        <?php
                        if (isOperator() || isset($_SESSION["c" . $cid]) && $_SESSION["c" . $cid]) {
                            echo "<td>";
                            echo "<a style='color: green' href='api/contest_register.php?do=a&cid={$cid}&uid={$row['user_id']}'>Accept</a>";
                            echo "|";
                            echo "<a style='color: red' href='api/contest_register.php?do=f&cid={$cid}&uid={$row['user_id']}'>Refuse</a>";
                            echo "</td>";
                        }
                        ?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php require("./pages/components/footer.php"); ?>
</body>
</html>