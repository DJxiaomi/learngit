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
				<a class="mui-icon mui-icon-left-nav mui-pull-left" href="<?php echo IUrl::creatUrl("/site/chit1");?>"></a>
			<?php }?>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<div class="position"> <span>您当前的位置：</span> <a href="<?php echo IUrl::creatUrl("");?>"> 首页</a> » <a href="<?php echo IUrl::creatUrl("/site/products/id/".$this->goods['goods_id']."");?>">评论</a> </div>
<div class="wrapper clearfix">
	<div class="sidebar f_l">
		<div class="box_2 m_10">
			<div class="title">商品信息</div>
			<div class="content">
				<ul class="prolist clearfix">
					<li>
						<a href="<?php echo IUrl::creatUrl("/site/products/id/".$this->goods['goods_id']."");?>"><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$this->goods['img']."/w/167/h/212");?>" title="<?php echo isset($this->goods['name'])?$this->goods['name']:"";?>" alt="<?php echo isset($this->goods['name'])?$this->goods['name']:"";?>" height="212px" width="167px"></a>
						<p class="pro_title">商品名称：<a class="blue" href="<?php echo IUrl::creatUrl("/site/products/id/".$this->goods['goods_id']."");?>"><?php echo isset($this->goods['name'])?$this->goods['name']:"";?></a></p>
						<p>优惠价：<b><?php echo isset($this->goods['sell_price'])?$this->goods['sell_price']:"";?></b></p>
						<p>评价得分：<span class="grade-star g-star<?php echo isset($this->commentCount['average_point'])?$this->commentCount['average_point']:"";?>"></span>(<?php echo isset($this->commentCount['average_point'])?$this->commentCount['average_point']:"";?>分)</p>
						<p>评论数：<?php echo isset($this->commentCount['comment_total'])?$this->commentCount['comment_total']:"";?>条</p>
					</li>
					<input type="submit" onclick="joinCart_list(<?php echo isset($this->goods['goods_id'])?$this->goods['goods_id']:"";?>);" value="加入购物车" class="submit_join m_10">
				</ul>
			</div>
		</div>
	</div>

	<div class="main comment_list f_r">
		<div class="tabs">
			<div class="tabs_menu uc_title">
				<label name="tips"><span><a href="<?php echo IUrl::creatUrl("/site/comments_list/id/".$this->goods['goods_id']."");?>">全部评论(<?php echo isset($this->commentCount['comment_total'])?$this->commentCount['comment_total']:"";?>条)</a></span></label>
				<label name="tipsgood"><span><a href="<?php echo IUrl::creatUrl("/site/comments_list/id/".$this->goods['goods_id']."/type/good");?>">好评(<?php echo isset($this->commentCount['point_grade']['good'])?$this->commentCount['point_grade']['good']:"";?>条)</a></span></label>
				<label name="tipsmiddle"><span><a href="<?php echo IUrl::creatUrl("/site/comments_list/id/".$this->goods['goods_id']."/type/middle");?>">中评(<?php echo isset($this->commentCount['point_grade']['middle'])?$this->commentCount['point_grade']['middle']:"";?>条)</a></span></label>
				<label name="tipsbad"><span><a href="<?php echo IUrl::creatUrl("/site/comments_list/id/".$this->goods['goods_id']."/type/bad");?>">差评(<?php echo isset($this->commentCount['point_grade']['bad'])?$this->commentCount['point_grade']['bad']:"";?>条)</a></span></label>
			</div>

			<div class="tabs_content">
				<?php foreach($this->commentQuery->find() as $key => $item){?>
				<div class="node item">
					<div class="user">
						<div class="ico"><img src="<?php echo IUrl::creatUrl("")."".$item['head_ico']."";?>" width="70px" height="70px" onerror="this.src='<?php echo $this->getWebSkinPath()."images/front/user_ico.gif";?>'" /></div>
						<a class="blue"><?php echo isset($item['username'])?$item['username']:"";?></a>
						<p class="gray"></p>
					</div>
					<dl class="desc">
						<p class="clearfix">
							<b>评分：</b>
							<span class="grade-star g-star<?php echo isset($item['point'])?$item['point']:"";?>"></span>
							<span class="light_gray"><?php echo isset($item['time'])?$item['time']:"";?></span>
							<label></label>
						</p>
						<hr />
						<p><b>评语：</b><span class="gray"><?php echo isset($item['contents'])?$item['contents']:"";?></span></p>
					</dl>
					<div class="corner b"></div>
					<div class="corner tl"></div>
				</div>
				<hr />
				<?php }?>
			</div>
			<?php echo $this->commentQuery->getPageBar();?>
		</div>
	</div>
</div>

<script type="text/javascript">
	<?php $type=IFilter::act(IReq::get('type'))?>
	var tipsName = "tips<?php echo isset($type)?$type:"";?>";
	$('[name="'+tipsName+'"]').addClass('current');
</script>
	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
			<a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
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

(function($) {
	$(document).imageLazyload({
		placeholder: '<?php echo $this->getWebSkinPath()."images/lazyload.jpg";?>'
	});
})(mui);
</script>

<?php if($id == 851){?>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/form.css";?>" />
<script>var pid = <?php echo isset($id)?$id:"";?>;</script>
<script language="javascript" src="<?php echo $this->getWebSkinPath()."js/form.js";?>"></script>
<?php }?>
