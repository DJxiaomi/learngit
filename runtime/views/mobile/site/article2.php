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
	<link href="<?php echo $this->getWebSkinPath()."css/article_list.css";?>" rel="stylesheet" type="text/css" />
<div class="slides"><a href="<?php echo IUrl::creatUrl("/ucenter/article_add2");?>"><img src="/views/mobile/skin/blue/images/yjzy_header.jpg" /></a></div>
<ul class="mui-table-view">
	<?php foreach($article_list as $key => $item){?>
	<li class="mui-table-view-cell mui-media">
		<a href="<?php echo IUrl::creatUrl("/site/article_detail2/id/".$item['id']."");?>">
			<div class="mui-media-img mui-pull-right">
				<img class="mui-media-object" src="<?php echo IUrl::creatUrl("")."".$item['thumb']."";?>" />
			</div>
			<div class="mui-media-body">
				<div class="mui-titleinfo"><?php echo isset($item['title'])?$item['title']:"";?></div>
        <div class="mui-moreinfo">
  				<span class="icon eye-icon"><?php echo isset($item['views'])?$item['views']:"";?></span>
  				<span class="icon good-icon"><?php echo isset($item['thumb_count'])?$item['thumb_count']:"";?></span>
        </div>
			</div>
		</a>
	</li>
	<?php }?>
</ul>

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