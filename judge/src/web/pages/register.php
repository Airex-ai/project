<!DOCTYPE html>
<html>
<head>
	<?php require_once('./include/common_head.inc.php'); ?>
	<script src="./static/js/jqBootstrapValidation.js"></script>
	<title><?php echo L_REGISTER." - {$OJ_NAME}";?></title>
</head>	
<body style="background:#F7F6F2">
<?php require("./pages/components/navbar.php");?>
<div class="main">
    <div class="container" style="max-width:400px; padding-top:61px;">
		<div class="panel" style="padding:20px 20px;">
			<form action="./api/user_register.php" method="post">
			<h2><?php echo L_PLZ.' '.L_REGISTER;?></h2>
			<label class="control-label"><?php echo L_UID;?></label>
			<div class="control-group">
				<input 
					name="username" 
					class="form-control" 
					minlength="6"
					maxlength="20"
					placeholder="(*) <?php echo L_UID_MSG;?>"
					data-validation-minlength-message="<?php echo L_UID_DV_MSG;?>" 
					type="number"
					required
				/>
				<p class="help-block"></p>
			</div>
			<label class="control-label"><?php echo L_NICK;?></label>
			<div class="control-group">
				<input name="nickname" class="form-control" placeholder="<?php echo L_NICK;?>" type="text">
				<p class="help-block"></p>
			</div>
			<label class="control-label"><?php echo L_PSW;?></label>
			<div class="control-group">
				<input
					name="password" 
					class="form-control" 
					placeholder="(*) <?php echo L_PSW;?>" 
					type="password"
					minlength="6"
					data-validation-minlength-message="<?php echo L_PSW_DV_MSG;?>"
					required
				>
				<p class="help-block"></p>
			</div>
			<label class="control-label"><?php echo L_PSW_AGAIN;?></label>
			<div class="control-group">
				<input 
					name="password_again" 
					class="form-control" 
					data-validation-match-match="password" 
					data-validation-match-message = "<?php echo L_PSW2_DV_MSG;?>"
					placeholder="(*) <?php echo L_PSW_AGAIN;?>" 
					type="password"
				>
				<p class="help-block"></p>
			</div>
<!--			<label class="control-label">--><?php //echo L_SCHOOL;?><!--</label>-->
			<div class="control-group" >
				<input name="school"  type="hidden" class="form-control" placeholder="<?php echo L_SCHOOL;?>" type="text">
				<p class="help-block"></p>
			</div>
			<label class="control-label"><?php echo L_EMAIL;?></label>
			<div class="control-group">
				<input name="email" class="form-control" placeholder="(*) E-Mail" type="email" required>
				<p class="help-block"></p>
			</div>
			<div class="control-group">
				<div class="checkbox btn-block">
					<label>
						<input 
							name="eula" 
							type="checkbox" 
							required
						> <?php echo L_AGREE_EULA;?>
					</label>
					<p class="help-block"></p>
				</div>
			</div>
			
			<?php require_once('./include/pageauth_post.php'); ?>
		
			<button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo L_REGISTER;?></button>
			</form>
		</div>
    </div> <!-- /container -->
</div>
<script>
	$(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );
</script>
<?php require("./pages/components/footer.php");?>
</body>
</html>