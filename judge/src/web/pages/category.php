<!DOCTYPE html>
<html>
<head>
    <?php require_once('./include/common_head.inc.php'); ?>
    <title><?php echo L_CATEGORY." - {$OJ_NAME}";?></title>
</head>
<body>
<?php require("./pages/components/navbar.php");?>
<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center"style="margin: 5em;">
                    <?php echo $view_category?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require("./pages/components/footer.php");?>
</body>
</html>