<?php
	$member_info = member_class::get_member_info($this->user['user_id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $this->_siteConfig->name;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<link href="<?php echo IUrl::creatUrl("")."resource/css/font-awesome.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/jquery-3.1.1.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/common.js";?>"></script>
	<script type="text/javascript">mui.init({swipeBack:true});var SITE_URL = '<?php echo IUrl::creatUrl("");?>';</script>
</head>
<body>
	<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '')){?>
	<?php }else{?>
	<header class="mui-bar mui-bar-nav">
			<?php if(!$this->back_url){?>
	    	<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
			<?php }else{?>
				<style>
				.mui-icon-back:before, .mui-icon-left-nav:before {color: #fff;}
				</style>
				<a class="mui-icon mui-icon-left-nav mui-pull-left" href="<?php echo IUrl::creatUrl("".$this->back_url."");?>"></a>
			<?php }?>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquerySlider/jquery.bxslider.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/jquerySlider/jquery.bxslider.css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.poppicker.css";?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.poppicker.js";?>"></script>
<link href="<?php echo $this->getWebSkinPath()."css/goods_new.css";?>" rel="stylesheet" type="text/css" />
<div class="wrapper clearfix">
	<div class="sidebar f_r">

		<!--团购-->
		<div class="group_on box m_10" style="display:none;">
			<div class="title"><h2>团购商品</h2><a class="more" href="<?php echo IUrl::creatUrl("/site/groupon");?>">更多...</a></div>
			<div class="cont">
				<ul class="ranklist">

					<?php foreach(Api::run('getRegimentList',5) as $key => $item){?>
					<li class="current">
						<?php $tmpId=$item['id'];?>
						<a href="<?php echo IUrl::creatUrl("/site/groupon/id/".$tmpId."");?>"><img width="60px" height="60px" alt="<?php echo isset($item['title'])?$item['title']:"";?>" src="<?php echo IUrl::creatUrl("")."".$item['img']."";?>"></a>
						<a class="p_name" title="<?php echo isset($item['title'])?$item['title']:"";?>" href="<?php echo IUrl::creatUrl("/site/groupon/id/".$tmpId."");?>"><?php echo isset($item['title'])?$item['title']:"";?></a><p class="light_gray">团购价：<em>￥<?php echo isset($item['regiment_price'])?$item['regiment_price']:"";?></em></p>
					</li>
					<?php }?>

				</ul>
			</div>
		</div>
		<!--团购-->

		<!--限时抢购-->
		<div class="buying box m_10" style="display:none;">
			<div class="title"><h2>限时抢购</h2></div>
			<div class="cont clearfix">
				<ul class="prolist">
					<?php foreach(Api::run('getPromotionList',5) as $key => $item){?>
					<?php $free_time = ITime::getDiffSec($item['end_time'])?>
					<?php $countNumsItem[] = $item['p_id'];?>
					<li>
						<p class="countdown">倒计时:<br /><b id='cd_hour_<?php echo isset($item['p_id'])?$item['p_id']:"";?>'><?php echo floor($free_time/3600);?></b>时<b id='cd_minute_<?php echo isset($item['p_id'])?$item['p_id']:"";?>'><?php echo floor(($free_time%3600)/60);?></b>分<b id='cd_second_<?php echo isset($item['p_id'])?$item['p_id']:"";?>'><?php echo $free_time%60;?></b>秒</p>
						<?php $tmpGoodsId=$item['goods_id'];$tmpPId=$item['p_id'];?>
						<a href="<?php echo IUrl::creatUrl("/site/products/id/".$tmpGoodsId."/promo/time/active_id/".$tmpPId."");?>"><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/175/h/175");?>" width="175" height="175" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
						<p class="pro_title"><a href="<?php echo IUrl::creatUrl("/site/products/id/".$tmpGoodsId."/promo/time/active_id/".$tmpPId."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></p>
						<p class="light_gray">抢购价：<b>￥<?php echo isset($item['award_value'])?$item['award_value']:"";?></b></p>
						<div></div>
					</li>
					<?php }?>
				</ul>
			</div>
		</div>
		<!--限时抢购-->
		<?php echo Ad::show("页面顶部通栏广告条");?>
		<!--热卖商品-->
		<div class="hot box m_10" style="display:none;">
			<div class="title"><h2>热卖商品</h2></div>
			<div class="cont clearfix">
				<ul class="prolist">
					<?php foreach(Api::run('getCommendHot',8) as $key => $item){?>
					<?php $tmpId=$item['id']?>
					<li>
						<a href="<?php echo IUrl::creatUrl("/site/products/id/".$tmpId."");?>"><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/85/h/85");?>" width="85" height="85" alt="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
						<p class="pro_title"><a href="<?php echo IUrl::creatUrl("/site/products/id/".$tmpId."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></p>
						<p class="brown"><b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b></p>
					</li>
					<?php }?>
				</ul>
			</div>
		</div>
		<!--热卖商品-->

	</div>

	<div class="pro-tab">
		<a href="javascript:;" id="kecheng">选择分类</a>
	</div>

	<div class="main f_l">
		<!--商品分类展示-->
		<table id="index_category" class="sort_table m_10" width="100%" style="display:none;">
			<col width="100px" />
			<col />
			<?php foreach(Api::run('getCategoryListTop') as $key => $first){?>
			<tr>
				<th><a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$first['id']."");?>"><?php echo isset($first['name'])?$first['name']:"";?></a></th>
				<td>
					<?php foreach(Api::run('getCategoryByParentid',array('#parent_id#',$first['id'])) as $key => $second){?>
					<a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$second['id']."");?>"><?php echo isset($second['name'])?$second['name']:"";?></a>
					<?php }?>
				</td>
			</tr>
			<?php }?>
		</table>
		<!--商品分类展示-->

		<!--最新商品-->
		<div class="box yellow m_10">
			<div class="cont clearfix">
				<ul class="prolist">
					<?php foreach(Api::run('getCommendNew',200) as $key => $item){?>
					<?php $tmpId=$item['id'];?>
					<li style="overflow:hidden">
						<a href="<?php echo IUrl::creatUrl("/site/products/id/".$tmpId."");?>"><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/175/h/175");?>" width="175" height="175" alt="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
						<p class="pro_title"><a title="<?php echo isset($item['name'])?$item['name']:"";?>" href="<?php echo IUrl::creatUrl("/site/products/id/".$tmpId."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></p>
						<p class="brown">惊喜价：<b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b></p>
						<p class="light_gray"><?php echo isset($item['keywords'])?$item['keywords']:"";?></p>
					</li>
					<?php }?>
				</ul>
			</div>
		</div>
		<!--最新商品-->

		<!--首页推荐商品-->
		<?php foreach(Api::run('getCategoryListTop') as $key => $first){?>
		<div class="box m_10" name="showGoods" style="display:none;">
			<div class="title title3">
				<h2><a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$first['id']."");?>"><strong><?php echo isset($first['name'])?$first['name']:"";?></strong></a></h2>
				<a class="more" href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$first['id']."");?>">更多商品...</a>
				<ul class="category">
					<?php foreach(Api::run('getCategoryByParentid',array('#parent_id#',$first['id'])) as $key => $second){?>
					<li><a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$second['id']."");?>"><?php echo isset($second['name'])?$second['name']:"";?></a><span></span></li>
					<?php }?>
				</ul>
			</div>

			<div class="cont clearfix">
				<ul class="prolist">
					<?php foreach(Api::run('getCategoryExtendList',array('#categroy_id#',$first['id']),8) as $key => $item){?>
					<li style="overflow:hidden">
						<a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>"><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/175/h/175");?>" width="175" height="175" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
						<p class="pro_title"><a title="<?php echo isset($item['name'])?$item['name']:"";?>" href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></p>
						<p class="brown">惊喜价：<b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b></p>
						<p class="light_gray">市场价：<s>￥<?php echo isset($item['market_price'])?$item['market_price']:"";?></s></p>
					</li>
					<?php }?>
				</ul>
			</div>
		</div>
		<?php }?>

		<!--品牌列表-->
		<div class="brand box m_10" style="display:none;">
			<div class="title2"><h2><img src="<?php echo $this->getWebSkinPath()."images/front/brand.gif";?>" alt="品牌列表" width="155" height="36" /></h2><a class="more" href="<?php echo IUrl::creatUrl("/site/brand");?>">&lt;<span>全部品牌</span>&gt;</a></div>
			<div class="cont clearfix">
				<ul>
					<?php foreach(Api::run('getBrandList',6) as $key => $item){?>
					<?php $tmpId=$item['id'];?>
					<li><a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/".$tmpId."");?>"><img src="<?php echo IUrl::creatUrl("")."".$item['logo']."";?>"  width="110" height="50"/><?php echo isset($item['name'])?$item['name']:"";?></a></li>
					<?php }?>
				</ul>
			</div>
		</div>
		<!--品牌列表-->

		<!--最新评论-->
		<div class="comment box m_10" style="display:none;">
			<div class="title2"><h2><img src="<?php echo $this->getWebSkinPath()."images/front/comment.gif";?>" alt="最新评论" width="155" height="36" /></h2></div>
			<div class="cont clearfix">
				<?php foreach(Api::run('getCommentList',6) as $key => $item){?>
				<dl class="no_bg">
					<?php $tmpGoodsId=$item['goods_id'];?>
					<dt><a href="<?php echo IUrl::creatUrl("/site/products/id/".$tmpGoodsId."");?>"><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/66/h/66");?>" width="66" height="66" /></a></dt>
					<dd><a href="<?php echo IUrl::creatUrl("/site/products/id/".$tmpGoodsId."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></dd>
					<dd><span class="grade-star g-star<?php echo isset($item['point'])?$item['point']:"";?>"></span></dd>
					<dd class="com_c"><?php echo isset($item['contents'])?$item['contents']:"";?></dd>
				</dl>
				<?php }?>
			</div>
		</div>
		<!--最新评论-->
	</div>
</div>

<script type='text/javascript'>
//dom载入完毕执行
jQuery(function()
{
	//幻灯片开启
	$('.bxslider').bxSlider({'mode':'fade','captions':true,'pager':false,'auto':true});

	//index 分类展示
	$('#index_category tr').hover(
		function(){
			$(this).addClass('current');
		},
		function(){
			$(this).removeClass('current');
		}
	);

	//显示抢购倒计时
	/**
	var cd_timer = new countdown();
	<?php if(isset($countNumsItem) && $countNumsItem){?>
	<?php foreach($countNumsItem as $key => $item){?>
		cd_timer.add(<?php echo isset($item)?$item:"";?>);
	<?php }?>
	<?php }?>
	**/

	//首页商品变色
	var colorArray = ['green','yellow','purple','black'];
	$('div[name="showGoods"]').each(function(i)
	{
		$(this).addClass(colorArray[i%colorArray.length]);
	});
});

//电子邮件订阅
function orderinfo()
{
	var email = $('[name="orderinfo"]').val();
	if(email == '')
	{
		alert('请填写正确的email地址');
	}
	else
	{
		$.getJSON('<?php echo IUrl::creatUrl("/site/email_registry");?>',{email:email},function(content){
			if(content.isError == false)
			{
				alert('订阅成功');
				$('[name="orderinfo"]').val('');
			}
			else
				alert(content.message);
		});
	}
}

mui.ready(function(){
	var catdata = <?php if($jsoncats){?><?php echo isset($jsoncats)?$jsoncats:"";?><?php }else{?>new Array()<?php }?>;
	var userPicker = new mui.PopPicker({
		layer: 2
	});
	userPicker.setData(catdata);
	var showUserPickerButton = document.getElementById('kecheng');
	showUserPickerButton.addEventListener('tap', function(event) {
		userPicker.show(function(items) {
				var url = '<?php echo IUrl::creatUrl("/site/pro_list/cat/@id@");?>';
				url = url.replace('@id@',items[1]['value']);
				location.href = url;
		});
	}, false);
})
</script>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
			<a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
			<a class="mui-tab-item brand <?php if($this->getId() == 'site' && $_GET['action'] == 'manual'){?>mui-hot-brand<?php }?>" href="<?php echo IUrl::creatUrl("/site/manual");?>" id="ztelBtn">
					<span class="mui-tab-label">教育手册</span>
			</a>
	    <a class="mui-tab-item user <?php if($this->getId() == 'ucenter' || ($this->getId() == 'simple' && $_GET['action'] == 'login')){?>mui-hot-user<?php }?>" href="<?php echo IUrl::creatUrl("/simple/login");?>?callback=/ucenter" id="ltelBtn">
	        <span class="mui-tab-label">我的</span>
	    </a>
      <a class="mui-tab-item service" href="<?php echo IUrl::creatUrl("/site/service");?>" id="ltelBtn">
	        <span class="mui-tab-label">客服</span>
	    </a>
	</nav>
</body>
</html>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.lazyload.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.lazyload.img.js";?>"></script>
<script type="text/javascript">
mui('body').on('tap', 'a', function(){
    if(this.href != '#' && this.href != ''){
        mui.openWindow({
            url: this.href
        });
    }
    this.click();
});

</script>

<?php if($id == 851){?>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/form.css";?>" />
<script>var pid = <?php echo isset($id)?$id:"";?>;</script>
<script language="javascript" src="<?php echo $this->getWebSkinPath()."js/form.js";?>"></script>
<?php }?>
