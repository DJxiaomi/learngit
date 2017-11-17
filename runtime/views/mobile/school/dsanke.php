<!doctype html>

<html>

<head>

	<meta http-equiv="X-UA-Compatible" content="IE=Edge">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<title><?php echo $siteConfig->name;?></title>

	<link type="image/x-icon" href="favicon.ico" rel="icon">

	<link href="<?php echo IUrl::creatUrl("")."resource/css/font-awesome.min.css";?>" rel="stylesheet" type="text/css" />

	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />

	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/jquery-3.1.1.min.js";?>"></script>

	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>

	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/common.js";?>"></script>

	<link href="<?php echo $this->getWebSkinPath()."school/css/bootstrap.min.css";?>" rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."school/css/lightbox.css";?>" type="text/css" media="all" />

	<link href="<?php echo $this->getWebSkinPath()."school/css/style.css";?>" rel="stylesheet" type="text/css"/>

	<script src="<?php echo $this->getWebSkinPath()."school/js/bootstrap.js";?>"></script>

	<script type="text/javascript" src="<?php echo $this->getWebSkinPath()."school/js/easing.js";?>"></script>

	<script type="text/javascript" src="<?php echo $this->getWebSkinPath()."school/js/TouchSlide.1.1.js";?>"></script>

	<script type="text/javascript">mui.init();var SITE_URL = 'http://<?php echo get_host();?><?php echo IUrl::creatUrl("");?>';</script>

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

	<!-- Top Navigation -->
<link href="<?php echo $this->getWebSkinPath()."css/dsanke.css";?>" rel="stylesheet" type="text/css" />
 <div class="bd">
            <ul>
							<?php if(!$ad_list){?>
	            <li>
	            	<div class="pic"><img src="/upload/2017/04/19/20170419152200862.jpg" /></div>
	            </li>
							<?php }else{?>
							<?php foreach($ad_list as $key => $item){?>
							<li>
	            	<div class="pic"><img src="/upload/2017/04/19/20170419152200862.jpg" /></div>
	            </li>
							<?php }?>
							<?php }?>
            </ul>
          </div>

  <div class="freeclassbd">
 	    <ul>
      <li>
      	<a href="/site/products/id/1755"><img src="/upload/2017/05/15/20170515044406223.png" /></a>
        <div class="classaction">
              <p class="tt">第三课试听课服务</p>
              <p class="detail">为教育培训机构降低前期营销成本，解决招生难的问题</p>
		</div>
      </li>
    </ul>
    <ul>
      <li>
      	<a href="/site/products/id/857"><img src="/upload/2017/04/18/20170418002521178.jpg" /></a>
        <div class="classaction">
              <p class="tt">户外广告众筹</p>
              <p class="detail">第三课合作伙伴户外广告众筹计划，让您一块广告牌的付出，获得十块广告牌的宣传效果！</p>
		</div>
      </li>
    </ul>
    <ul>
      <li>
      	<a href="/site/products/id/864"><img src="/upload/image/20170423/1492913343823443.png" /></a>
        <div class="classaction">
              <p class="tt">教育培训嘉年华</p>
              <p class="detail">展位和大舞台的展示时间先到先得，示时间内各参展单位可根据自身情况安排演出及活动内容</p>
		</div>
      </li>
    </ul>
	    <ul>
      <li>
      	<a href="/site/products/id/1815"><img src="/upload/2017/05/17/20170517094051131.jpg" /></a>
        <div class="classaction">
              <p class="tt">美的时代广场二周年庆典</p>
              <p class="detail">为期8天大型欢乐嘉年华，预计30万人流</p>
		</div>
      </li>
    </ul>
  </div>
</div>





	</div>

	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="http://<?php echo get_host();?><?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
	    <a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'activity_discount'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/school/home/id/365");?>" id="ztelBtn">
	        <span class="mui-tab-label">免费</span>
	    </a>
	    <a class="mui-tab-item money <?php if($this->getId() == 'site' && $_GET['action'] == 'activity_props'){?>mui-hot-money<?php }?>" href="<?php echo IUrl::creatUrl("/school/home/id/366");?>">
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

<!-- mui('body').on('tap', 'a', function(){ -->

    <!-- if(this.href != '#' && this.href != ''){ -->

        <!-- mui.openWindow({ -->

            <!-- url: this.href -->

        <!-- }); -->

    <!-- } -->

    <!-- this.click(); -->

<!-- }); -->

(function($) {

	$(document).imageLazyload({

		placeholder: '<?php echo $this->getWebSkinPath()."images/lazyload.jpg";?>'

	});

})(mui);

</script>
