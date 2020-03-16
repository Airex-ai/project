<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-11 text-center">
                <span id="clock"><?php echo L_SRV_TIME; ?>: Loading...</span>
                <br>
                <span>
                    <?php
                    $theme = 'girlpink';
                    if (isset($_COOKIE["colortheme"]) && $_COOKIE["colortheme"] == 'girlpink') {
                        $theme = 'default';
                    }
                    echo "Copyright © 2016-" . date('Y', time()) . " <span><a href='#' id={$theme}>WITACM运维技术中心</a></span> All Rights Reserved.";
                    ?>
                    <select class="lan_select">
                        <option value="English" <?php if (!isset($_COOKIE['language']) || $_COOKIE['language'] == 'English') echo 'selected'; ?> >English</option>
                        <option value="Chinese" <?php if (isset($_COOKIE['language']) && $_COOKIE['language'] == 'Chinese') echo 'selected'; ?> >中文</option>
                    </select>
                </span>
            </div>
        </div>
    </div>
    <div style="display:none">
        <script type="text/javascript" src="https://s22.cnzz.com/z_stat.php?id=1273819391&web_id=1273819391"></script>
    </div>
</footer>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?2443acc9b61261fa7d44d8b691076cc1";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<script>
(function(){
    var bp = document.createElement('script');
    var curProtocol = window.location.protocol.split(':')[0];
    if (curProtocol === 'https') {
        bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
    }
    else {
        bp.src = 'http://push.zhanzhang.baidu.com/push.js';
    }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>
<script>
    renderMathInElement(document.body,
        {
            delimiters: [
                {left: "$$", right: "$$", display: true},
                {left: "\\[", right: "\\]", display: true},
                {left: "$", right: "$", display: false},
                {left: "\\(", right: "\\)", display: false},
            ],
            displayMode: true
        }
    );
    var delta = new Date("<?php echo date("Y/m/d H:i:s")?>").getTime() - new Date().getTime();

    function clock() {
        var h, m, s, finalText, week, year, mon, day;
        var realTime = new Date(new Date().getTime() + delta);
        year = realTime.getYear() + 1900;
        if (year > 3000) year -= 1900;
        mon = realTime.getMonth() + 1;
        day = realTime.getDate();
        week = realTime.getDay();
        h = realTime.getHours();
        m = realTime.getMinutes();
        s = realTime.getSeconds();
        finalText = "<?php echo L_SRV_TIME;?>: " + year + "/" + mon + "/" + day + " " + (h >= 10 ? h : "0" + h) + ":" + (m >= 10 ? m : "0" + m) + ":" + (s >= 10 ? s : "0" + s);
        document.getElementById('clock').innerHTML = finalText;
        setTimeout("clock()", 1000);
    }

    clock();
</script>
