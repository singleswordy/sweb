(function($){

    $(document).ready(function(){
        // 加载用户图片
        loadImg( $('.pn-info-header .pn-img') );
        // 加载文章
        $('.publish-img').each(function(){
            loadImg( $(this) );
        });

        var chartData = $('#trend_data').val();
        // var chartYticks = $('#trend_yticks').val();

        if ( !chartData  ) {
            $('#trend-chart').html('图表数据加载失败！');
        } else {
            chartData = $.parseJSON(chartData);
            // chartYticks = $.parseJSON(chartYticks);
        }

        $.plot("#trend-chart", [{
            data: chartData
        }],{
            grid:{
                borderColor:'#39BCEC',
                borderWidth:{
                    top:0,
                    right:0,
                    bottom:2,
                    left:2
                },
                minBorderMargin:5,
                color:'white'
            },
            series:{
                lines: { show: true ,lineWidth:2},
                points: { show: true,radius:6 },
                color:'#FC862F'
            },
            xaxis:{
                mode: "time",
                //ticks:xticks,
                tickFormatter:function (val, axis) {
                    var d = new Date(val);
                    var timeStr = (d.getYear()).toString().substring(1,3) + "-" + (d.getMonth() + 1) + "-"  + d.getDate() ;
                    return '<span style="color:#757677;margin-left:-60px;">' + timeStr + '</span>';
                }
            },
            yaxis:{
                //ticks: chartYticks,
                tickDecimals:0,
                tickFormatter:function(v,a){
                    v = parseFloat(v).toLocaleString();
                    return '<span style="color:#39BCEC;">' + v + '</span>';},
                tickColor:'#C9CACB'
            }
        });


    });

})(jQuery);