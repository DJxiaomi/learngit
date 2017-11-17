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
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<div class="position">
	<span>您当前的位置：</span>
	<a href="<?php echo IUrl::creatUrl("");?>">首页</a> » <a href="<?php echo IUrl::creatUrl("/site/seller");?>">商家列表</a>
</div>

<div class="wrapper clearfix container_2">
	<div class="sidebar f_l">
		<!--VIP商家排行-->
		<div class="box m_10">
			<div class="title">VIP商家</div>
			<div class="cont">
				<ul class="list">
				<?php foreach(Api::run('getVipSellerList') as $key => $item){?>
					<li><a href="<?php echo IUrl::creatUrl("/site/home/id/".$item['id']."");?>"><?php echo isset($item['true_name'])?$item['true_name']:"";?></a></li>
				<?php }?>
				</ul>
			</div>
		</div>
		<!--VIP商家排行-->
	</div>

	<div class="main f_r">
		<div class="box">
			<div class="title">商家列表</div>
			<!--商品列表展示-->
			<div class="cont">
				<?php $queryObj=Api::run('getSellerList');$resultData=$queryObj->find()?>
				<?php if($resultData){?>
				<ul class="piclist_2 clearfix">
					<?php foreach($resultData as $key => $item){?>
					<li>
						<div class='title2' style='overflow:hidden'>
							<a href="<?php echo IUrl::creatUrl("/site/home/id/".$item['id']."");?>"><?php echo isset($item['true_name'])?$item['true_name']:"";?></a>
						</div>
						<div class='t_l block'>
							<img src="<?php echo IUrl::creatUrl("")."".$item['logo']."";?>" style="width:100%" onerror="this.src='http://www.aircheng.com/images/public/default_logo.png'" />
						</div>
						<div class='t_l block'>
							评分：<span class="grade-star g-star<?php echo Common::gradeWidth(statistics::gradeSeller($item['id']));?>"></span>
						</div>
						<div class='t_l block'>销量：<?php echo statistics::sellCountSeller($item['id']);?> 件</div>
						<div class='t_l block' style='height:18px;overflow:hidden;'><?php echo join(' ',area::name($item['province'],$item['city'],$item['area']));?></div>
						<h3><a href="<?php echo IUrl::creatUrl("/site/home/id/".$item['id']."");?>" class="orange">进入店铺</a></h3>
					</li>
					<?php }?>
				</ul>
				<?php echo $queryObj->getPageBar();?>
				<?php }else{?>
				<p class="display_list mt_40 m_15">
					<strong class="gray f14">对不起，当前系统没有商家</strong>
				</p>
				<?php }?>
			</div>
			<!--商品列表展示-->
		</div>
	</div>
</div>
	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
	    <a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'activity_free_class'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/activity_free_class");?>" id="ztelBtn">
	        <span class="mui-tab-label">免费</span>
	    </a>
	    <a class="mui-tab-item money <?php if($this->getId() == 'site' && $_GET['action'] == 'chit2'){?>mui-hot-money<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit2");?>">
	        <span class="mui-tab-label">券</span>
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