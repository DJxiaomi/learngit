<!doctype html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>管理中心</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<link href="/resource/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/form.css";?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/resource/scripts/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/jquery.juploader.js";?>"></script>
	<script type="text/javascript" src="/resource/scripts/common.js"></script>
	<script type="text/javascript">mui.init();var SITE_URL = '<?php echo IUrl::creatUrl("");?>';</script>
</head>
<body>
	<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '')){?>
	<?php }else{?>
	<header class="mui-bar mui-bar-nav">
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }else{?>
		<a href="" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->getWebSkinPath()."css/index.css";?>" />
<style>
.mui-btn-primary {background:linear-gradient(to right,#ff9638,#ff4b2b);border:0px;}
</style>
<div class="mui-content" style="background-color:#fff;">
  <ul class="mui-table-view" style="display:none;">
    <li class="mui-table-view-cell">课程老师</li>
  </ul>

  <ul class="mui-table-view mui-grid-view mui-grid-12" style="display:none;">
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/goods_list_1");?>">
        <img src="/views/msysseller/skin/blue/images/icon_3.png" />
        <div class="mui-media-body">课程列表</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/teacher_list");?>">
        <img src="/views/msysseller/skin/blue/images/icon_2.png" />
        <div class="mui-media-body">教师列表</div>
      </a>
    </li>
  </ul>

  <ul class="mui-table-view">
    <li class="mui-table-view-cell">学校设置</li>
  </ul>

  <ul class="mui-table-view mui-grid-view mui-grid-12">
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/brand_edit");?>">
        <img src="/views/msysseller/skin/blue/images/icon_1.png" />
        <div class="mui-media-body">页面信息</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/seller_edit");?>">
        <img src="/views/msysseller/skin/blue/images/icon_2.png" />
        <div class="mui-media-body">基本信息</div>
      </a>
    </li>
    <!-- <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/seller_edit3");?>">
        <img src="/views/msysseller/skin/blue/images/icon_4.png" />
        <div class="mui-media-body">功能设置</div>
      </a>
    </li> -->
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/seller_edit4");?>">
        <img src="/views/msysseller/skin/blue/images/icon_3.png" />
        <div class="mui-media-body">结算账户</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/seller_edit5");?>">
        <img src="/views/msysseller/skin/blue/images/icon_4.png" />
        <div class="mui-media-body">账户安全</div>
      </a>
    </li>
    <!-- <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/seller_edit6");?>">
        <img src="/views/msysseller/skin/blue/images/icon_5.png" />
        <div class="mui-media-body">认证信息</div>
      </a>
    </li> -->
  </ul>

  <ul class="mui-table-view">
    <li class="mui-table-view-cell">订单及售后</li>
  </ul>

  <ul class="mui-table-view mui-grid-view mui-grid-12">
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/order_list");?>">
        <img src="/views/msysseller/skin/blue/images/icon_5.png" />
        <div class="mui-media-body">正式课列表</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/order_list_dqk");?>">
        <img src="/views/msysseller/skin/blue/images/icon_6.png" />
        <div class="mui-media-body">短期课列表</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/order_list_receive");?>">
        <img src="/views/msysseller/skin/blue/images/icon_7.png" />
        <div class="mui-media-body">商户收款列表</div>
      </a>
    </li>
    <!-- <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/order_verification");?>">
        <img src="/views/msysseller/skin/blue/images/icon_7.png" />
        <div class="mui-media-body">上课确认</div>
      </a>
    </li> -->
    <!-- <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/chit");?>">
        <img src="/views/msysseller/skin/blue/images/icon_8.png" />
        <div class="mui-media-body">代金券发布</div>
      </a>
    </li> -->
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/refundment_list");?>">
        <img src="/views/msysseller/skin/blue/images/icon_8.png" />
        <div class="mui-media-body">退款申请</div>
      </a>
    </li>
  </ul>


  <ul class="mui-table-view">
    <li class="mui-table-view-cell">商户提现</li>
  </ul>

  <ul class="mui-table-view mui-grid-view mui-grid-12">
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/sale_tixian");?>">
        <img src="/views/msysseller/skin/blue/images/icon_9.png" />
        <div class="mui-media-body">账户交易额</div>
      </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
      <a href="<?php echo IUrl::creatUrl("/seller/tixian_list");?>">
        <img src="/views/msysseller/skin/blue/images/icon_4.png" />
        <div class="mui-media-body">提现记录</div>
      </a>
    </li>
  </ul>

  <div class="mui-content-padded">
      <a href="/systemseller/logout" class="mui-btn mui-btn-primary mui-btn-block" id="confirm"><i class="icon-off"></i> 安全退出</a>
  </div>


</div>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/brand_edit");?>" id="ztelBtn">
	        <i class="mui-icon-my icon-book"></i>
	        <span class="mui-tab-label">页面信息</span>
	    </a>
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/seller_edit");?>" id="ztelBtn">
	        <i class="mui-icon-my icon-globe"></i>
	        <span class="mui-tab-label">基本信息</span>
	    </a>
	    <!-- <a class="mui-tab-item mui-hot" href="<?php echo IUrl::creatUrl("/seller/chit");?>">
	        <i class="mui-icon-my icon-github-alt"></i>
	        <span class="mui-tab-label">代金券</span>
	    </a> -->
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/order_list");?>">
	        <i class="mui-icon-my icon-shopping-cart"></i>
	        <span class="mui-tab-label">学校订单</span>
	    </a>
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/meau_index");?>" id="ltelBtn">
	        <i class="mui-icon-my icon-user"></i>
	        <span class="mui-tab-label">管理中心</span>
	    </a>
	</nav>
</body>
</html>
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
