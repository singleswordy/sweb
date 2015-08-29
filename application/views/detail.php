<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../static/js/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="../static/js/jquery.flot.min.js"></script>
<script type="text/javascript" src="../static/js/jquery.flot.time.min.js"></script>
<script type="text/javascript" src="../static/js/detail.js"></script>

<!-- 主体 -->
<div id="main">
	<input type="hidden" id="trend_data" value="<?php echo $pn_trend_data;?>"/>
	<div class="wrapper cf overtop">
		<!-- left -->
		<div class="main-left pull-left main-left-auto-height">
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
					<span class="dtl-label pull-left  none">影响力排名:<span class="rank-no"><?php //echo $pn_rank_no;?></span>名</span>
					<span class="adv-btn pull-right "><a href="<?php echo site_url('add/' . $pn_id);?>">广告合作</a></span>
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

			<!-- 近期文章 -->
			<div class="recent-publish-cont">
				
				<?php foreach ($pn_article_list as $key => $article) {?>
					<div class="publish-item cf">
						<div class="publish-img-cont pull-left" style="overflow:hidden">
							<div class="publish-img" style="width:230px;" imgsrc="<?php echo $article['article_img'] . '/0';?>" imgstyle=";width:230px;"></div>
						</div>
						<div class="publish-content-cont pull-left" style="width:435px;height:120px;padding:0 5px;">
							<p class="article-title">
								<a href="<?php echo $article['article_url'];?>">
									<?php echo $article['article_title'];?>
								</a>
							</p>
							<div class="article-content-cont">
								<p class="article-content">
									<?php echo $article['article_content'];?>
								</p>
							</div>
							<div class="article-extra-info">
								<span class="publish-time"><?php echo $article['article_publish_time'];?></span>
								<span class="read-count"><?php echo $article['article_read_num'];?></span>
								<span class="praise-count"><span class="glyphicon glyphicon-thumbs-up mr5"></span><?php echo $article['article_praise_num'];?></span>
							</div>
						</div>
					</div><!-- end of publish-item -->
					<?php if( $key < count($pn_article_list) - 1 ){ ?>
						<!-- 分割线 -->
						<div class="section div-line"></div>
					<?php } ?>
				<?php  } ?>

			</div>

		</div><!-- end of right -->

	</div>
</div>
