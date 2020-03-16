<!DOCTYPE html>
<html>
<head>
    <?php require_once('../include/admin_head.inc.php'); ?>
    <title>Change User ID</title>
</head>
<body>
<?php require('./pages/components/offcanvas.php');?>
<div class="container" id="mainContent">
    <div class="page-header">
        <h1>变更用户ID<small>Change User ID</small></h1>
    </div>
    <p class="lead">
        您可以通过这里修改用户ID，但请注意：
    <ul>
        <li>请勿随意使用此功能</li>
        <li>重置密码功能不能够重置Administrator的ID</li>
    </ul><br/>
    </p>
    <div class="well">
        <form class="form-inline" action="../api/change_userid.php" method="POST">
            <div class="form-group">
                <label>输入用户ID（非昵称）: </label><br>
                <input type="text" class="form-control" name="old_id" placeholder="User ID Here">
            </div><br>
            <div class="form-group">
                <label>输入新的用户ID: </label><br>
                <input type="text" class="form-control" name="new_id" placeholder="New ID Here">
            </div><br><br>
            <?php require_once('../include/pageauth_post.php'); ?>
            <button type="submit" class="btn btn-default"><?php echo L_SUBMIT;?></button>
        </form><br>
    </div>
</div>
</body>
