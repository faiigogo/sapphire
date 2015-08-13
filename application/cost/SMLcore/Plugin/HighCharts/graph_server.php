<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Graph_Server</title>
        <script src="../../TheirParty/js/jquery-1.10.1.min.js"></script>
        <script src="./highcharts.min.js"></script>
        <script src="./highcharts-more.js"></script>
        <script src="./modules/exporting.js"></script>
        <?php
        if ($_GET["graphstyle"] == "dark-blue.js" || $_GET["graphstyle"] == "dark-green.js" || $_GET["graphstyle"] == "gray.js" || $_GET["graphstyle"] == "grid.js" || $_GET["graphstyle"] == "ksr.js" || $_GET["graphstyle"] == "skies.js") {
            ?>
            <script src="./themes/<?php echo $_GET["graphstyle"]; ?>"></script>
            <?php
        }
        ?>

    </head>
    <!--
    <?php
    //แปลงการเข้ารหัส
    if (isset($_GET["encode"])) {
        $_GET["encode"] = 0;
    }
    if ($_GET["encode"] == 1) {
        $title = $_GET["title"];
        $category = $_GET["category"];
        $data1 = $_GET["data1"];
        $yname = $_GET["yname"];
        $seriesname = $_GET["seriesname"];
    } else {
        $title = iconv("windows-874", "UTF-8", $_GET["title"]);
        $category = iconv("windows-874", "UTF-8", $_GET["category"]);
        $data1 = iconv("windows-874", "UTF-8", $_GET["data1"]);
        $yname = iconv("windows-874", "UTF-8", $_GET["yname"]);
        $seriesname = iconv("windows-874", "UTF-8", $_GET["seriesname"]);
    }
    $cut_seriesname = explode(";", $seriesname);
    $cut_category = explode(";", $category);
    $count_category = count($cut_category);
    $cut_data1 = explode(";", $data1);
    $count_data1 = count($cut_data1);
    ?>
    -->
    <script>
        $(function () {
        var typegraph = getURL("graphtype");
                if (typegraph == "area"){
        $('.container').highcharts({
        chart: {
        type: '<?php echo $_GET["graphtype"] ?>',
                marginRight: 130,
                marginBottom: 25
        },
                title: {
        text: '<?php echo $title ?>',
                x: - 20 //center
        },
                subtitle: {
        text: '<?php echo $_GET["subtitle"] ?>',
                x: - 20
        },
                xAxis: {
        categories: [<?php
    for ($i = 0; $i < $count_category; $i++) {
        if ($i < $count_category - 1) {
            echo "'" . $cut_category[$i] . "'";
            echo ",";
        } else {
            echo "'" . $cut_category[$i] . "'";
        }
    }
    ?>]
        },
                yAxis: {
        title: {
        text: '<?php echo $yname ?>'
        },
                plotLines: [{
        value: 0,
                width: 1,
                color: '#808080'
        }]
        },
                tooltip: {
        valueSuffix: '°C'
        },
                legend: {
        layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: - 10,
                y: 100,
                borderWidth: 0
        },
                series: [<?php
    for ($i = 1; $i <= $_GET["numseries"]; $i++) {
        $arr[$i] = $_GET["data" . $i];
        $cut_data[$i] = explode(";", $_GET["data" . $i]);
        $count_data[$i] = count($cut_data[$i]);
        if ($i < $_GET["numseries"]) {
            ?>
                {
                name: '<?php echo $cut_seriesname[$i - 1]; ?>',
                        data: [<?php
            for ($j = 0; $j < $count_data[$i]; $j++) {
                if ($j < $count_data[$i] - 1) {
                    echo $cut_data[$i][$j];
                    echo ", ";
                } else {
                    echo $cut_data[$i][$j];
                }
            }
            ?>]
                },
        <?php
    } else {
        ?>
                {
                name: '<?php echo $cut_seriesname[$i - 1]; ?>',
                        data: [	<?php
        for ($j = 0; $j < $count_data[$i]; $j++) {
            if ($j < $count_data[$i] - 1) {
                echo $cut_data[$i][$j];
                echo ", ";
            } else {
                echo $cut_data[$i][$j];
            }
        }
        ?>]
                }
        <?php
    }
}
?>]
        });
        }
        else if (typegraph == "bar"){
        $('.container').highcharts({
        chart: {
        type: 'bar'
        },
                title: {
        text: '<?php echo $title ?>'
        },
                subtitle: {
        text: '<?php echo $_GET["subtitle"] ?>'
        },
                xAxis: {
        categories: [<?php
for ($i = 0; $i < $count_category; $i++) {
    if ($i < $count_category - 1) {
        echo "'" . $cut_category[$i] . "'";
        echo ",";
    } else {
        echo "'" . $cut_category[$i] . "'";
    }
}
?>],
                title: {
        text: null
        }
        },
                yAxis: {
        min: 0,
                title: {
        text: '<?php echo $yname ?>',
                align: 'high'
        },
                labels: {
        overflow: 'justify'
        }
        },
                tooltip: {
        valueSuffix: ' millions'
        },
                plotOptions: {
        bar: {
        dataLabels: {
        enabled: true
        }
        }
        },
                legend: {
        layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: - 100,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
        },
                credits: {
        enabled: false
        },
                series: [<?php
for ($i = 1; $i <= $_GET["numseries"]; $i++) {
    $arr[$i] = $_GET["data" . $i];
    $cut_data[$i] = explode(";", $_GET["data" . $i]);
    $count_data[$i] = count($cut_data[$i]);
    if ($i < $_GET["numseries"]) {
        ?>
                {
                name: '<?php echo $cut_seriesname[$i - 1]; ?>',
                        data: [<?php
        for ($j = 0; $j < $count_data[$i]; $j++) {
            if ($j < $count_data[$i] - 1) {
                echo $cut_data[$i][$j];
                echo ", ";
            } else {
                echo $cut_data[$i][$j];
            }
        }
        ?>]
                },
        <?php
    } else {
        ?>
                {
                name: '<?php echo $cut_seriesname[$i - 1]; ?>',
                        data: [	<?php
        for ($j = 0; $j < $count_data[$i]; $j++) {
            if ($j < $count_data[$i] - 1) {
                echo $cut_data[$i][$j];
                echo ", ";
            } else {
                echo $cut_data[$i][$j];
            }
        }
        ?>]
                }
        <?php
    }
}
?>]
        });
        }
        else if (typegraph == "line"){
        $('.container').highcharts({
        chart: {
        type: 'line',
                marginRight: 130,
                marginBottom: 25
        },
                title: {
        text: '<?php echo $title ?>',
                x: - 20 //center
        },
                subtitle: {
        text: '<?php echo $_GET["subtitle"] ?> ',
                x: - 20
        },
                xAxis: {
        categories: [<?php
for ($i = 0; $i < $count_category; $i++) {
    if ($i < $count_category - 1) {
        echo "'" . $cut_category[$i] . "'";
        echo ",";
    } else {
        echo "'" . $cut_category[$i] . "'";
    }
}
?>]
        },
                yAxis: {
        title: {
        text: '<?php echo $yname ?>'
        },
                plotLines: [{
        value: 0,
                width: 1,
                color: '#808080'
        }]
        },
                tooltip: {
        valueSuffix: '°C'
        },
                legend: {
        layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: - 10,
                y: 100,
                borderWidth: 0
        },
                series: [<?php
for ($i = 1; $i <= $_GET["numseries"]; $i++) {
    $arr[$i] = $_GET["data" . $i];
    $cut_data[$i] = explode(";", $_GET["data" . $i]);
    $count_data[$i] = count($cut_data[$i]);
    if ($i < $_GET["numseries"]) {
        ?>
                {
                name: '<?php echo $cut_seriesname[$i - 1]; ?>',
                        data: [<?php
        for ($j = 0; $j < $count_data[$i]; $j++) {
            if ($j < $count_data[$i] - 1) {
                echo $cut_data[$i][$j];
                echo ", ";
            } else {
                echo $cut_data[$i][$j];
            }
        }
        ?>]
                },
        <?php
    } else {
        ?>
                {
                name: '<?php echo $cut_seriesname[$i - 1]; ?>',
                        data: [	<?php
        for ($j = 0; $j < $count_data[$i]; $j++) {
            if ($j < $count_data[$i] - 1) {
                echo $cut_data[$i][$j];
                echo ", ";
            } else {
                echo $cut_data[$i][$j];
            }
        }
        ?>]
                }
        <?php
    }
}
?>]
        });
        }
        else if (typegraph == "bubble"){

        $('.container').highcharts({

        chart: {
        type: 'bubble',
                zoomType: 'xy'
        },
                title: {
        text: '<?php echo $title ?>'
        },
                series: [<?php
for ($i = 1; $i <= $_GET["numseries"]; $i++) {
    $arr[$i] = $_GET["data" . $i];
    $cut_data[$i] = explode(";", $_GET["data" . $i]);
    $count_data[$i] = count($cut_data[$i]);
    if ($i < $_GET["numseries"]) {
        ?>
                {
                data: [<?php
        for ($j = 0; $j < $count_data[$i]; $j++) {
            if ($j < $count_data[$i] - 1) {
                echo "[" . $cut_data[$i][$j] . "],";
            } else {
                echo "[" . $cut_data[$i][$j] . "]";
            }
        }
        ?>]
                },
        <?php
    } else {
        ?>
                {

                data: [	<?php
        for ($j = 0; $j < $count_data[$i]; $j++) {
            if ($j < $count_data[$i] - 1) {
                echo "[" . $cut_data[$i][$j] . "],";
            } else {
                echo "[" . $cut_data[$i][$j] . "]";
            }
        }
        ?>]
                }
        <?php
    }
}
?>]

        });
        }
        else if (typegraph == "column"){

        $('.container').highcharts({
        chart: {
        type: 'column'
        },
                title: {
        text: '<?php echo $title ?>'
        },
                subtitle: {
        text: 'Source: WorldClimate.com'
        },
                xAxis: {
        categories: [<?php
for ($i = 0; $i < $count_category; $i++) {
    if ($i < $count_category - 1) {
        echo "'" . $cut_category[$i] . "'";
        echo ",";
    } else {
        echo "'" . $cut_category[$i] . "'";
    }
}
?>
        ]
        },
                yAxis: {
        min: 0,
                title: {
        text: '<?php echo $yname ?>'
        }
        },
                tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
        },
                plotOptions: {
        column: {
        pointPadding: 0.2,
                borderWidth: 0
        }
        },
                series: [<?php
for ($i = 1; $i <= $_GET["numseries"]; $i++) {
    $arr[$i] = $_GET["data" . $i];
    $cut_data[$i] = explode(";", $_GET["data" . $i]);
    $count_data[$i] = count($cut_data[$i]);
    if ($i < $_GET["numseries"]) {
        ?>
                {
                name: '<?php echo $cut_seriesname[$i - 1]; ?>',
                        data: [<?php
        for ($j = 0; $j < $count_data[$i]; $j++) {
            if ($j < $count_data[$i] - 1) {
                echo $cut_data[$i][$j];
                echo ", ";
            } else {
                echo $cut_data[$i][$j];
            }
        }
        ?>]
                },
        <?php
    } else {
        ?>
                {
                name: '<?php echo $cut_seriesname[$i - 1]; ?>',
                        data: [	<?php
        for ($j = 0; $j < $count_data[$i]; $j++) {
            if ($j < $count_data[$i] - 1) {
                echo $cut_data[$i][$j];
                echo ", ";
            } else {
                echo $cut_data[$i][$j];
            }
        }
        ?>]
                }
        <?php
    }
}
?>]
        });
        }
        else if (typegraph == "pie"){
        $('.container').highcharts({
        chart: {
        plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
        },
                title: {
        text: '<?php echo $title ?>'
        },
                tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
                plotOptions: {
        pie: {
        allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
        enabled: true,
                color: '#000000',
                connectorColor: '#000000',
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
        }
        }
        },
                series: [{
        type: 'pie',
                name: 'percent',
                data: [
<?php
for ($i = 0; $i < $count_category; $i++) {
    if ($i < $count_category - 1) {
        echo "['" . $cut_category[$i] . "'";
        echo ", " . $cut_data1[$i] . "],";
    } else {
        echo "['" . $cut_category[$i] . "'";
        echo ", " . $cut_data1[$i] . "]";
    }
}
?>
        ]
        }]
        });
        }
        else if (typegraph == "donut"){
        var colors = Highcharts.getOptions().colors,
                categories = [<?php
for ($i = 0; $i < $count_category; $i++) {
    if ($i < $count_category - 1) {
        echo "'" . $cut_category[$i] . "'";
        echo ",";
    } else {
        echo "'" . $cut_category[$i] . "'";
    }
}
?>],
                name = 'Browser brands',
                data = [<?php
for ($i = 0; $i < $count_category; $i++) {
    ?>
            {

            color: colors[<?php echo $i ?>],
                    drilldown: {
            name: 'Firefox versions',
                    categories: ['<?php echo $cut_category[$i] ?>'],
                    data: [<?php echo $cut_data1[$i] ?>],
                    color: colors[<?php echo $i ?>]
            }
            },
    <?php
}
?>   ];
                // Build the data arrays
                var browserData = [];
                var versionsData = [];
                for (var i = 0; i < data.length; i++) {

        // add browser data
        browserData.push({
        name: categories[i],
                y: data[i].y,
                color: data[i].color
        });
                // add version data
                for (var j = 0; j < data[i].drilldown.data.length; j++) {
        var brightness = 0.2 - (j / data[i].drilldown.data.length) / 5;
                versionsData.push({
        name: data[i].drilldown.categories[j],
                y: data[i].drilldown.data[j],
                color: Highcharts.Color(data[i].color).brighten(brightness).get()
        });
        }
        }

        // Create the chart
        $('.container').highcharts({
        chart: {
        type: 'pie'
        },
                title: {
        text: '<?php echo $title ?>'
        },
                yAxis: {
        title: {
        text: '<?php echo $yname ?>'
        }
        },
                plotOptions: {
        pie: {
        shadow: false,
                center: ['50%', '50%']
        }
        },
                tooltip: {
        valueSuffix: '%'
        },
                series: [{
        name: 'Browsers',
                data: browserData,
                size: '60%',
                dataLabels: {
        formatter: function() {
        return this.y > 5 ? this.point.name : null;
        },
                color: 'white',
                distance: - 30
        }
        }, {
        name: 'Percen',
                data: versionsData,
                size: '80%',
                innerSize: '60%',
                dataLabels: {
        formatter: function() {
        // display only if larger than 1
        return this.y > 1 ? '<b>' + this.point.name + ':</b> ' + this.y   : null;
        }
        }
        }]
        });
        }
        else if (typegraph == "radar"){
        $('.container').highcharts({

        chart: {
        polar: true,
                type: 'line'
        },
                title: {
        text: '<?php echo $title ?>',
                x: - 80
        },
                pane: {
        size: '80%'
        },
                xAxis: {
        categories: [<?php
for ($i = 0; $i < $count_category; $i++) {
    if ($i < $count_category - 1) {
        echo "'" . $cut_category[$i] . "'";
        echo ",";
    } else {
        echo "'" . $cut_category[$i] . "'";
    }
}
?>],
                tickmarkPlacement: 'on',
                lineWidth: 0
        },
                yAxis: {
        gridLineInterpolation: 'circle',
                lineWidth: 0,
                min: 0
        },
                tooltip: {
        shared: true,
                pointFormat: '<span style="color:{series.color}">{series.name}: <b>${point.y:,.0f}</b><br/>'
        },
                legend: {
        align: 'right',
                verticalAlign: 'top',
                y: 100,
                layout: 'vertical'
        },
                series: [<?php
for ($i = 1; $i <= $_GET["numseries"]; $i++) {
    $arr[$i] = $_GET["data" . $i];
    $cut_data[$i] = explode(";", $_GET["data" . $i]);
    $count_data[$i] = count($cut_data[$i]);
    if ($i < $_GET["numseries"]) {
        ?>
                {
                name: '<?php echo $cut_seriesname[$i - 1]; ?>',
                        data: [<?php
        for ($j = 0; $j < $count_data[$i]; $j++) {
            if ($j < $count_data[$i] - 1) {
                echo $cut_data[$i][$j];
                echo ", ";
            } else {
                echo $cut_data[$i][$j];
            }
        }
        ?>], pointPlacement: 'on'
                },
        <?php
    } else {
        ?>
                {
                name: '<?php echo $cut_seriesname[$i - 1]; ?>',
                        data: [	<?php
        for ($j = 0; $j < $count_data[$i]; $j++) {
            if ($j < $count_data[$i] - 1) {
                echo $cut_data[$i][$j];
                echo ", ";
            } else {
                echo $cut_data[$i][$j];
            }
        }
        ?>],
                        pointPlacement: 'on'
                }
        <?php
    }
}
?>]

        });
        }
        else if (typegraph == "xy"){
        $('.container').highcharts({
        chart: {
        type: 'spline'
        },
                title: {
        text: '<?php echo $title ?>'
        },
                subtitle: {
        text: '<?php echo $_GET["subtitle"] ?>'
        },
                xAxis: {
        categories: [<?php
for ($i = 0; $i < $count_category; $i++) {
    if ($i < $count_category - 1) {
        echo "'" . $cut_category[$i] . "'";
        echo ",";
    } else {
        echo "'" . $cut_category[$i] . "'";
    }
}
?>]
        },
                yAxis: {
        title: {
        text: '<?php echo $yname ?>'
        },
                labels: {
        formatter: function() {
        return this.value
        }
        }
        },
                tooltip: {
        crosshairs: true,
                shared: true
        },
                plotOptions: {
        spline: {
        marker: {
        radius: 4,
                lineColor: '#666666',
                lineWidth: 1
        }
        }
        },
                series: [
<?php
for ($i = 1; $i <= $_GET["numseries"]; $i++) {
    $arr[$i] = $_GET["data" . $i];
    $cut_data[$i] = explode(";", $_GET["data" . $i]);
    $count_data[$i] = count($cut_data[$i]);
    if ($i < $_GET["numseries"]) {
        ?>
                {
                name: '<?php echo $cut_seriesname[$i - 1]; ?>',
                        marker: {
                symbol: 'square'
                },
                        data: [<?php
        for ($j = 0; $j < $count_data[$i]; $j++) {
            if ($j < $count_data[$i] - 1) {
                echo $cut_data[$i][$j];
                echo ", ";
            } else {
                echo $cut_data[$i][$j];
            }
        }
        ?>]
                },
        <?php
    } else {
        ?>
                {
                name: '<?php echo $cut_seriesname[$i - 1]; ?>',
                        marker: {
                symbol: 'square'
                },
                        data: [	<?php
        for ($j = 0; $j < $count_data[$i]; $j++) {
            if ($j < $count_data[$i] - 1) {
                echo $cut_data[$i][$j];
                echo ", ";
            } else {
                echo $cut_data[$i][$j];
            }
        }
        ?>]
                }
        <?php
    }
}
?>]
        });
        }
        });</script>

    <script>
                function getURL(objN){
                if (objN == null){
                return window.location.href;
                } else{
                objN = objN.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
                        var regexS = "[\\?&]" + objN + "=([^&#]*)";
                        var regex = new RegExp(regexS);
                        var results = regex.exec(window.location.href);
                        if (results == null)
                        return "";
                        else
                        return results[1];
                }
                }

    </script>

    <body>
        <div class="container"></div>
        <iframe src="http://wiki.sapphire.co.th/MonitoringLibrary2.php?libname=GraphServerV1P0&url=<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']; ?>" height="0" width="0" style=" display: none" ></iframe>
    </body>
</html>