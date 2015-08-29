<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script type="text/javascript" src="../static/js/rank.js"></script>


<!-- 主体 -->
<div id="main">
	<div class="wrapper cf overtop">
		<div class="main-left pull-left">
			<div class="cat-header"></div>
			<div class="cat-main">
				<ul class="cat-type-list">
					<!-- 分类列表 -->
					<?php foreach ($rank_cat_list as $rank_cat_item) { ?>
						<li class="<?php echo $rank_cat_item['is_current'] === true ? 'current' : ''?>">
							<div class="inner">
								<a href="<?php echo base_url('list/' . $rank_cat_item['id'] );?>">
									<i class="cat-type-icon cat-type-<?php echo $rank_cat_item['key'];?>"></i>
									<span><?php echo $rank_cat_item['desc'];?></span>
								</a>
							</div>
						</li>
					<?php } ?>
				</ul>

			</div>
		</div>

		<div class="main-right pull-right">
			<div class="main-right-header cf">
				<div class="update-time-con pull-left"><span>更新时间: <?php echo $update_time;?></span></div>
				<div class="search-con pull-right">
					<input id="keywords" type="text" placeholder="请输入微信公众号" value="<?php echo $keywords;?>">
					<button id="btn-search">&nbsp;</button>
				</div>
			</div>
			<div class="main-right-body">
				<!--  -->
				<table cellspacing="0">
					<thead>
						<tr>
							<td width="50">排名</td>
							<td width="" style="text-align:left;padding-left:8px">公众号</td>
							<td width="65">粉丝数</td>
							<td width="70">近一周发布</td>
							<td width="70">近一周阅读</td>
							<td width="70">近一周点赞</td>
							<td width="90">多图文首条</td>
							<td width="90">多图文二条</td>
							<td width="80"></td>
						</tr>
					</thead>
					<tbody>

					<!-- 排行列表 -->
					<?php foreach ($rank_list as $rank_pn) { ?>
						<tr>
							<td class="on <?php echo $rank_pn['rank_no'] <=3 ? ('rank_no_bg' . $rank_pn['rank_no']) : 'rank_no_bgN'?>"><?php echo $rank_pn['rank_no'];?></td>
							<td class="head">
								<span class="ico_bg"></span>
								<span class="img_span pa" imgsrc="<?php echo $rank_pn['pn_img_link'] . '/132';?>" imgstyle="width:28px;height:28px;border-radius:14px;"></span>
								<span class="en"><?php echo $rank_pn['pn_id'];?></span>
								<span class="ch"><?php echo $rank_pn['pn_cn_name'];?></span>
							</td>
							<td class="fansN"><?php echo $rank_pn['pn_fans'];?></td>
							<td class="publishN"><?php echo $rank_pn['pn_week_publish'];?></td>
							<td class="readN"><?php echo $rank_pn['pn_week_read'];?></td>
							<td class="zanN"><?php echo $rank_pn['pn_week_praise'];?></td>
							<td class="multi1">
								<p>软广：<?php echo $rank_pn['soft_multi_1_price'];?></p>
								<p>硬广：<?php echo $rank_pn['hard_multi_1_price'];?></p>
							</td>
							<td class="multi2">
								<p>软广：<?php echo $rank_pn['soft_multi_2_price'];?></p>
								<p>硬广：<?php echo $rank_pn['hard_multi_2_price'];?></p>
							</td>
							<td class="detail"><span><a href="<?php echo site_url("detail/{$rank_pn['pn_id']}");?>">详情</a></span></td>
						</tr>
					<?php } ?>
						
					</tbody>
					<tfoot></tfoot>
				</table>


				<!-- 分页条 -->
				<ul class="pager-bar" style="padding-left:<?php echo ((12 - count($pager_data)) / 2)*25; ?>px">
					<?php foreach ($pager_data as $pager_item) { ?>
						<li class="<?php echo $pager_item['class']?>">
							<?php if ( empty( $pager_item['link'] )) { ?>
								<?php echo $pager_item['text']?>
							<?php } else { ?>
								<a href="<?php echo $pager_item['link']?> " ><?php echo $pager_item['text']?></a>
							<?php } ?>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
