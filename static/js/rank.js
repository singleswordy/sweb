(function($){


	$().ready(function(){
        //  点击搜索
        $('#btn-search').click(function(){
            var keywords = $('#keywords').val();
            if ( !keywords) {
                alert('请输入搜索内容！');
            } else if ( keywords.toString().length > 20) { 
                alert('您输入的字符过多，请输入20个以内的字符！');
            } else {
                window.location.href = $('base').attr('href') + 'list/0' + (keywords ? ('?k=' + keywords) : '');
            }
        });
        
        // 切换软广硬广
        $('.adv-extratype-input-cont button').click(function(){
            $(this).addClass("selected").siblings('button').removeClass('selected');
        });

        // 加载图片
        $('.img_span').each(function(){  loadImg($(this)); });

	});

})(jQuery);