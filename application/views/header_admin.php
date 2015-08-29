<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
    <link rel="stylesheet" href="../static/css/common.css">

    <link rel="stylesheet" href="../static/css/list.css">

    <script type="text/javascript" src="../static/js/jquery.min.js"></script>
    <script type="text/javascript" src="../static/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../static/js/common.js"></script>
    <script type="text/javascript" src="../static/js/referrer-killer.js"></script>
    
</head>
<body>

<!-- 顶部 -->
<div id="header">
    <div id="header-banner" style="">
        <!--  -->
        <div class="wrapper cf">
            <?php if( $this->session->userdata('admin_user') != false){?>
                <div class="pull-right banner-link"><a href="<?php echo site_url('adminlogout');?>">退出</a></div>
                <div class="pull-right banner-link ml10 mr10">|</div>
                <div class="pull-right banner-link"><?php echo $this->session->userdata('admin_user');?></div>
            <?php }else{?>
                <div class="pull-right banner-link"><a href="<?php echo site_url('adminlogin');?>">登陆</a></div>
            <?php }?>
        </div>      

    </div>
    <div id="header-logo">
        <div id="header-logo-nav" class="wrapper cf">
            <div class="pull-left mt50 f40" style="width:240px;">
                <a href="#"><img src="../static/image/logo.png"></a>
            </div>
            <div class="pull-left" style="border-left:solid 1px #929395;height:50px;line-height:50px;font-weight:bold;font-size:30px;padding-left:20px;color:#3F413F;margin-top:58px;">
                后台订单系统
            </div>
        </div>
    </div>

</div>