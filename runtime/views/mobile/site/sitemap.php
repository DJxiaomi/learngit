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
		<div class="position"> <span>您当前的位置：</span> <a href="<?php echo IUrl::creatUrl("");?>"> 首页</a> » 站点地图 </div>
	<div class="sitemap wrapper clearfix">
		<div class="orange_title"><strong>服务</strong></div>
		<ul class="service_list clearfix">
			<li><a class="s1" href="<?php echo IUrl::creatUrl("/simple/reg");?>">注册</a></li><li><a class="s2" href="<?php echo IUrl::creatUrl("/simple/login");?>">登录</a></li><li><a class="s3" href="<?php echo IUrl::creatUrl("/site/article");?>">shop资讯</a></li><li><a class="s4" href="<?php echo IUrl::creatUrl("/site/groupon");?>">团购</a></li><!--<li><a class="s5" href="">限时抢购</a></li>--><li><a class="s6" href="<?php echo IUrl::creatUrl("/site/tags");?>">热门标签</a></li><li><a class="s7" href="<?php echo IUrl::creatUrl("/simple/cart");?>">购物车</a></li><li><a class="s8" href="<?php echo IUrl::creatUrl("site/sitemap");?>">网站地图</a></li><li><a class="s9" href="<?php echo IUrl::creatUrl("/site/notice");?>">站点公告</a></li><li><a class="s10" href="<?php echo IUrl::creatUrl("/site/help_list");?>">帮助中心</a></li><li><a class="s11" href="<?php echo IUrl::creatUrl("/simple/find_password");?>">找回密码</a></li>
		</ul>
		<div class="box">
			<div class="title"><h2>所有商品分类</h2></div>

			<div class="sort_1">
				<?php foreach(Api::run('getCategoryListTop') as $key => $first){?>
				<a onclick="$(this).siblings().removeClass('current');$(this).addClass('current');" href="#sort_<?php echo isset($key)?$key:"";?>"><?php echo isset($first['name'])?$first['name']:"";?></a>
				<?php }?>
			</div>
			<div class="sort_2">

				<?php foreach(Api::run('getCategoryListTop') as $key => $first){?>
				<table class="form_table" width="100%">
					<col width="100px" />
					<col />
					<caption><a name="sort_<?php echo isset($key)?$key:"";?>"><?php echo isset($first['name'])?$first['name']:"";?></a></caption>
					<tbody>
						<?php foreach(Api::run('getCategoryByParentid',array('#parent_id#',$first['id'])) as $key => $second){?>
						<tr>
							<th><a class="current" href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$second['id']."");?>"><?php echo isset($second['name'])?$second['name']:"";?></a></th>
							<td>
								<?php foreach(Api::run('getCategoryByParentid',array('#parent_id#',$second['id'])) as $key => $third){?>
								<a href='<?php echo IUrl::creatUrl("/site/pro_list/cat/".$third['id']."");?>'><?php echo isset($third['name'])?$third['name']:"";?></a>
								<?php }?>
							</td>
						</tr>
						<?php }?>
						<tr><th></th><td><a class="top f_r blue" href="#">回到顶部</a></td></tr>
					</tbody>
				</table>
				<?php }?>

			</div>
		</div>
	</div>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
			<a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
			<a class="mui-tab-item money <?php if($this->getId() == 'site' && $_GET['action'] == 'chit'){?>mui-hot-money<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit");?>" id="ztelBtn">
					<span class="mui-tab-label">代金券</span>
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
