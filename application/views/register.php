<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>乐天新媒体平台</title>
    <base href="<?php echo base_url(); ?>"></base>

    <link rel="stylesheet" href="../static/css/bootstrap.min.css">
    <link rel="stylesheet" href="../static/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="../static/css/base.css">
    <link rel="stylesheet" href="../static/css/register.css">

    <link rel="stylesheet" href="../static/css/detail.css">
    <script type="text/javascript" src="../static/js/jquery.min.js"></script>
    <script type="text/javascript" src="../static/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../static/js/register.js"></script>
</head>
<body>

<!-- 顶部 -->
<div id="header">
    <div id="header-banner">
        <!--  -->
        <div class="wrapper cf">
            <div class="pull-left blank-logo" ></div>
            <div class="pull-right banner-link" ><a href="<?php echo site_url('list');?>">合作公众号</a></div>
            <div class="pull-right banner-division">|</div>
            <div class="pull-right banner-link"><a href="<?php echo site_url('add');?>">合作咨询</a></div>
            <div class="pull-right banner-division">|</div>
            <div class="pull-right banner-link current"><a href="http://www.leskymob.com">关于我们</a></div>
        </div>      

    </div>

</div>


<!-- 主体 -->
<div id="main">
    <div class="wrapper">

        <?php if($reg_status === 2) {?>
            <!-- step3 -->
            <div class="reg-step-cont reg-step3-cont">
                <div class="reg-step-header"></div>
                <div class="reg-step-content">
                    <div class="reg-step3">
                        <p class="verify-ok">恭喜，您的邮箱已验证成功！</p>
                        <p>您的账号已开通，请<a style="color:#CA5229;" href="<?php echo site_url('login');?>">点此登陆</a>。为顺利拿到奖励，请尽快完善基本资料！</p>
                    </div>
                </div>
            </div>
        <?php } elseif($reg_status === 1) {?>
            <!-- step2 -->
            <div class="reg-step-cont reg-step2-cont">
                <div class="reg-step-header"></div>
                <div class="reg-step-content">
                    <div class="reg-step2-top">
                        <p class="pt5">激活邮件已发至：<span><? echo empty($to_email) ? $this->session->userdata('username') : $to_email;?></span></p>
                        <p>请在24小时内登陆您的邮箱，按照邮件中的提示激活账号</p>
                    </div>                   
                    <div class="reg-step2-bottom">
                        <p>如果您没有收到激活邮件，可以尝试以下方法：</p>
                        <p>查看您邮件的垃圾箱，是否有被误认为是垃圾邮件的激活邮件</p>
                        <p>如果您一直收不到，可以<a href=""><span>点这里</span></a>再次发送激活邮件</p>
                    </div>                   
                </div>
            </div>
        <?php } else {?>
            <!-- step1 -->
            <div class="reg-step-cont reg-step1-cont">
                <div class="reg-step-header "></div>
                <?php echo form_open('doregister',array('id'=>'register-form','onsubmit'=> 'return checkInput();')) ?>
                <div class="reg-step-content">
                    <!-- 邮箱 -->
                    <dl class="email-cont">
                        <dt>邮箱账号<span class="must">*</span></dt>
                        <dd class="input-cont"><input type="text" id="email" name="email" value="" isExist="0"></dd>
                        <dd class="tips "></dd>
                    </dl>

                    <!-- 密码 -->
                    <dl class="passwd-cont">
                        <dt>密&nbsp;&nbsp;&nbsp;码<span class="must">*</span></dt>
                        <dd class="input-cont"><input type="password" id="password" name="password" value=""></dd>
                        <dd class="tips "></dd>
                    </dl>

                    <!-- 确认密码 -->
                    <dl class="passwd-cont">
                        <dt>确认密码<span class="must">*</span></dt>
                        <dd class="input-cont"><input type="password" id="password2" name="password2" value=""></dd>
                        <dd class="tips "></dd>
                    </dl>

                    <!-- 企业名称 -->
                    <dl class="entname-cont">
                        <dt>企业名称<span class="must">*</span></dt>
                        <dd class="input-cont"><input type="text" id="entname" name="entname" value=""></dd>
                        <dd class="tips"></dd>
                    </dl>

                    <!-- 企业所在行业 -->
                    <dl class="entindustry-cont none">
                        <dt>企业所在行业<span class="must">*</span></dt>
                        <dd class="input-cont"><input type="text" id="entindustry" name="entindustry" value=""></dd>
                        <dd class="tips"></dd>
                    </dl>

                    <!-- 联系手机号-->
                    <dl class="phoneno-cont">
                        <dt>联系手机号<span class="must">*</span></dt>
                        <dd class="input-cont"><input type="text" id="phoneno" name="phoneno" value=""></dd>
                        <dd class="tips"></dd>
                    </dl>

                    <!-- 短信验证码 -->
                    <!-- <dl class="smscode-cont">
                        <dt>短信验证码<span class="must">*</span></dt>
                        <dd class="input-cont">
                            <input type="text" id="smscode" name="smscode" value="">
                            <span class="phone-icon"></span>
                            <span class="get-smscode">获取验证码</span>
                        </dd>
                        <dd class="tips"></dd>
                    </dl> -->

                    <!-- 联系人 -->
                    <dl class="linkman-cont">
                        <dt>联系人<span class="must">*</span></dt>
                        <dd class="input-cont"><input type="text" id="linkman" name="linkman" value=""></dd>
                        <dd class="tips"></dd>
                    </dl>

                    <!-- 提交 -->
                    <div class="submit-btn-cont">
                        <button type="submit">立即注册</button>
                        <span>已有账号？<a href="<?php echo site_url('login');?>">直接登录</a></span>
                    </div>
                    
                </div>
                <?php echo form_close() ?>
            </div>
        <?php }?>

    </div>
    
</div>

<!-- 底部 -->
<div id="footer">
    <div class="wrapper">
        <div class="footer-content">
            <p>公司名称：深圳市乐天互动科技有限公司   地址：深圳市福田区深南中路2008号华联大厦12楼1218  电话：13427580529</p>
            <p>Powered by KPPW2.6.1 Copyright @ 2009 - 2015 leskymob.com All rights reserved 粤ICP备150287721号－1</p>
        </div>
    </div>
</div>

</body>
</html>
