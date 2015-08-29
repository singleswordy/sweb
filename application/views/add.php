<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../static/js/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="../static/js/jquery.flot.min.js"></script>
<script type="text/javascript" src="../static/js/jquery.flot.time.min.js"></script>
<script type="text/javascript" src="../static/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="../static/js/bootstrap-datepicker.zh-CN.js"></script>
<link rel="stylesheet" href="../static/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="../static/js/add.js"></script>


<!-- 主体 -->
<div id="main">

	<?php if( !empty( $pn_id )){?>
		<input type="hidden" id="trend_data" value="<?php echo $pn_trend_data;?>"/>
		<input type="hidden" id="pn_id" value="<?php echo $pn_id;?>"/>
		<div class="wrapper cf overtop">
			<!-- left -->
			<div class="main-left pull-left">
				<div class="pn-info-header pr">
					<!-- 头像 -->
					<div class="pn-img pa" imgsrc="<?php echo $head_img . '/0'; ?>" imgstyle="width:160px;height:160px;border-radius:80px;"></div>
				</div>
				<div class="pn-info-main">
					<!-- 微信号 -->
					<div class="pn-name-cont">
						<p>
							<span class="pn-cn-name"><?php echo $pn_cn_name;?></span>
						</p>
						<p>
							<span class="pn-id-label">微信号:</span>
							<span class="pn-id"><?php echo $pn_id;?></span>
						</p>
					</div>
					<!-- 二维码 -->
					<div class="pn-qrcode-cont none">
						<div class="pn-qrcode"></div>
					</div>

				</div>
			</div><!-- end of left -->


			<!-- right -->
			<div class="main-right pull-right">
				
				<div class="section title-cont">
					<p class="cf">
						<span class="dtl-label pull-left none">影响力排名:<span class="rank-no"><?php //echo $pn_rank_no;?></span>名</span>
						<span class="adv-btn pull-right none">广告合作</span>
					</p>				
				</div>
				<div class="section desc-cont">
					<p class="description"><?php echo $pn_description;?></p>
				</div>

				<!-- 趋势数值1 -->
				<div class="section trend-num-cont cf">
					<dl class="week-avg-read pull-left">
						<dt>7天平均阅读数</dt>
						<dd>
							<span class="trend-num"><?php echo $pn_trend_num['week_avg_read'];?></span>
							<span class="glyphicon glyphicon-plus"></span>
							<span class="glyphicon glyphicon-triangle-bottom"></span>
						</dd>
					</dl>
					<dl class="week-avg-praise pull-left">
						<dt>7天平均点赞数</dt>
						<dd>
							<span class="trend-num"><?php echo $pn_trend_num['week_avg_praise'];?></span>
							<span class="glyphicon glyphicon-thumbs-up"></span>
							<span class="glyphicon glyphicon-triangle-top"></span>
						</dd>
					</dl>
					<dl class="week-avg-publish pull-left">
						<dt>7天发布文章数</dt>
						<dd>
							<span class="trend-num"><?php echo $pn_trend_num['week_avg_publish'];?></span>
							<span class="glyphicon glyphicon-share"></span>
							<span class="glyphicon glyphicon-triangle-top"></span>
						</dd>
					</dl>
				</div>
				<!-- 趋势数值2 -->
				<div class="section trend-num-cont cf">
					<dl class="valid-fans-count pull-left">
						<dt>有效累计粉丝数</dt>
						<dd>
							<span class="trend-num"><?php echo $pn_trend_num['valid_fans_count'];?></span>
							<span class="glyphicon glyphicon-user"></span>
							<span class="glyphicon glyphicon-triangle-top"></span>
						</dd>
					</dl>
					<dl class="single-adv-value pull-left">
						<dt>单篇广告估值</dt>
						<dd>
							<span class="trend-num"><?php echo $pn_trend_num['single_adv_value'];?></span>
							<span class="glyphicon glyphicon-yen"></span>
							<span class="glyphicon glyphicon-triangle-top"></span>
						</dd>
					</dl>
				</div>

				<!-- 趋势图表 -->
				<div class="section trend-chart-cont">
					<p class="trend-title">阅读走势：</p>
					<div id="trend-chart"></div>
				</div>

			</div><!-- end of right -->

		</div><!-- end of wrapper -->
	<?php }?>



	<div class="wrapper cf <?php if( empty( $pn_id )) echo 'overtop';?>">

		<div class="div-cont"></div>

		<!-- 预估价格 -->
		<div class="adv-info-cont price-info-cont cf">
			<p class="pull-right none">
				<span class="esti-price-label">预估价格：</span>
				<span class="esti-price-cont"><span class="glyphicon glyphicon-yen"></span><span class="esti-price">5000000</span></span>
			</p>
		</div>

		<div class="div-cont adv-location-input-cont">
		    <span class="adv-input-label">广告文位置<span class="must">*</span>：</span>
		    <label ><input type="radio" name="adv-location" value="1" class="mr5"/>首篇</label>
		    <label ><input type="radio" name="adv-location" value="2" class="mr5"/>第二篇</label>
		    <label ><input type="radio" name="adv-location" value="3" class="mr5"/>第三、五篇</label>
		</div>

		<!-- 广告类型 -->
		<div class="adv-info-cont adv-type-cont cf">
			<div class="adv-type-input-cont pull-left none">
				<p class="adv-input-label">广告类型<span class="must">*</span>：</p>
				<input type="text" id="adv-type"/>
			</div>
			<div class="adv-extratype-input-cont pull-left">
				<p class="adv-input-label">广告类型：</p>
				<div class="btn-group" role="group" aria-label="...">
				  	<button type="button" class="btn btn-default" price="150" val="1">软广</button>
				  	<button type="button" class="btn btn-default selected" price="250" val="2">硬广</button>
				</div>
			</div>
		</div>

		<!-- 广告标题 -->
		<div class="adv-info-cont adv-title-cont cf">
			<div class="adv-title-input-cont pull-left">
				<p class="adv-input-label">广告标题<span class="must">*</span>：</p>
				<input type="text" id="adv-title"/>
			</div>
			<div class="fans-count-input-cont pull-left">
				<p class="adv-input-label">粉丝数<span class="must">*</span>：</p>
				<select id="fans-range-select">
					<option value="1" max="1" selected>1万以下</option>
					<option value="2" min="1" max="5">1万－5万</option>
					<option value="3" min="5" max="10">5万－10万</option>
					<option value="4" min="10" max="30">10万－30万</option>
					<option value="5" min="30" max="80">30万－80万</option>
					<option value="6" min="80">80万以上</option>
				</select>
			</div>
		</div>

		<!-- 企业名称 -->
		<div class="adv-info-cont ent-name-cont">
			<p class="adv-input-label">企业名称<span class="must">*</span>：</p>
			<input type="text" id="ent-name" />
		</div>

		<!-- 联系方式 -->
		<div class="adv-info-cont coop-link-cont cf">
			<div class="link-man-input-cont pull-left">
				<p class="adv-input-label">合作联系人<span class="must">*</span>：</p>
				<input type="text" id="link-man" value=""/>
			</div>
			<div class="link-info-input-cont pull-left">
				<p class="adv-input-label">合作联系方式<span class="must">*</span>：</p>
				<input type="text" id="link-info" value=""/>
			</div>
		</div>

		<!-- 期待广告发布时间 -->
		<div class="adv-info-cont expect-time-cont">
			<input type="hidden" id="expect-min-date" value="<?php echo date('Y-m-d',strtotime('+1 month'));?>">
			<span class="adv-input-label">期待广告发布时间：</span>
		    <input type="text" id="expect-time" name="expect-time" value="2015-08-24" class="" readonly="readonly" />
		</div>

		<!-- 备注  -->
		<div class="adv-info-cont remark-cont">
			<p class="adv-input-label">附&nbsp;&nbsp;言：</p>
			<textarea id="remark"></textarea>
			<p class="tips">提交之后稍后会有工作人员向您联系。</p>
		</div>

		<div class="adv-info-cont submit-btn-cont">
			<input id="submit" type="submit" value="提&nbsp;&nbsp;交"/>
		</div>

	</div><!-- end of wrapper -->
</div>
