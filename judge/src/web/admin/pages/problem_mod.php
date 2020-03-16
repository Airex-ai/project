<!DOCTYPE html>
<html>
<head>
	<?php require_once('../include/admin_head.inc.php'); ?>
	<?php 
		if ($PROB_ID == 0) echo "<title>".LA_PROB_ADD." - {$OJ_NAME}</title>";
		else echo "<title>".LA_PROB_EDITOR." - {$OJ_NAME}</title>";
	?>
</head>	
<body>
	<?php require('./pages/components/offcanvas.php');?>
	<div class="container" id="mainContent">
		<div class="page-header">
			<h1><?php if ($PROB_ID == 0) echo LA_PROB_ADD; else echo LA_PROB_EDITOR;?> <small><?php echo LA_PROB_MAN;?></small></h1>
		</div>
		<p class="lead">
			<?php echo $page_helper;?>
		</p>
		<form method="POST" class="form-horizontal" action="../api/problem_mod.php">
		    <label>Problem Title:</label>
			<input type="text" class="form-control" name="problem_title" placeholder="Enter Problem Title" value="<?php echo $PROB_TITLE;?>">
			<div class="row">
				<div class="col-sm-6">
					<label><?php echo L_TIME_LIMIT;?>:</label>
					<input type="text" class="form-control" name="time_limit" placeholder="Time Limit (s)" value="<?php echo $PROB_TIME;?>">
				</div>
				<div class="col-sm-6">
					<label><?php echo L_MEM_LIMIT;?>:</label>
					<input type="text" class="form-control" name="memory_limit" placeholder="Memory Limit (MB)" value="<?php echo $PROB_MEMORY;?>">
				</div>
			</div>
			<label><?php echo L_DESC;?>:</label>
			<textarea class="summernote" name="problem_desc"><?php echo $PROB_DESC;?></textarea>
			<label><?php echo L_INPUT;?>:</label>
			<textarea class="summernote" name="problem_input"><?php echo $PROB_INPUT;?></textarea>
			<label><?php echo L_OUTPUT;?>:</label>
			<textarea class="summernote" name="problem_output"><?php echo $PROB_OUTPUT;?></textarea>
			<div class="row">
				<div class="col-sm-6">
					<label><?php echo L_SAMP_INPUT;?>:</label>
					<textarea class="form-control" rows="5" name="samp_in_data" placeholder="Input Data Here"><?php echo $PROB_SAMP_IN;?></textarea>
				</div>
				<div class="col-sm-6">
					<label><?php echo L_SAMP_OUTPUT;?>:</label>
					<textarea class="form-control" rows="5" name="samp_out_data" placeholder="Output Data Here"><?php echo $PROB_SAMP_OUT;?></textarea>
				</div>
			</div>
			<p>The Sample Input / Output will display in a problem description, <em>but Test Input / Output will not.</em></p>
			<div class="row">
				<div class="col-sm-12">
					<label><?php echo L_TEST_DATA;?>:</label>
					<?php 
					if ($PROB_ID == 0) echo "<p>".LA_ADD_TEST_LATER_HINT."</p>"; 
					else echo "<p>".LA_EDIT_TESTCASE_HERE."<a href='./problem_data.php?pid={$PROB_ID}'>".L_HERE."</a></p>";
					?>
				</div>
			</div>
			<label><?php echo L_HINT;?>:</label>
			<textarea class="form-control" rows="3" name="problem_hint" placeholder="Leave blank if don't need. You can use html labels in a hint"><?php echo $PROB_HINT;?></textarea>
			<label>Special Judge:</label>
			<label class="radio-inline">
				<input type="radio" name="problem_spj" id="inlineRadio1" value="0" <?php if ($PROB_SPJ == 0) echo "checked"; ?>> No
			</label>
			<label class="radio-inline">
				<input type="radio" name="problem_spj" id="inlineRadio2" value="1" <?php if ($PROB_SPJ == 1) echo "checked"; ?>> Yes
			</label><br/>
            <label>Splice Code Judge:</label>
            <label class="radio-inline"><input type="radio" name="problem_scj" id="scj0" value="0" <?php if ($PROB_SCJ == 0) echo "checked"; ?>> No</label>
            <label class="radio-inline"><input type="radio" name="problem_scj" id="scj1" value="1" <?php if ($PROB_SCJ == 1) echo "checked"; ?>> Yes</label>
            <div class="row" id="SCjudje">
                <div class="col-sm-6">
                    <textarea class="form-control" rows="6" id="problem_scjh" name="problem_scjh" placeholder="Input the code before the student enters his code“use '& lt;' to replace '<' "><?php echo $PROB_SCJH;?></textarea>
                </div>
                <div class="col-sm-6">
                    <textarea class="form-control" rows="6" id="problem_scjf" name="problem_scjf" placeholder="Input the code after the student enters his code"><?php echo $PROB_SCJF;?></textarea>
                </div>
            </div>
            <br/>
			<label><?php echo L_SOURCE;?>:</label>
			<textarea class="form-control" rows="1" name="problem_source" placeholder="Source"><?php echo $PROB_SOURCE;?></textarea><br/>
			<?php require("../include/pageauth_post.php"); ?>
			<input type="hidden" name="problem_id" value="<?php echo $PROB_ID;?>" readonly>
			<br/>
			<button type="submit" class="btn btn-primary"><?php echo L_SUBMIT;?></button>
		</form>
	</div>
<script>
$(document).ready(function() {
    <?php if($PROB_SCJ == "0") echo '$("#SCjudje").hide();';?>
	$('.summernote').summernote({
        lang: 'zh-CN', // default: 'en-US'
        tabsize: 2,
        height: 200,
        fontNames: ['微软雅黑', '黑体', '宋体', '楷体', 'Consolas'],
        dialogsFade: true,
        callbacks: {
            onImageUpload: function (files) {
                var $curSummernote = $(this);
                var formData = new FormData();
                formData.append('file', files[0]);
                $.ajax({
                    url: '../api/pic_upload.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $curSummernote.summernote('insertImage', data, 'img');
                    }
                });
            }
        }
	});
    $('input[type=radio][name=problem_scj]').change(function() {
        if (this.value == "0") {
            $("#SCjudje").hide();
        }
        else if (this.value == "1") {
            $("#SCjudje").show();
        }
    });
});
</script>
</body>