<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>管理员登陆－－乐天新媒体平台</title>
    <base href="<?php echo base_url(); ?>"></base>

    <link rel="stylesheet" href="../static/css/bootstrap.min.css">
    <link rel="stylesheet" href="../static/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="../static/css/base.css">
    <link rel="stylesheet" href="../static/css/login.css">

    <script type="text/javascript" src="../static/js/jquery.min.js"></script>
    <script type="text/javascript" src="../static/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../static/js/login.js"></script>
</head>
<body>

<!-- 后台标题 -->
<div class="wrapper pr">
    <div class="pa"  style="border-left:solid 1px #FCFDFD;height:50px;line-height:50px;font-weight:bold;font-size:30px;padding-left:20px;color:#FCFDFD;margin-top:58px;left:180px;">后台订单系统</div>
</div>

<!-- 主体 -->
<div id="main">
    <div class="wrapper">
        <input type="hidden" id="login-message" value="<?php echo $login_msg;?>"/>
        <?php echo form_open('doadminlogin',array('id'=>'login-form','onsubmit'=> 'return checkInput();')) ?>
        
        <div class="login-cont">
            <dl class="cf">
                <dt class="pull-left">管理员:</dt>
                <dd class="pull-left"><input type="text" id="username" name="username" value="<?php echo $username;?>" length="30"/></dd>
            </dl>
            <dl class="cf">
                <dt class="pull-left">密码:</dt>
                <dd class="pull-left"><input type="password" id="password" name="password" value="" length="30"/></dd>
            </dl>
            <div class="input-item-cont">
                <span class="tips-gray">请输入图中的验证码！</span>
            </div>
            <div class="input-item-cont">
                <input type="text" id="captcha" name="captcha" value=""/>
                <div class="inblo" id="show-captcha"></div>
                <span class="tips-link" id="change-captcha">换一张</span>
            </div>
            <div class="input-item-cont input-item-saveun-cont cf">
                <label class="pull-left" >
                    <input type="checkbox" id="saveusername" name="saveusername" value="" <?php echo empty( $_COOKIE['adminusername']) ? '' : 'checked="checked"';?>/>
                    <input type="hidden" id="issave" name="issave" value=""/>
                    <span class="input-label ml5">记住账号</span>
                </label>
                <span class="pull-right tips-link">无法登陆？</span>
            </div>
            <div class="input-item-cont">
                <input class="inblo vm" type="submit" id="submit" value="" />
            </div>
        </div>
        <?php echo form_close() ?>
    </div>
</div>

<!-- 底部 -->
<div id="footer">
    <div class="wrapper">
        <div class="footer-content cf">
            <span class="pull-left">友情链接:</span>
            
            <span class="pull-left current">微信公众广告</span>
            <span class="pull-left">｜</span>
            <span class="pull-left"><a href="http://www.leskymob.com">乐天互动</a></span>
            <span class="pull-left">｜</span>
            <span class="pull-left"><a href="<?php echo site_url('add');?>">合作咨询</a></span>
            <span class="pull-left">｜</span>
            <span class="pull-left"><a href="<?php echo site_url('list');?>">合作公众号</a></span>
            <span class="pull-right none"><a href="http://www.leskymob.com">RSS阅读</a></span>
            <span class="pull-right none">｜</span>
            <span class="pull-right none"><a href="http://www.leskymob.com">网站地图</a></span>
            <span class="pull-right none">｜</span>
            <span class="pull-right none"><a href="http://www.leskymob.com">联系我们</a></span>
            <span class="pull-right none">｜</span>
            <span class="pull-right none"><a href="http://www.leskymob.com">服务条款</a></span>
        </div>
    </div>
</div>

</body>
</html>
