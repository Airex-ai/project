<!DOCTYPE html>
<html>
<head>
    <?php require_once('./include/common_head.inc.php'); ?>
    <title><?php echo L_CONTEST_PROB . " - {$OJ_NAME}"; ?></title>
</head>
<body>
<?php require("./pages/components/navbar.php"); ?>
<div class="main">
    <div class="container">
        <?php require("./pages/components/contest_heading.php"); ?>
        <?php if ($contestAuthResult) { ?>

            <?php if ($problemItem['description']) { ?>
                <h3><a data-toggle="collapse" data-target="#problemDesc"><?php echo L_PROB_DESC; ?></a></h3>
                <div class="collapse in" id="problemDesc" aria-expanded="true">
                    <pre><?php echo $problemItem['description']; ?></pre>
                </div>

            <?php }
            if ($problemItem['input']) { ?>
                <h3><a data-toggle="collapse" data-target="#problemInput"><?php echo L_INPUT; ?></a></h3>
                <div class="collapse in" id="problemInput" aria-expanded="true">
                    <pre><?php echo $problemItem['input']; ?></pre>
                </div>

            <?php }
            if ($problemItem['output']) { ?>
                <h3><a data-toggle="collapse" data-target="#problemOut"><?php echo L_OUTPUT; ?></a></h3>
                <div class="collapse in" id="problemOut" aria-expanded="true">
                    <pre><?php echo $problemItem['output']; ?></pre>
                </div>

            <?php }
            if ($problemItem['sample_input']) { ?>
                <h3 id="bl-p-datain"><a data-toggle="collapse" data-target="#dataIn"><?php echo L_SAMP_INPUT; ?></a>
                </h3>
                <div class="collapse in" id="dataIn" aria-expanded="true">
                    <div class="zero-clipboard">
                        <button class="btn-clipboard" data-clipboard-action="copy"
                                data-clipboard-target="#dataInContent">
                            复制
                        </button>
                    </div>
                    <pre id="dataInContent"><?php echo $problemItem['sample_input']; ?></pre>
                </div>

            <?php }
            if ($problemItem['sample_output']) { ?>
                <h3><a data-toggle="collapse" data-target="#dataOut"><?php echo L_SAMP_OUTPUT; ?></a></h3>
                <div class="collapse in" id="dataOut" aria-expanded="true">
                    <div class="zero-clipboard">
                        <button class="btn-clipboard" data-clipboard-action="copy"
                                data-clipboard-target="#dataOutContent">
                            复制
                        </button>
                    </div>
                    <pre id="dataOutContent"><?php echo $problemItem['sample_output']; ?></pre>
                </div>

            <?php }
            if ($problemItem['hint']) { ?>
                <h3><a data-toggle="collapse" data-target="#problemHint"><?php echo L_HINT; ?></a></h3>
                <div class="collapse in" id="problemHint" aria-expanded="true">
                    <pre><?php echo $problemItem['hint']; ?></pre>
                </div>

            <?php }
            if ($problemItem['source']) { ?>
                <h3><a data-toggle="collapse" data-target="#problemSrc"><?php echo L_SOURCE; ?></a></h3>
                <div class="collapse in" id="problemSrc" aria-expanded="true">
                    <pre><?php echo $problemItem['source']; ?></pre>
                </div>
            <?php } ?>

        <?php } ?>
    </div><!--main wrapper end-->
</div>
<?php require("./pages/components/footer.php"); ?>
<script type="text/javascript">
    layui.use('layer', function () {
        var $ = layui.jquery, layer = layui.layer;
        var clipboard = new ClipboardJS('.btn-clipboard');
        clipboard.on('success', function (e) {
            layer.msg("复制成功");
        });
        clipboard.on('error', function (e) {
            console.log(e);
            layer.msg("浏览器不支持");
        });
    });

    $(window).load(function () {
        //$("pre").addClass("prettyprint");
        prettyPrint();
    })
</script>

</body>
</html>