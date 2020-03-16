<!DOCTYPE html>
<html>
<head>
    <?php require_once('./include/common_head.inc.php'); ?>
    <title><?php echo L_NEWSDETAIL." - {$OJ_NAME}";?></title>

</head>
<body>
<?php require("./pages/components/navbar.php");?>
<div class="main">
    <div class="container">
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-offset-2 col-md-8">
                <h3 class="text-center" style="margin-top: 0; margin-bottom: 30px;"><?php echo $result['title']?></h3>
                <div>
                    <?php echo $result['content']?>
                    <center><h6><?php echo 'By:'.$result['user_id']." ".$result['time']?></h6></center>
                </div>
                <h3 style="margin-top: 60px;">Comment</h3>
                <div id="vcomments"></div>
                <script src="//cdn1.lncld.net/static/js/3.0.4/av-min.js"></script>
                <script src="//unpkg.com/valine"></script>
                <script>
                    var valine = new Valine();
                    var path = "news.php?nid=<?php echo $result['news_id']?>";
                    valine.init({
                        el: '#vcomments' ,
                        appId: 'bbY2XSInFx6IxFJS1MxvAzuj-gzGzoHsz',
                        appKey: 'n672mclWPixNoFhSwOggQ8X3',
                        placeholder: 'Just Go Go.',
                        avatar:'mm',
                        path:path,
                        lang: 'en',
                        visitor:true,
                        meta:['nick','mail']
                    })
                </script>
            </div>
        </div>
    </div>
</div>
<?php require("./pages/components/footer.php");?>
</body>
</html>