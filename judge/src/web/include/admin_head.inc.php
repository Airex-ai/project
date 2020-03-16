<meta charset="utf-8">
<!-- Icons -->
<link rel="shortcut icon" href="../static/favicon.ico">
<meta name="msapplication-TileColor" content="#FEF2E6">
<meta name="msapplication-TileImage" content="../static/favicon.ico">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../static/css/bootstrap.min.css">
<link rel="stylesheet" href="../static/css/jasny-bootstrap.min.css">
<link rel="stylesheet" href="../static/summernote/summernote.css" type="text/css">
<link rel="stylesheet" href="../static/css/prettify.css" type="text/css">
<link rel="stylesheet" href="../static/css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="../static/css/default.css" type="text/css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

<script src="../static/js/html5shiv.js"></script>
<script src="../static/js/respond.min.js"></script>
<link rel="stylesheet" href="../static/css/admin-css.css" type="text/css">

<!-- js文件 -->
<script src="../static/js/jquery.min.js"></script>
<script src="../static/js/jquery.pjax.min.js"></script>
<script src="../static/js/bootstrap.min.js"></script>
<script src="../static/js/jasny-bootstrap.min.js"></script>
<script src="../static/summernote/summernote.js"></script>
<script src="../static/summernote/lang/summernote-zh-CN.js"></script>
<script src="../static/js/prettify.js"></script>
<script src="../static/js/nprogress.js"></script>
<script src="../static/js/jquery.table2excel.js"></script>


<?php
function is_pjax()
{ //place here to make sure this can be used in everypage
    return array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX'] === 'true';
}

?>
<script>
    $(document).pjax('[nav-pjax] a', '#mainContent');
    $(document).on('pjax:send', function () {
        NProgress.start()
    })
    $(document).on('pjax:complete', function () {
        NProgress.done()
    })
</script>