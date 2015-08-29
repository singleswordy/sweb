

$(document).ready(function(){
        

    // $('.get-smscode').click(function(){});


    $('#email').on('blur',function(){
        checkEmail();
        checkEmailIsExist();
    });
    $('#password').on('blur',function(){
        checkPasswd();
    });
    $('#password2').on('blur',function(){
        checkPasswd2();
    });
    $('#entname').on('blur',function(){
        checkEntname();
    });
    // $('#entindustry').on('blur',function(){
    //     checkEntindustry();
    // });
    $('#phoneno').on('blur',function(){
        checkPhoneno();
    });
    $('#linkman').on('blur',function(){
        checkLinkman();
    });
        
});

/**
 * form 提交检查
 */
function checkInput(){
    checkEmail() && checkPasswd() && checkPasswd2() && checkEntname() && /*checkEntindustry() &&*/ checkPhoneno() && checkLinkman() ;
    if( $('dd.tips.tips-err').length > 0 || $('#email').attr('isExist') == 1 ) return false;
    else return true;
}

/**
 * 检查邮箱
 */
function checkEmail(){
    var emailObj = $('#email');
    var regEmail = /^\w+([-+.]\w+)*@\w+([-.]\\w+)*\.\w+([-.]\w+)*$/;
    // 邮箱
    if( !emailObj.val() ){
        _showTips(emailObj,false,'请填写邮箱账号！');
        return false;
    } else  if ( regEmail.test( emailObj.val() ) == false ) {
        _showTips(emailObj,false,'请填写正确格式的邮箱账号！');
        return false;
    } else  if ( regEmail.length > 60 ) {
        _showTips(emailObj,false,'亲，您的邮箱超过60个字符了，您确认有这么长？');
        return false;
    } else {
        _showTips(emailObj,true,'输入正确');
    }
    return true;
}

/**
 * 检查邮箱
 */
function checkEmailIsExist(){
    var emailObj = $('#email');
    $.getJSON( $('base').attr('href') + '/checkexist?e=' + emailObj.val() ,function(data){
        if( data.code == 1) {
            $('#email').attr('isExist',1);
            _showTips(emailObj,false,'您输入的email已被注册！');
        } else {
            $('#email').attr('isExist',0);
        }
    });
}


/**
 * 检查密码
 */
function checkPasswd(){
    var passwordObj = $('#password');
    // var regPhoneNo = /^((\(\d{3}\))|(\d{3}\-))?13\d{9}$/;
    // 邮箱
    if( !passwordObj.val() ){
        _showTips(passwordObj,false,'请填写密码！');
        return false;
    } else  if ( passwordObj.val().length < 6 || passwordObj.val().length > 30 ) {
        _showTips(passwordObj,false,'密码须不小于6位，不大于30位！');
        return false;
    } else {
        _showTips(passwordObj,true,'输入正确');
    }
    return true;
}

/**
 * 检查密码
 */
function checkPasswd2(){
    var passwordObj = $('#password'),
        passwordObj2 = $('#password2');
    // var regPhoneNo = /^((\(\d{3}\))|(\d{3}\-))?13\d{9}$/;
    // 邮箱
    if( !passwordObj2.val() ){
        _showTips(passwordObj2,false,'请填写确认密码！');
        return false;
    } else  if ( passwordObj2.val().length < 6 || passwordObj2.val().length > 30 ) {
        _showTips(passwordObj2,false,'密码须不小于6位，不大于30位！');
        return false;
    } else if( passwordObj.val() != passwordObj2.val()){
        _showTips(passwordObj2,false,'密码和确认密码必须相同！');
        return false;
    } else {
        _showTips(passwordObj2,true,'输入正确');
    }
    return true;
}

/**
 * 检查企业名称
 */
function checkEntname(){
    var entnameObj = $('#entname');
    // var regPhoneNo = /^((\(\d{3}\))|(\d{3}\-))?13\d{9}$/;
    // 邮箱
    if( !entnameObj.val() ){
        _showTips(entnameObj,false,'请填写企业名称！');
        return false;
    } else  if ( entnameObj.val().length > 60 ) {
        _showTips(entnameObj,false,'企业名称不能超过60个字符！');
        return false;
    } else {
        _showTips(entnameObj,true,'输入正确');
    }
    return true;
}


/**
 * 检查企业行业
 */
function checkEntindustry(){
    var entindustryObj = $('#entindustry');
    // var regPhoneNo = /^((\(\d{3}\))|(\d{3}\-))?13\d{9}$/;
    // 邮箱
    if( !entindustryObj.val() ){
        _showTips(entindustryObj,false,'请填写企业所属行业！');
        return false;
    } else  if ( entindustryObj.val().length > 60 ) {
        _showTips(entindustryObj,false,'企业所属行业不能超过60个字符！');
        return false;
    } else {
        _showTips(entindustryObj,true,'输入正确');
    }
    return true;
}

/**
 * 检查手机号码
 */
function checkPhoneno(){
    var phonenoObj = $('#phoneno');
    var regPhoneNo = /^(0|86)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/;
    // 邮箱
    if( !phonenoObj.val() ){
        _showTips(phonenoObj,false,'请填写联系手机号！');
        return false;
    } else  if ( regPhoneNo.test( phonenoObj.val() ) == false ) {
        _showTips(phonenoObj,false,'联系手机号格式不正确！');
        return false;
    } else {
        _showTips(phonenoObj,true,'输入正确');
    }
    return true;
}


/**
 * 检查联系人
 */
function checkLinkman(){
    var linkmanObj = $('#linkman');
    // 邮箱
    if( !linkmanObj.val() ){
        _showTips(linkmanObj,false,'请填写联系人！');
        return false;
    } else  if ( linkmanObj.val().length > 30 ) {
        _showTips(linkmanObj,false,'联系人不能超过30个字符！');
        return false;
    } else {
        _showTips(linkmanObj,true,'输入正确');
    }
    return true;
}

/**
 * 显示错误信息
 */
function _showTips( $obj,isOk,tipsCnt){
    $obj.parent('dd').next('dd.tips').html(tipsCnt);
    if (isOk) { 
        $obj.parent('dd').next('dd.tips').removeClass('tips-err').addClass('tips-ok'); 
    } else {
        $obj.parent('dd').next('dd.tips').removeClass('tips-ok').addClass('tips-err');
    }
}



