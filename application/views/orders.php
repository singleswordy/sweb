<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script type="text/javascript" src="../static/js/orders.js"></script>
<link rel="stylesheet" href="../static/css/orders.css">


<!-- 主体 -->
<div id="main">
    <div class="wrapper cf overtop">
        <div class="main-left pull-left">
            <div class="order-type-header"></div>
            <div class="order-type-main">
                
                <ul class="order-type-list">
                    <!-- 订单分类列表 -->
                    <li class="<?php echo $order_type==1 ? 'current' : '';?>">
                        <div class="inner">
                            <a href="<?php echo base_url('orders/1');?>">
                                <span class="order-type-icon order-type-uncontact"></span>
                                <span>未联系</span>
                            </a>
                        </div>
                    </li>
                    <li class="<?php echo $order_type==2 ? 'current' : '';?>">
                        <div class="inner">
                            <a href="<?php echo base_url('orders/2');?>">
                                <span class="order-type-icon order-type-communicating"></span>
                                <span>沟通中</span>
                            </a>
                        </div>
                    </li>
                    <li class="<?php echo $order_type==3 ? 'current' : '';?>">
                        <div class="inner">
                            <a href="<?php echo base_url('orders/3');?>">
                                <span class="order-type-icon order-type-going"></span>
                                <span>合作中</span>
                            </a>
                        </div>
                    </li>
                    <li class="<?php echo $order_type==4 ? 'current' : '';?>">
                        <div class="inner">
                            <a href="<?php echo base_url('orders/4');?>">
                                <span class="order-type-icon order-type-finished"></span>
                                <span>完成</span>
                            </a>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

        <div class="main-right pull-right">
            <!-- 头部标题行 -->
            <div class="order-list-header cf">
                <ul class="order-item-row cf">
                    <li class="order-item-col order-col-label">订单时间</li>
                    <li class="order-item-col order-col-label">订单状态</li>
                    <li class="order-item-col order-col-label">公司名</li>
                    <li class="order-item-col order-col-label">意向公众号</li>
                    <li class="order-item-col order-col-label">期待粉丝数</li>
                    <li class="order-item-col order-col-label">投放时间</li>
                    <li class="order-item-col order-col-label">最后处理人</li>
                    <li class="order-item-col order-col-label"></li>
                </ul>
            </div>

            <!-- 订单条目列表 -->
            <div class="order-list-body">

                <?php foreach ($order_list as $order) { ?>
                    <!-- 订单项目 -->
                    <div class="order-item-cont cf" orderId="<?php echo $order['order_id'];?>">
                        <!-- 订单概要 -->
                        <ul class="order-item-row cf">
                            <li class="order-item-col"><?php echo $order['order_time'];?></li>
                            <li class="order-item-col"><?php echo $order['order_status'];?></li>
                            <li class="order-item-col"><?php echo $order['order_company'];?></li>
                            <li class="order-item-col"><?php echo $order['order_pn_name'];?></li>
                            <li class="order-item-col"><?php echo $order['order_exp_fanscnt'];?></li>
                            <li class="order-item-col"><?php echo $order['order_exp_time'];?></li>
                            <li class="order-item-col"><?php echo $order['order_last_owner'];?></li>
                            <li class="order-item-col order-open-tips order-open-link">
                                <span class="inblo vm order-detail-open-icon"></span>
                                <span class="inblo vm">订单明细</span>
                                <span class="inblo vm order-detail-open-icon"></span>
                            </li>
                        </ul>
                        <!-- 订单明细 loading -->
                        <div class="order-detail-loading none">订单加载中...</div>
                        <!-- 订单明细 -->
                        <div class="order-detail-cont none">
                            <p class="order-detail-label">订单明细：</p>
                            <div class="order-detail-item-cont">
                                <ul class="order-detail-row cf">
                                    <li class="order-detail-col order-col-label">广告位置</li>
                                    <li class="order-detail-col order-col-label">类型</li>
                                    <li class="order-detail-col order-col-label">联系人</li>
                                    <li class="order-detail-col order-col-label">联系方式</li>
                                </ul>
                                <ul class="order-detail-row cf">
                                    <li class="order-detail-col order_detail_adv_pos">...</li>
                                    <li class="order-detail-col order_detail_adv_type">...</li>
                                    <li class="order-detail-col order_detail_adv_contact_man">...</li>
                                    <li class="order-detail-col order_detail_adv_contact_link">...</li>
                                </ul>
                            </div>

                            <p class="order-detail-label">广告标题：</p>
                            <div class="order-detail-item-cont">
                                <p class="order-detail-row order_detail_adv_title">...</p>
                            </div>

                            <p class="order-detail-label">广告主附言：</p>
                            <div class="order-detail-item-cont">
                                <p class="order-detail-row order_detail_adv_remark"></p>
                            </div>

                            <p class="order-detail-label">合作备注：</p>
                            <div class="order-detail-item-cont">
                                <textarea class="order-detail-row order_detail_remark"></textarea>
                            </div>

                            <div class="order-detail-label mb20">
                                <span class="inblo">修改订单状态：</span>
                                <div class="btn-group inblo">
                                  <button type="button" class="btn btn-default order_detail_status" statusId="">...</button>
                                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                  </button>
                                  <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0);" class="order-status-link" statusId="1">未联系</a></li>
                                    <li><a href="javascript:void(0);" class="order-status-link" statusId="2">沟通中</a></li>
                                    <li><a href="javascript:void(0);" class="order-status-link" statusId="3">合作中</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="javascript:void(0);" class="order-status-link" statusId="4">完成</a></li>
                                  </ul>
                                </div>
                            </div>

                            <div class="order-detail-item-cont">
                                <div class="submit-btn-cont">
                                    <button class="btn btn-warning" >提交修改</button>
                                </div>
                                <div class="order-close-tips">
                                    <span class="inblo vm order-detail-closed-icon"></span>
                                    <span class="inblo vm">收起明细页</span>
                                    <span class="inblo vm order-detail-closed-icon"></span>
                                </div>
                            </div>
                        </div><!-- end of order-detail-cont -->
                    </div><!-- end of order-item-cont -->
                    
                <?php } ?>
                <?php if( empty( $order_list ) ){?>
                    <div class="order-list-blank-cont">暂无数据！</div>
                <?php }?>
            </div><!-- end of order-list-body -->

        </div><!-- end of main-right -->
    </div>
</div>
