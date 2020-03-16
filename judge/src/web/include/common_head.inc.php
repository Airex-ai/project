<meta charset="utf-8">
<?php if ($OJ_ENABLE_SEO) header("Access-Control-Allow-Origin: *");
{ ?>
<!-- SEO -->
<meta name="baidu-site-verification" content="NEjeELIoHs" />
<meta name="description" content="<?php echo $SEO_DESC;?>">
<meta name="keywords" content="<?php echo $SEO_KEYWORD;?>">
<?php } ?>
<!-- Icons -->
<link rel="icon" href="//cdn.witchen.cn/static/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="msapplication-TileColor" content="#FEF2E6">
<meta name="msapplication-TileImage" content="//cdn.witchen.cn/static/favicon.ico">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="//cdn.witchen.cn/static/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.witchen.cn/static/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="//cdn.witchen.cn/static/css/prettify.css" type="text/css">
<link rel="stylesheet" href="//cdn.witchen.cn/static/css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="//cdn.witchen.cn/static/css/katex.min.css">

<!-- Layui CSS/JS -->
<link rel="stylesheet" href="//cdn.witchen.cn/static/layui/css/layui.css">
<script src="//cdn.witchen.cn/static/layui/layui.js"></script>

<?php
$theme = isset($_COOKIE["colortheme"])?$_COOKIE["colortheme"]:'default';
echo "<link rel='stylesheet' type='text/css' href='//cdn.witchen.cn/static/css/{$theme}.css'>";
?>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="//cdn.witchen.cn/static/js/html5shiv.js"></script>
  <script src="//cdn.witchen.cn/static/js/respond.min.js"></script>
<![endif]-->

<!--[if lt IE 7]>
  <link rel="stylesheet" href="//cdn.staticfile.org/font-awesome/2.0.0/css/font-awesome-ie7.css" type="text/css">
<![endif]-->

<!-- javascripts -->
<script src="//cdn.witchen.cn/static/js/jquery.min.js"></script>
<script src="//cdn.witchen.cn/static/js/bootstrap.min.js"></script>
<script src="//cdn.witchen.cn/static/js/prettify.js"></script>
<script src="//cdn.witchen.cn/static/js/nprogress.js"></script>
<script src="//cdn.witchen.cn/static/js/jquery.table2excel.js"></script>
<script src="//cdn.witchen.cn/static/js/switchtheme.js"></script>
<script src="//cdn.witchen.cn/static/js/katex.min.js"></script>
<script src="//cdn.witchen.cn/static/js/auto-render.min.js"></script>
<script src="//cdn.witchen.cn/static/js/clipboard.min.js"></script>
