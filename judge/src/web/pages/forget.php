<!DOCTYPE html>
<html>
<head>
    <?php require_once('./include/common_head.inc.php'); ?>
    <title><?php echo L_PSW_FORGET . " - {$OJ_NAME}"; ?></title>
    <script type="text/javascript">
        $(function () {
            $("#sub_btn").click(function () {
                var email = $("#email").val();
                var preg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; //匹配Email
                if (email == '' || !preg.test(email)) {
                    $("#error").html("请填写正确的邮箱！");
                } else {
                    $("#sub_btn").attr("disabled", "disabled").val('Submit...').css("cursor", "default");
                    $.post("./api/sendmail.php", {mail: email}, function (msg) {
                        if (msg == "noreg") {
                            $("#error").html("该邮箱尚未注册！");
                            $("#sub_btn").removeAttr("disabled").val('Submit').css("cursor", "pointer");
                        } else {
                            $(".forget").html("<h3>" + msg + "</h3>");
                        }
                    });
                }
            });
        })
    </script>
    <style type="text/css">
        .forget p span {
            margin-left: 6px;
            color: #f30
        }
    </style>
</head>
<body>
<?php require("./pages/components/navbar.php"); ?>
<div class="main">
    <div class="container" style="max-width:400px; padding-top:61px;">
        <div class="forget">
            <h2 class="text-center"><?php echo L_PWD_HELP; ?></h2>
            <label class="control-label"><?php echo L_EMAIL; ?></label>
            <input type="text" class="form-control" name="email" id="email"><span id="error"></span>
            <button style="margin-top:10px;" class="btn btn-lg btn-primary btn-block" id="sub_btn" type="submit"><?php echo L_SUBMIT; ?></button>
        </div>
    </div>
</div>
<?php require("./pages/components/footer.php"); ?>
</body>
</html>
