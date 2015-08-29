(function($){

    $(document).ready(function(){
        // 展开/收起详情
        $('.order-open-tips').click(function(){
            if ( $(this).hasClass('order-open-link') ) {
                openDetail( $(this).closest('.order-item-cont') );
            } else {
                closeDetail( $(this).closest('.order-item-cont') );
            }
        });
        // 收起详情
        $('.order-close-tips').click(function(){
            closeDetail( $(this).closest('.order-item-cont') );
        });

        // 修改订单状态
        $('a.order-status-link').click(function(){
            $(this).closest('.btn-group').find('button.order_detail_status').html( $(this).text() ).attr('statusId',$(this).attr('statusId'));
        });

        // 点击提交
        $('.submit-btn-cont button').click(function(){
            var $that = $(this);
            var postData = {
                order_id : $that.closest('.order-item-cont').attr('orderId'),
                status_id : $that.closest('.order-item-cont').find('button.order_detail_status').attr('statusId'),
                remark : $that.closest('.order-item-cont').find('.order_detail_remark').val()
            };
            $.ajax({
                type: 'GET',
                url: $('base').attr('href') + 'uporderstatus',
                data:postData,
                dataType: 'JSON',
                success: function(data){
                    if (data.code == 0) {
                        alert('提交成功！' );
                        window.location.reload();
                    } else if(data.code > 0){
                        alert('更新订单状态失败：' + data.message);
                    } else{
                        alert('系统异常，请联系管理员：' + data.message);
                    }
                },
                error:function(data){
                    alert('系统异常，请联系管理员！');
                }
            });
        });
        

    });

    // 展开订单详情
    function openDetail( $orderDetailObj ){
        
        var orderId = $orderDetailObj.closest('.order-item-cont').attr('orderId');
        var $loadingContainer = $orderDetailObj.find('.order-detail-loading'),
            $openLinkContainer = $orderDetailObj.find('.order-open-tips'),
            $detailContainer = $orderDetailObj.find('.order-detail-cont');

        // 显示loading
        $orderDetailObj.find('.order-detail-loading').html('订单加载中...').show();
        // 加载数据
        $.ajax({
            type: 'GET',
            url: $('base').attr('href') + 'order/' + orderId,
            dataType: 'JSON',
            success: function(data){
                if (data.code == 0) {
                    // 写入数据
                    $detailContainer.find('.order_detail_adv_pos').text(data.data.adv_pos);
                    $detailContainer.find('.order_detail_adv_type').text(data.data.adv_type);
                    $detailContainer.find('.order_detail_adv_contact_man').text(data.data.adv_contact_man);
                    $detailContainer.find('.order_detail_adv_contact_link').text(data.data.adv_contact_link);
                    $detailContainer.find('.order_detail_adv_title').text(data.data.adv_title);
                    $detailContainer.find('.order_detail_adv_remark').text(data.data.adv_remark);
                    $detailContainer.find('.order_detail_remark').text(data.data.remark);
                    $detailContainer.find('.order_detail_status').text(getOrderStatusDesc(data.data.status)).attr('statusId',data.data.status);
                    // 隐藏loading
                    $loadingContainer.empty().hide();
                    // 切换链接样式
                    $openLinkContainer.removeClass('order-open-link');
                    // 显示detail
                    $detailContainer.slideDown(100);
                } else if(data.code > 0){
                    $loadingContainer.html('查询订单失败：' + data.message).css('color','red');
                } else{
                    $loadingContainer.html('系统异常，请联系管理员').css('color','red');
                }
            },
            error:function(data){
                $loadingContainer.html('系统异常，请联系管理员').css('color','red');
            }
        });
    }

    // 收起订单详情
    function closeDetail( $orderDetailObj ){
        $orderDetailObj.find('.order-detail-loading').empty().hide();
        $orderDetailObj.find('.order-open-tips').addClass('order-open-link');
        $orderDetailObj.find('.order-detail-cont').slideUp(100);
    }


    // 获取状态名
    function getOrderStatusDesc ( orderStatusId ) {
        return {
            1:'未联系',
            2:'沟通中',
            3:'合作中',
            4:'完成'
        }[orderStatusId] || '未知类型';
    }


})(jQuery);