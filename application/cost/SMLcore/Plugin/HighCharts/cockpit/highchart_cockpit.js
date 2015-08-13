/*
 * version 1.0
 * Phada Woodtikarn edit from ............
 * 19/08/2013
 */
(function($) {
    $.fn.myhighcharts = function(highchart_id, highchart_mainsize) {
        var drawframe;
        var highchart_innersize;
        if (highchart_mainsize > 0 && highchart_mainsize < 200) {
            highchart_mainsize = 180;
            highchart_innersize = highchart_mainsize - 68;
            drawframe = '<div id="mainframehighchart" style="width: ' + highchart_mainsize + 'px;height: ' + highchart_mainsize + 'px;">';
            drawframe += '<div id="mainframehighchartcircle1" style="margin: 19px;margin-top:17px;">';
            drawframe += '<div id="mainframehighchartcircle2" style="margin: 5px;" >';
            drawframe += '<div class="mainframehighchartcircle3" style="margin: 10px;width: ' + highchart_innersize + 'px;height: ' + highchart_innersize + 'px;">';
            drawframe += '<div class="highcharttextframe" style="font-size:10px;width: ' + highchart_innersize + 'px;height: ' + highchart_innersize + 'px;">';
            drawframe += '<span class="highcharttext" style="float: left;top:38%;left:3%">20</span>';
            drawframe += '<span class="highcharttext" style="float: left;top:76%;left:3%">0</span>';
            drawframe += '<span class="highcharttext" style="float: left;top:6%;left:4%">40</span>';
            drawframe += '<span class="highcharttext" style="float: right;top:38%;right:3%">80</span>';
            drawframe += '<span class="highcharttext" style="float: right;top:76%;right:3%">100</span>';
            drawframe += '<span class="highcharttext" style="float: right;top:6%;right:-8%">60</span>';
            drawframe += '</div>';
            drawframe += '</div>';
            drawframe += '</div>';
            drawframe += '</div>';
            drawframe += '<div id="' + highchart_id + '" style="width: ' + highchart_mainsize + 'px;height: ' + highchart_mainsize + 'px;" ></div>';
            drawframe += '</div>';
        }
        ;
        if (highchart_mainsize > 199 && highchart_mainsize < 300) {
            highchart_mainsize = 250;
            highchart_innersize = highchart_mainsize - 80;
            drawframe = '<div id="mainframehighchart" style="width: ' + highchart_mainsize + 'px;height: ' + highchart_mainsize + 'px;">';
            drawframe += '<div id="mainframehighchartcircle1" style="margin: 21px;margin-top: 19px;">';
            drawframe += '<div id="mainframehighchartcircle2" style="margin: 9px;">';
            drawframe += '<div class="mainframehighchartcircle3" style="margin: 10px;width: ' + highchart_innersize + 'px;height: ' + highchart_innersize + 'px;">';
            drawframe += '<div class="highcharttextframe" style="font-size:12px;width: ' + highchart_innersize + 'px;height: ' + highchart_innersize + 'px;">';
            drawframe += '<span class="highcharttext" style="float: left;top:39%;left:2%">20</span>';
            drawframe += '<span class="highcharttext" style="float: left;top:77%;left:5%">0</span>';
            drawframe += '<span class="highcharttext" style="float: left;top:6%;left:10%">40</span>';
            drawframe += '<span class="highcharttext" style="float: right;top:39%;right:2%">80</span>';
            drawframe += '<span class="highcharttext" style="float: right;top:77%;right:5%">100</span>';
            drawframe += '<span class="highcharttext" style="float: right;top:6%;right:1%">60</span>';
            drawframe += '</div>';
            drawframe += '</div>';
            drawframe += '</div>';
            drawframe += '</div>';
            drawframe += '<div id="' + highchart_id + '" style="width: ' + highchart_mainsize + 'px;height: ' + highchart_mainsize + 'px;" ></div>';
            drawframe += '</div>';
        }
        ;
        if (highchart_mainsize > 299 && highchart_mainsize < 400) {
            highchart_mainsize = 350;
            highchart_innersize = highchart_mainsize - 134;
            drawframe = '<div id="mainframehighchart" style="width: ' + highchart_mainsize + 'px;height: ' + highchart_mainsize + 'px;">';
            drawframe += '<div id="mainframehighchartcircle1">';
            drawframe += '<div id="mainframehighchartcircle2">';
            drawframe += '<div class="mainframehighchartcircle3" style="width: ' + highchart_innersize + 'px;height: ' + highchart_innersize + 'px;">';
            drawframe += '<div class="highcharttextframe" style="width: ' + highchart_innersize + 'px;height: ' + highchart_innersize + 'px;">';
            drawframe += '<span class="highcharttext" style="float: left;top:39%;left:2%">20</span>';
            drawframe += '<span class="highcharttext" style="float: left;top:77%;left:6%">0</span>';
            drawframe += '<span class="highcharttext" style="float: left;top:6%;left:12%">40</span>';
            drawframe += '<span class="highcharttext" style="float: right;top:39%;right:2%">80</span>';
            drawframe += '<span class="highcharttext" style="float: right;top:77%;right:6%">100</span>';
            drawframe += '<span class="highcharttext" style="float: right;top:6%;right:3%">60</span>';
            drawframe += '</div>';
            drawframe += '</div>';
            drawframe += '</div>';
            drawframe += '</div>';
            drawframe += '<div id="' + highchart_id + '" style="width: ' + highchart_mainsize + 'px;height: ' + highchart_mainsize + 'px;" ></div>';
            drawframe += '</div>';
        }
        ;
        if (highchart_mainsize > 399) {
            highchart_mainsize = 450;
            highchart_innersize = highchart_mainsize - 150;
            drawframe = '<div id="mainframehighchart" style="width: ' + highchart_mainsize + 'px;height: ' + highchart_mainsize + 'px;">';
            drawframe += '<div id="mainframehighchartcircle1" style="margin: 30px;margin-top:28px;">';
            drawframe += '<div id="mainframehighchartcircle2" style="margin: 15px;" >';
            drawframe += '<div class="mainframehighchartcircle3" style="width: ' + highchart_innersize + 'px;height: ' + highchart_innersize + 'px;">';
            drawframe += '<div class="highcharttextframe" style="width: ' + highchart_innersize + 'px;height: ' + highchart_innersize + 'px;">';
            drawframe += '<span class="highcharttext" style="float: left;top:40%;left:2%">20</span>';
            drawframe += '<span class="highcharttext" style="float: left;top:80%;left:9%">0</span>';
            drawframe += '<span class="highcharttext" style="float: left;top:6%;left:16%">40</span>';
            drawframe += '<span class="highcharttext" style="float: right;top:40%;right:2%">80</span>';
            drawframe += '<span class="highcharttext" style="float: right;top:80%;right:9%">100</span>';
            drawframe += '<span class="highcharttext" style="float: right;top:6%;right:10%">60</span>';
            drawframe += '</div>';
            drawframe += '</div>';
            drawframe += '</div>';
            drawframe += '</div>';
            drawframe += '<div id="' + highchart_id + '" style="width: ' + highchart_mainsize + 'px;height: ' + highchart_mainsize + 'px;" ></div>';
            drawframe += '</div>';
        }
        ;
        $.fn.myhighcharts.gaugeGender = function(data, data_goal, icon_alert, link_alert) {
            var data = parseInt(data);
            var data_goal = parseInt(data_goal);
            var height = 350;
            var width = 350;
            var r = 18;
            var cen = 10;
            var fonts = 22;
            var img = 40;
            var top = 0;
            highchart_mainsize;
            if (highchart_mainsize > 0 && highchart_mainsize < 200) {
                height = 180;
                width = 180;
                r = 11;
                cen = 40;
                fonts = 10;
                img = 15;
                top = 12;
            }
            ;
            if (highchart_mainsize > 199 && highchart_mainsize < 300) {
                height = 250;
                width = 250;
                r = 16;
                cen = 70;
                fonts = 15;
                img = 20;
                top = -12;
            }
            ;

            if (highchart_mainsize > 299 && highchart_mainsize < 400) {
                height = 350;
                width = 350;
                r = 18;
                cen = 100;
                fonts = 22;
                img = 30;
                top = -50;
            }
            ;
            if (highchart_mainsize > 399) {
                height = 450;
                width = 450;
                r = 22;
                cen = 140;
                fonts = 30;
                img = 40;
                top = -65;
            }
            ;
            $('#' + highchart_id).highcharts({
                chart: {
                    type: 'gauge',
                    backgroundColor: 'transparent',
                    height: height,
                    width: width
                },
                title: {
                    text: ''
                },
                pane: {
                    startAngle: -136,
                    endAngle: 136,
                    borderWidth: null,
                    background: [{
                            borderWidth: null,
                            outerRadius: '0%'
                        }]
                },
                // the value axis
                yAxis: {
                    min: 0,
                    max: 100,
                    minorTickWidth: 0,
                    minorTickLength: 10,
                    tickPixelInterval: 0,
                    tickWidth: 5,
                    tickLength: 25,
                    style: {
                        fontSize: '18px',
                        color: '#000000'
                    },
                    labels: {
                        rotation: 'auto',
                        distance: -40,
                        style: {
                            fontSize: '16px',
                        }
                    },
                    title: {
                        text: ''
                    },
                    plotBands: [{// GOAL  ===============
                            from: data_goal - 1.4,
                            to: data_goal + 1.4,
                            zIndex: 5,
                            color: '#FC3003',
                            innerRadius: '108%',
                            outerRadius: '106%'
                        }, {
                            from: data_goal - 1.2,
                            to: data_goal + 1.2,
                            zIndex: 5,
                            color: '#FC3003',
                            innerRadius: '107%',
                            outerRadius: '105%'
                        }, {
                            from: data_goal - 1,
                            to: data_goal + 1,
                            zIndex: 5,
                            color: '#FC3003',
                            innerRadius: '106%',
                            outerRadius: '104%'
                        }, {
                            from: data_goal - 0.8,
                            to: data_goal + 0.8,
                            zIndex: 5,
                            color: '#FC3003',
                            innerRadius: '105%',
                            outerRadius: '103%'
                        }, {
                            from: data_goal - 0.6,
                            to: data_goal + 0.6,
                            zIndex: 5,
                            color: '#FC3003',
                            innerRadius: '104%',
                            outerRadius: '102%'
                        }, {
                            from: data_goal - 0.4,
                            to: data_goal + 0.4,
                            zIndex: 5,
                            color: '#FC3003',
                            innerRadius: '103%',
                            outerRadius: '101%'
                        }, {
                            from: data_goal - 0.2,
                            to: data_goal + 0.2,
                            zIndex: 5,
                            color: '#FC3003',
                            innerRadius: '102%',
                            outerRadius: '100%'
                        }]
                },
                series: [{
                        enabled: true,
                        rotation: 0,
                        name: 'Success',
                        data: [data],
                        dial: {
                            radius: '75%',
                            backgroundColor: 'silver',
                            borderColor: '#555',
                            borderWidth: 1,
                            baseWidth: 14,
                            topWidth: 1,
                            baseLength: '15%', // of radius
                            rearLength: '15%'
                        },
                        pivot: {
                            radius: r,
                            borderWidth: 1,
                            borderColor: 'gray',
                            backgroundColor: {
                                linearGradient: {x1: 0, y1: 0, x2: 1, y2: 1},
                                stops: [
                                    [0, 'white'],
                                    [3, 'gray']
                                ]
                            }
                        },
                        dataLabels: {
                            x: 0,
                            y: cen,
                            borderColor: null,
                            useHTML: true,
                            formatter: function() {
                                //rounds to 2 decimals
                                format_y = ((this.y < 10) ? '00' : ((this.y < 100) ? '0' : '')) + parseFloat(this.y).toFixed(2);
                                formatter_str = '<span style="display:block;position:relative;">';
                                style_str = 'border:#555 1px solid;margin:1px;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;padding:1px;';
                                style_str += 'background: -webkit-linear-gradient(top, #BBB, #FFF); background: -moz-linear-gradient(top, #BBB, #FFF);font-size:' + fonts + 'px;';
                                for (i = 0; i < format_y.length; i++) {
                                    if (format_y[i] != '.') {
                                        formatter_str += '<span style="' + style_str + '">' + format_y[i] + '</span>';
                                    } else {
                                        formatter_str += format_y[i];
                                    }
                                }
                                icon_alert_img = '';
                                if (link_alert != '') {
                                    icon_alert_img = (icon_alert != 0) ? '<a href="' + link_alert + '"  target="_blank"><img src="./Plugin/HighCharts/cockpit/Images/alert_icon.gif" style="width:' + img + 'px;border-style: none"/></a>' : '<img src="./Plugin/HighCharts/cockpit/Images/non_alert.gif" style="width:' + img + 'px;border-style: none"/>';
                                } else {
                                    icon_alert_img = (icon_alert != 0) ? '<a href="' + link_alert + '"  target="_blank"><img src="./Plugin/HighCharts/cockpit/Images/alert_icon.gif" style="width:' + img + 'px;border-style: none"/></a>' : '<img src="./Plugin/HighCharts/cockpit/Images/non_alert.gif" style="width:' + img + 'px;border-style: none"/>';
                                }


                                icon_alert_img = '<span style="width: auto;height: auto;display:inline-block;position:absolute;top:' + top + '%;">' + icon_alert_img + '</span>';
                                formatter_str += '' + icon_alert_img + '</span>';

                                return formatter_str;
                            },
                            style: {
                                fontSize: '18px',
                                color: '#000000'
                            }
                        },
                        tooltip: {
                            valueSuffix: ' %'
                        }
                    }]
            });

        };
        this.html(drawframe);
        return drawframe;
    };

})(jQuery);