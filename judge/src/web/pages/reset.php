<!DOCTYPE html>
<html>
<head>
    <?php require_once('./include/common_head.inc.php'); ?>
    <title><?php echo L_RESET . " - {$OJ_NAME}"; ?></title>
</head>
<body>
<?php require("./pages/components/navbar.php"); ?>
<div class="main">
    <div class="container" style="max-width:400px; padding-top:61px;">
        <form action="./api/user_resetpwd.php" method="post">
            <h2 class="text-center"><?php echo L_RESET; ?></h2>
            <label class="control-label"><?php echo L_PSW; ?></label>
            <input name="password" class="form-control" placeholder="<?php echo L_PSW; ?>" autofocus="" type="password"><br/>
            <label class="control-label"><?php echo L_PSW_AGAIN; ?></label>
            <input name="repassword" class="form-control" placeholder="<?php echo L_PSW_AGAIN; ?>" type="password"><br/>
            <input type="hidden" name="email" value="<?php echo $email ?>" readonly>
            <input type="hidden" name="token" value="<?php echo $token ?>" readonly>
            <?php require_once('./include/pageauth_post.php'); ?>
            <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo L_SUBMIT; ?></button>
        </form>
    </div> <!-- /container -->
</div>
<script>

</script>
<?php require("./pages/components/footer.php"); ?>
</body>
</html>