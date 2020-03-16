<!DOCTYPE html>
<html>
	<head>
		<?php require_once('./include/common_head.inc.php'); ?>
		<?php require_once('./include/contest_functions.inc.php'); ?>
		<title><?php echo L_CONTEST." - {$OJ_NAME}";?></title>
	</head>	
	<body>
		<?php require("./pages/components/navbar.php");?>
        <div class="main">
            <div class="container">
                <?php require("./pages/components/contest_heading.php");?>
                <div class="row">
                    <div class="col-md-8">
                        <h2><?php echo $contestItem['title'];?> <small><?php echo L_CONTEST_DESC;?> </small></h2>
                        <p class="lead">
                            <?php
                                if (!empty($contestItem['description'])) echo $contestItem['description'];
                                else echo L_CONTEST." {$contestItem['contest_id']}"; // Default contest info text.
                            ?>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h3><?php echo L_CONTEST_INFO;?></h3>
                        <p>
                            <?php echo L_CONTEST_ID;?>: <span class="text-muted"><?php echo $contestItem['contest_id'];?></span><br/>
                            <?php echo L_START_TIME;?>: <span class="text-primary"><?php echo $contestItem['start_time'];?></span><br/>
                            <?php echo L_END_TIME;?>: <span class="text-primary"><?php echo $contestItem['end_time'];?></span><br/>
                            <?php echo L_CONTEST_ISPUB;?>: <span class="text-success"><?php echo $contestPrivate;?></span><br/>
                            <?php echo L_CONTEST_STATUS;?>: <?php echo $contestState;?>
                        </p>
                    </div>
                </div>
            </div><!--main wrapper end-->
        </div>
		<?php require("./pages/components/footer.php");?>
	</body>
</html>
