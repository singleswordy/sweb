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
    <link rel="stylesheet" href="../static/css/detail.css">
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
            <?php if( $this->session->userdata('username') != false){?>
                <div class="pull-right banner-link"><a href="<?php echo site_url('logout');?>">退出</a></div>
                <div class="pull-right banner-link ml10 mr10">|</div>
                <div class="pull-right banner-link"><?php echo $this->session->userdata('username');?></div>
            <?php }else{?>
                <div class="pull-right banner-link"><a href="<?php echo site_url('register');?>">注册</a></div>
                <div class="pull-right banner-link ml10 mr10">|</div>
                <div class="pull-right banner-link"><a href="<?php echo site_url('login');?>">登陆</a></div>
            <?php }?>
            
        </div>      

    </div>
    <div id="header-logo">
        <div id="header-logo-nav" class="wrapper cf">
            <div class="pull-left mt50 f40">
                <a href="#"><img src="../static/image/logo.png"></a>
            </div>
            <ul class="header-logo-nav-list mt50 pull-left">
                <li class="<?php echo (!empty($cur_nav) && $cur_nav == 'list') ? 'current':'';?> coop-pn">
                    <a href="<?php echo site_url('list');?>">合作公众号</a>
                </li>
                <li class="<?php echo (!empty($cur_nav) && $cur_nav == 'add') ? 'current':'';?> coop-consult">
                    <a href="<?php echo site_url('add');?>">合作咨询</a>
                </li>
                <li class="about-us">
                    <a href="http://www.leskymob.com">关于我们</a>
                </li>
            </ul>
        </div>
    </div>

</div>