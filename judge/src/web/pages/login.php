<!DOCTYPE html>
<html>
<head>
	<?php require_once('./include/common_head.inc.php'); ?>
	<title><?php echo L_LOGIN." - {$OJ_NAME}";?></title>
    <style>
        #embed-captcha {
            margin: 0px 10% 20px auto;
        }
        .show {
            display: block;
        }
        .hide {
            display: none;
        }
        #notice {
            color: red;
        }
    </style>
</head>
<body style="background:#F7F6F2">
<?php require("./pages/components/navbar.php");?>
<div class="main">
    <div class="container" style="max-width:400px; padding-top:61px;">
        <form action="./api/user_login.php" method="post">
            <h2 class="text-center"><?php echo L_PLZ.' '.L_LOGIN;?></h2>
            <label class="control-label"><?php echo L_UID;?></label>
            <input name="username" class="form-control" placeholder="<?php echo L_UID;?>" autofocus="" type="text"><br/>
            <label class="control-label"><?php echo L_PSW;?></label>
            <input name="password" class="form-control" placeholder="<?php echo L_PSW;?>" type="password"><br/>
<!--            <label class="control-label">--><?php //echo L_VERIFY;?><!--</label>-->
            <?php require_once('./include/pageauth_post.php'); ?>
            <button class="btn btn-lg btn-default btn-block embed-submit" type="submit"><?php echo L_LOGIN;?></button>
            <span class="btn btn-lg btn-info btn-block" onclick="window.location.href='/qq/login.php';"><i class="fa fa-qq"></i><?php echo L_QQ_LOGIN;?></span>
        </form>
    <div style="margin-top:10px;">
        <a href="forget.php"><?php echo L_RESET;?></a> 
    </div>
    </div> <!-- /container -->
</div>
<?php require("./pages/components/footer.php");?>
</body>
</html>
