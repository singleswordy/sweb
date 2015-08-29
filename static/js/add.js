(function($){

    $(document).ready(function(){
        // 加载用户图片
        if ($('.main-left').length > 0) {
            loadImg( $('.pn-info-header .pn-img') );
            var chartData = $('#trend_data').val();
            if ( !chartData  ) {
                $('#trend-chart').html('图表数据加载失败！');
            } else {
                chartData = $.parseJSON(chartData);
            }

            // 图表
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
        };

        

        // 点击类型刷新价格
        $('.adv-extratype-input-cont button').click(function(){
            $(this).addClass('selected').siblings().removeClass('selected');
            refreshEstiPrice();
        });

        // 点击粉丝数刷新价格
        $('#fans-range-select').change(function(){
            refreshEstiPrice();
        });

        // 期望时间
        $('#expect-time').datepicker({
            format: "yyyy-mm-dd",
            startDate: $('#expect-min-date').val(),
            language: "zh-CN",
            autoclose: true
        });

        // 先生成预估价格
        refreshEstiPrice();

        // 点击提交
        $('#submit').click(function(){
            var params = {
                pn_id : $('#pn_id').val(),
                // adv_classify : $('#adv-type').val(),//广告类型：电商，推广
                adv_type : $('.adv-extratype-input-cont button.selected').attr('val'),// 软广硬广
                adv_pos : $('input[name="adv-location"]').val(),
                fans_count : $('#fans-range-select').val(),
                ent_name : $('#ent-name').val(),
                title : $('#adv-title').val(),
                link_man : $('#link-man').val(),
                link_info : $('#link-info').val(),
                expect_time : $('#expect-time').val(),
                remark : $('#remark').val()
            };

            // 

            if (!params.adv_pos) {
                alert('请选择广告文位置！');
                return false;
            };
            // if (!params.adv_classify) {
            //     alert('请填写广告类型！');
            //     return false;
            // };
            if (!params.title) {
                alert('请填写广告标题！');
                return false;
            };
            if (!params.ent_name) {
                alert('请填写企业名称！');
                return false;
            };
            if (!params.link_man) {
                alert('请填写合作联系人！');
                return false;
            };
            if (!params.link_info) {
                alert('请填写合作联系方式！');
                return false;
            };
            
            $.ajax({
                type: 'GET',
                url: $('base').attr('href') + 'doadd',
                data: params,
                success: function(data){
                    if (data.code == 0) {
                        alert('提交成功！请耐心等待工作人员和您联系！');
                        window.location.reload();
                    } else if(data.code == 99){
                        alert(data.message);
                        window.location.href = $('base').attr('href') + 'login';
                    } else{
                        alert('提交失败！请联系管理员');
                    }
                },
                error:function(data){
                    alert('提交失败！请联系管理员');
                },
                dataType: 'JSON'
            });
        });


    });


    // 刷新价格
    function refreshEstiPrice(){
        var priceText = '';
        // 倍率
        var rate = $('.adv-extratype-input-cont button.selected').attr('price');
        // range
        var fansRange = $('#fans-range-select').val();
        var min = $('#fans-range-select > option[value="' + fansRange + '"]').attr('min');
        var max = $('#fans-range-select > option[value="' + fansRange + '"]').attr('max');
        if ( min && !max) {
            priceText = (rate * min) + '万元';
        } else if( !min && max){
            priceText = (rate * max) + '万元';
        } else {
            priceText = (rate * min) + '万元 - ' + (rate * max) + '万元';
        }
        $('.esti-price').text(priceText);
    }


})(jQuery);