<!DOCTYPE html>
<html>
<head>
    <?php require_once('./include/common_head.inc.php'); ?>
    <title><?php echo L_RECENT_CONTEST . " - {$OJ_NAME}"; ?></title>
    <style>
        body {
            font-family: "Helvetica Neue", Helvetica, "Microsoft Yahei", Arial, sans-serif;
        }

        .mgdiv {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        th, td {
            text-align: center;
        }

        .table > tbody > tr > td.padding-md, .table > thead > tr > th.padding-md {
            padding-left: 16px;
            padding-right: 16px;
        }

        .tz {
            margin-left: 4px;
            color: #888;
            font-size: 60%;
            top: -.7em;
        }

        #loading {
            margin: 20px 0;
            font-size: 16px;
            text-align: center;
        }

        #loading p {
            margin-bottom: 8px;
        }

        strong {
            font-size: 116%;
        }

        #footer p {
            margin-bottom: 0;
        }

        .display-hidden {
            display: none;
        }
    </style>
</head>
<body>
<?php require("./pages/components/navbar.php"); ?>
<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mgdiv">
                    <h3><?php echo L_RECENT_CONTEST;?></h3>
                </div>

                <div id="loading">
                    <p>Loading...</p>
                    <p>If no data loaded, refresh page please</p>
                </div>

                <div>
                    <table id="contests-table" class="table table-striped table-bordered display-hidden">
                        <thead>
                        <tr>
                            <th>OJ</th>
                            <th class="text-left padding-md">Name</th>
                            <th>Start Time</th>
                            <th>Week</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function preZeroFill(num, size) {
        if (num >= Math.pow(10, size)) {
            return num.toString();
        }
        else {
            var str = Array(size + 1).join('0') + num;
            return str.slice(str.length - size);
        }
    }

    function formatTimeStr(t) {
        return t.getFullYear() + '-' + preZeroFill(t.getMonth()+1, 2) + '-' + preZeroFill(t.getDate(), 2) +
            ' ' + preZeroFill(t.getHours(), 2) + ':' + preZeroFill(t.getMinutes(), 2) + ':' + preZeroFill(t.getSeconds(), 2);
    }

    function formatTimeTZ(str, timezone) {
        var t = new Date(str + timezone);
        var tz = parseInt(new Date().getTimezoneOffset()/-60);
        if(tz >= 0) tz = '+' + tz;
        return {
            time: formatTimeStr(t),
            tz: tz,
        }
    }

    $(function () {
        var timestamp = new Date().getTime();
        $.ajax({
            url: 'http://witacm.com/recent-contest.json',
	    dataType : 'json',
            success: function (res) {
                var json = res;
                json.forEach(function (contest) {
                    var tbody = $('#contests-table').find('tbody');
                    tbody.append('<tr></tr>');
                    var tr = tbody.find('tr:last');
                    tr.append('<td></td>');
                    tr.find('td:last').text(contest['oj']);
                    tr.append('<td class="text-left padding-md"><a target="_blank"></a></td>');
                    tr.find('td:last a').text(contest['name']);
                    tr.find('td:last a').attr('href', contest['link']);
                    var starTime = formatTimeTZ(contest['start_time'], '+8');
                    tr.append('<td><span class="start_time"></span><sup class="tz"></sup></td>');
                    tr.find('td:last .start_time').text(starTime['time']);
                    tr.find('td:last .tz').text('UTC' + starTime['tz']);
                    tr.append('<td></td>');
                    tr.find('td:last').text(contest['week']);
                    var startTime = new Date(contest['start_time'].replace(/-/g, '/'));
                    var nowTime = new Date();
                    var secs = (startTime - nowTime) / 1000;
                    if(secs <= 0) {
                        tr.addClass('danger');
                    }
                    else if(Math.floor(secs / 3600 / 24) < 3) {
                        tr.addClass('info');
                    }
                });
                $('#loading').animate({opacity: 'hide'}, 0);
                $('#contests-table').animate({opacity: 'show'}, 250);
                $('#footer').animate({opacity: 'show'}, 250);
            }
        });
    });
</script>
<?php require("./pages/components/footer.php"); ?>
</body>
</html>
