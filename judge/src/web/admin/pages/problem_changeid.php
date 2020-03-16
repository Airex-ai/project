<!DOCTYPE html>
<html>
<head>
    <?php require_once('../include/admin_head.inc.php'); ?>
    <title>Change Problem ID</title>
</head>
<body>
<?php require('./pages/components/offcanvas.php'); ?>
<div class="container" id="mainContent">
    <div class="page-header">
        <h1>变更题目序号
            <small>Change Problem ID</small>
        </h1>
    </div>
    <p class="lead">
        Change Problem ID
    </p>
    <div class="well">
        <form action='../api/problem_changeid.php' method=post>
            <div class="form-group">
                <label>原题目序号：</label>
                <input type="text" class="form-control" name="from" placeholder="输入题目ID，如1001">
            </div>

            <div class="form-group">
                <label>新题目序号：</label>
                <input type="text" class="form-control" name="to" placeholder="输入题目ID，如1001">
            </div>
            <?php include_once "../include/pageauth_post.php" ?>
            <button type="submit" class="btn btn-default">变更题号</button>
        </form>
        <br/>
    </div>
</div>
</body>
</html>