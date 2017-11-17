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
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.poppicker.css";?>" rel="stylesheet" type="text/css" />

<h5 class="mui-content-padded">功能设置</h5>
<div class="mui-content-padded" style="margin:0;">
	<form action="<?php echo IUrl::creatUrl("/seller/seller_add3");?>" method="post" id="sellerForm" enctype='multipart/form-data' class="mui-input-group">
		<div class="mui-input-row">
			<label>在线课堂</label>
			<input type="radio" name="is_support_zxkt" value="0" <?php if(!$this->sellerRow['is_support_zxkt']){?>checked<?php }?> style="width: auto;float: none;"/><label style="width: auto;float: none;">不开通</label>&nbsp; &nbsp;
			<input type="radio" name="is_support_zxkt" value="1" <?php if($this->sellerRow['is_support_zxkt']){?>checked<?php }?> style="width: auto;float: none;"/><label style="width: auto;float: none;">开通</label>
		</div>
		<div class="mui-input-row">
			<label>订票系统</label>
			<input type="radio" name="is_support_dp" value="0" <?php if(!$this->sellerRow['is_support_dp']){?>checked<?php }?> style="width: auto;float: none;"/><label style="width: auto;float: none;">不开通</label>&nbsp; &nbsp;
			<input type="radio" name="is_support_dp" value="1" <?php if($this->sellerRow['is_support_dp']){?>checked<?php }?> style="width: auto;float: none;"/><label style="width: auto;float: none;">开通</label>
		</div>
		<div class="mui-input-row">
			<label>虚拟商品</label>
			<input type="radio" name="is_virtual" value="0" <?php if(!$this->sellerRow['is_virtual']){?>checked<?php }?> style="width: auto;float: none;"/><label style="width: auto;float: none;">不开通</label>&nbsp; &nbsp;
			<input type="radio" name="is_virtual" value="1" <?php if($this->sellerRow['is_virtual']){?>checked<?php }?> style="width: auto;float: none;"/><label style="width: auto;float: none;">开通</label>
		</div>
		<div class="mui-input-row">
			<label>投票功能</label>
			<input type="radio" name="is_vote" value="0" <?php if(!$this->sellerRow['is_vote']){?>checked<?php }?> style="width: auto;float: none;"/><label style="width: auto;float: none;">不开通</label>&nbsp; &nbsp;
			<input type="radio" name="is_vote" value="1" <?php if($this->sellerRow['is_vote']){?>checked<?php }?> style="width: auto;float: none;"/><label style="width: auto;float: none;">开通</label>
		</div>
		<div class="mui-button-row">
			<button type="submit" class="mui-btn mui-btn-primary">确定</button>
		</div>
	</form>
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
