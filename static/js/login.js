

$(document).ready(function(){
        
    if( $('#login-message').val()){
        alert($('#login-message').val());
    }

    loadCaptcha();

    $('#show-captcha,#change-captcha').click(function(){
        loadCaptcha();
    })
        
});

/**
 * 重新获取验证码
 */
function loadCaptcha(){
    $('#show-captcha').load($('base').attr('href') + '/captcha?t=' + new Date().getTime(),function(){});
}

/**
 * form 提交检查
 */
function checkInput(){

    var username = $('#username').val();
    var password = $('#password').val();
    $('#issave').val($('#saveusername:checked').length);
    var checkcode = $('#captcha').val();
    if ( !username ) {
        alert('请输入用户名！');
        return false;
    };
    if ( !password ) {
        alert('请输入密码！');
        return false;
    };
    if ( !checkcode ) {
        alert('请输入验证码！');
        return false;
    };
    return true;
}



