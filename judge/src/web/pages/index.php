<?php if (!defined("OJ_INITED")) exit(0); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <?php require_once('./include/common_head.inc.php'); ?>
    <script src="//cdn.witchen.cn/static/js/highcharts.js"></script>
    <script src="//cdn.witchen.cn/static/js/particles.min.js"></script>
    <title><?php echo "{$OJ_NAME}"; ?></title>
</head>
<body>

<div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: -1;">
    <span id="particles-js"></span>
</div>
<?php require("./pages/components/navbar.php"); ?>
<div class="main">
    <div class="container">
        <!--[if lt IE 8]>
        <div class="row">
            <div class="alert alert-warning">
                &nbsp;您的浏览器版本实在是太低了，是时候考虑<a href="https://browsehappy.com/">换一个</a>了。
                <del>&times;</del>
            </div>
        </div>
        <![endif]-->
        <?php
        if (file_exists("./admin/announcement.txt")) {
            $OJ_ANNOUNCEMENT = file_get_contents("./admin/announcement.txt");
            if ($OJ_ANNOUNCEMENT != "" && strlen($OJ_ANNOUNCEMENT) != 0 && $OJ_ANNOUNCEMENT != "<br>") { ?>
                <div class="welcome">
                    <?php echo $OJ_ANNOUNCEMENT; ?>
                </div>
            <?php }
        } ?>
        <div class="row">
            <div id="chart"
                 style="width: 100%; height: 500px; -webkit-tap-highlight-color: transparent; user-select: none; position: relative; background: transparent;">
                Loading Chart...
            </div>
            <!--sidebar removed-->
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        var Accepted = [];
        var WrongAnswer = [];
        var Other = [];
        var DataText = [];

        var chart = new Highcharts.Chart({
            chart: {height: 460, renderTo: 'chart', type: 'column', backgroundColor: 'rgba(0,0,0,0)'},
            title: {text: '<?php echo L_WEEKY_SUBMIT_N_AC;?>'},
            xAxis: {
                categories: [],
                tickmarkPlacement: 'on', title: {enabled: false}
            },
            yAxis: {
                title: {text: 'Submit Count'},
                allowDecimals: false,
                labels: {
                    formatter: function () {
                        return this.value;
                    }
                }
            },
            tooltip: {
                shared: true,
                valueSuffix: ' Submits'
            },
            plotOptions: {
                area: {
                    stacking: 'normal',
                    lineColor: '#666666',
                    lineWidth: 1,
                    marker: {
                        lineWidth: 1, lineColor: '#666666'
                    }
                }
            },
            series: []
        });
        $.ajax({
            type: 'get',
            url: './api/ajax_weekychart.php',
            success: function (data) {
                var json = eval("(" + data + ")");
                json = json['data'];

                for (var key in json) {
                    Accepted.push(json[key][4]);
                    WrongAnswer.push(json[key][6]);
                    Other.push(json[key]['count'] - json[key][4] - json[key][6])
                    DataText.push(json[key]['date'])
                }
                chart.xAxis[0].setCategories(DataText);
                chart.addSeries({
                    name: "<?php echo L_JUDGE_AC;?>",
                    color: "#7fff00",
                    data: Accepted
                }, false);
                chart.addSeries({
                    name: "<?php echo L_JUDGE_WA;?>",
                    color: "#ff5151",
                    data: WrongAnswer
                }, false);
                chart.addSeries({
                    name: "<?php echo L_OTHER;?>",
                    color: "#d0d0d0",
                    data: Other
                }, false);
                chart.redraw();
            },
            error: function (e) {
                chart.setTitle({text: 'Error::Load data failed.'});
            }
        });
    });


    particlesJS("particles-js", {
        "particles": {
            "number": {
                "value": 50,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                //"value": "#D0D0D0"
                "value": "#5Cb85c"
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                },
                "polygon": {
                    "nb_sides": 5
                },
                "image": {
                    "src": "img/github.svg",
                    "width": 100,
                    "height": 100
                }
            },
            "opacity": {
                "value": 0.5,
                "random": false,
                "anim": {
                    "enable": false,
                    "speed": 1,
                    "opacity_min": 0.1,
                    "sync": false
                }
            },
            "size": {
                "value": 3,
                "random": true,
                "anim": {
                    "enable": false,
                    "speed": 40,
                    "size_min": 0.1,
                    "sync": false
                }
            },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#C1C1C1",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 6,
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": {
                    "enable": false,
                    "rotateX": 600,
                    "rotateY": 1200
                }
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": true,
                    "mode": "grab"
                },
                "onclick": {
                    "enable": true,
                    "mode": "push"
                },
                "resize": true
            },
            "modes": {
                "grab": {
                    "distance": 140,
                    "line_linked": {
                        "opacity": 1
                    }
                },
                "bubble": {
                    "distance": 400,
                    "size": 40,
                    "duration": 2,
                    "opacity": 8,
                    "speed": 3
                },
                "repulse": {
                    "distance": 200,
                    "duration": 0.4
                },
                "push": {
                    "particles_nb": 4
                },
                "remove": {
                    "particles_nb": 2
                }
            }
        },
        "retina_detect": true
    });
</script>
<?php require("./pages/components/footer.php"); ?>

</body>
</html>
