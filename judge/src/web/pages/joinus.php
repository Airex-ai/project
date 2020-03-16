<!DOCTYPE html>
<html>
<head>
    <?php require_once('./include/common_head.inc.php'); ?>
    <title><?php echo 申请." - {$OJ_NAME}";?></title>

</head>
<body>
<?php require("./pages/components/navbar.php");?>
<div class="main">
    <div class="container">
        <div class="form row">
            <form method="post" action="joinus.php" id="jointeam">
                <div class="col-sm-6 col-md-6 ">
                    <h3 class="form-title">申请加入武汉工程大学ACM算法协会</h3>
                    <div class="form-group">
                        <label for="name" >1.姓名</label>
                        <input class="form-control required" type="text" name="username" maxlength="8" required/>
                    </div>

                    <div class="form-group">
                        <label for="name">2.年级</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="grade" id="optionsRadios1" value="2017" checked> 2017级
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="grade" id="optionsRadios2" value="2018"> 2018级
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="grade" id="optionsRadios3" value="2019"> 2019级
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" >3.专业</label>
                        <input class="form-control required" type="text"  name="major" maxlength="20" required/>
                    </div>
                    <div class="form-group">
                        <label for="name" >4.QQ</label>
                        <input class="form-control required" type="text"  name="qq" maxlength="11" required/>
                    </div>
                    <div class="form-group">
                        <label for="name" >5.手机号码</label>
                        <input class="form-control required" type="text"  name="tel" maxlength="11" required/>
                    </div>
                    <?php require_once("include/pageauth_post.php")?>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success btn-group-justified " value="提交 "/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require("./pages/components/footer.php");?>
</body>
</html>
