<!DOCTYPE html>
<html>
<head>
    <?php require_once('./include/common_head.inc.php'); ?>
    <link rel="stylesheet" href="./static/codemirror/codemirror.css">
    <script src="./static/codemirror/codemirror.js"></script>
    <script src="./static/codemirror/mode/javascript/javascript.js"></script>
    <script src="./static/codemirror/mode/clike/clike.js"></script>
    <script src="./static/codemirror/mode/python/python.js"></script>
    <link rel="stylesheet" href="./static/codemirror/theme/eclipse.css">
    <title><?php echo L_CODE_SUBMIT . " - {$OJ_NAME}"; ?></title>
    <style>
        .CodeMirror {
            border-style: solid;
            border-width: 2px;
            border-color: rgba(76, 5, 247, 0.3);
        }
    </style>
</head>
<body>
<?php require("./pages/components/navbar.php"); ?>
<div class="main">
    <div class="container">
        <h1 class="text-center">
            <?php
            if ($contest_id) echo "Contest {$contest_id} : Problem {$ALPHABET_N_NUM[$problem_id]}";
            else echo "Problem : {$problem_id}";
            ?>
        </h1><br/>
        <div class="row">
            <form action="./api/problem_submit.php" method="post">
                <input type="hidden" value="<?php echo $problem_id; ?>" name="pid" class="form-control" readonly/>
                <?php
                if ($contest_id) echo "<input type='hidden' value='{$contest_id}' name='cid' class='form-control' readonly />";
                ?>
                <div class="col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon"><?php echo L_LANG; ?></div>
                                <select class="form-control" id="language" name="language">
                                    <?php
                                    for ($i = 0; $i < $lang_count; $i++) {
                                        if ($lang & (1 << $i)) {
                                            echo "<option value=$i " . ($lastlang == $i ? "selected" : "") . ">" . $LANGUAGE_NAME[$i] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <br/>
                    <textarea style="display: none;" id="source"
                              name="source"><?php if ($can_edit) echo $code_src; ?></textarea>
                </div>
                <div class="col-md-12 col-sm-12">
                    <br/>
                    <div class="col-md-3 col-sm-12">
                        <button type="submit" class="btn btn-primary btn-block"><?php echo L_SUBMIT; ?></button>
                    </div>
<!--                    <div class="col-md-3 col-sm-12">-->
<!--                        <input id=TestRun class="btn btn-info btn-block"  type=button value="--><?php //echo L_TESTRUN?><!--" onclick=do_test_run();>-->
<!--                    </div>-->
<!--                    <div class="col-md-3 col-sm-12">-->
<!---->
<!--                    <span  class="btn"  id=result>状态</span>-->
<!--                    </div>-->
                </div>
            </form>
        </div>
<!--        <br/>-->
<!--        <div class="row">-->
<!--            <div class="col-md-6">-->
<!--                Test In:-->
<!--                <textarea class="form-control" rows="5"></textarea>-->
<!--            </div>-->
<!--            <div class="col-md-6">-->
<!--                Test Out:-->
<!--                <textarea class="form-control" rows="5"></textarea>-->
<!--            </div>-->
<!--        </div>-->
    </div><!--main wrapper end-->
</div>
<?php require("./pages/components/footer.php"); ?>

<script type="text/javascript">
        var editor = CodeMirror.fromTextArea(document.getElementById("source"), {
            theme:"eclipse",
            lineNumbers: true,
            matchBrackets: true,
            mode: "text/x-csrc"
        });
        var lan=$("#language").val();
        var setlan=function(){
            if(lan === "0"){
                editor.setOption("mode", "text/x-csrc");
            }else if(lan === "1"){
                editor.setOption("mode", "text/x-c++src");
            }else if(lan === "3"){
                editor.setOption("mode", "text/x-java");
            }else if(lan === "6"){
                editor.setOption("mode", "text/x-python");
            }else{
                editor.setOption("mode", "text/x-csrc");
            }
        }

        setlan();

        $("#language").change(function(){
             lan=$(this).val();
            setlan();
        });
</script>
</body>
</html>