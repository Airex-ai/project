<!DOCTYPE html>
<html>
<head>
    <?php require_once('../include/admin_head.inc.php'); ?>
    <title><?php echo L_SRC_SIM_VIEW . " - {$OJ_NAME}"; ?></title>
</head>
<body>
<?php require('./pages/components/offcanvas.php');?>
<div class="main">
    <div class="container">
        <div class="page-header">
            <h1><?php echo LA_SIM_DETAIL;?> <small>Code comparison</small></h1>
        </div>
        <input type="button" class="btn btn-default" value="<<返回"onClick="javascript:history.back()">
        <div class="row">
            <div class="container col-md-6">
                <div class="page-header">
                    <h1><?php echo $code_title; ?><br>
                        <small><?php echo "Code by: " . $code_author; ?><br>
                            <strong>These codes are duplicates!</strong>
                        </small>
                    </h1>
                </div>
                <pre class="prettyprint linenums"><?php echo $code_src; ?></pre>
                <div class="panel">
                    <p class="text-info"><b>User Name: </b><code><?php echo $code_author; ?></code></p>
                    <p class="text-info"><b>Time: </b><code><?php echo $code_date; ?></code></p>
                    <p class="text-info"><b>Language: </b><code><?php echo $LANGUAGE_NAME[$code_lang]; ?></code></p>

                    <p class="text-info"><b>Judge Result: </b><code><?php echo $code_result; ?></code></p>
                    <p class="text-info"><b>Time Cost: </b><code><?php echo $code_time . " MS"; ?></code></p>
                    <p class="text-info"><b>Memory Cost: </b><code><?php echo $code_memory . " KB"; ?></code></p>
                </div>
            </div>

            <div class="container col-md-6">
                <div class="page-header">
                    <h1><?php echo $code_title_sim; ?><br>
                        <small><?php echo "Similar Code by: " . $code_author_sim; ?><br>
                            <strong><?php echo "Repetition rate: $code_sim_rate%" ?></strong>
                        </small>
                    </h1>
                </div>
                <pre class="prettyprint linenums"><?php echo $code_src_sim; ?></pre>
                <div class="panel">
                    <p class="text-info"><b>User Name: </b><code><?php echo $code_author_sim; ?></code></p>
                    <p class="text-info"><b>Time: </b><code><?php echo $code_date_sim; ?></code></p>
                    <p class="text-info"><b>Language: </b><code><?php echo $LANGUAGE_NAME[$code_lang_sim]; ?></code></p>

                    <p class="text-info"><b>Judge Result: </b><code><?php echo $code_result_sim; ?></code></p>
                    <p class="text-info"><b>Time Cost: </b><code><?php echo $code_time_sim . " MS"; ?></code></p>
                    <p class="text-info"><b>Memory Cost: </b><code><?php echo $code_memory_sim . " KB"; ?></code></p>
                </div>
            </div>
        </div>
    </div><!--main wrapper end-->
</div>
<script type="text/javascript">
    $(window).load(function () {
        $("pre").addClass("prettyprint");
        prettyPrint();
    })
</script>

</body>
</html>