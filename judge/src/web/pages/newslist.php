<!DOCTYPE html>
<html>
<head>
    <?php require_once('./include/common_head.inc.php'); ?>
    <title><?php echo L_NEWSLIST." - {$OJ_NAME}";?></title>
</head>
<body>
<?php require("./pages/components/navbar.php");?>
<div class="container">
    <div class="row">
        <table class="table table-hover">
            <thead>
            <tr>
                <th><?php echo L_NEWSLIST;?></th>
            </tr>
            </thead>
            <tbody>
                <?php
                foreach ($newsList as $news){
                    echo "<tr><td><a href='news.php?nid={$news['news_id']}'>{$news['title']}</a></td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="row text-center">
        <div>
        </div>
    </div>
</div>
<?php require("./pages/components/footer.php");?>
</body>
</html>