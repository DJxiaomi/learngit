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
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/goods_list.css";?>" />
<style>
.mui-media-object img {width:100px;height: 100px;}
.mui-media-body {width: 65%;float:right;margin-left: 20px;}
.mui-media-body a {margin-top: 15px;}
.mui-btn-primary {width:90%;margin: 0px auto;border-radius:5px;background:linear-gradient(to right,#ff9638,#ff4b2b);border:0px;}
</style>
<?php if($teacher_list_info['result']){?>
<ul>
	<?php foreach($teacher_list_info['result'] as $key => $item){?>
		<li class="mui-table-view-cell mui-media">
			<div class="mui-media-object mui-pull-left"><img src="<?php echo IUrl::creatUrl("")."".$item['icon']."";?>" /></div>
			<div class="mui-media-body">
					<p class="goods_name"><?php echo isset($item['name'])?$item['name']:"";?>&nbsp; <?php echo get_sex( $item['sex']); ?></p>
					<p class="goods_brief"><?php echo isset($item['description'])?$item['description']:"";?></p>
					<a class="buycard editcard" href="<?php echo IUrl::creatUrl("/seller/teacher_edit/id/".$item['id']."");?>">编辑</a>
					<a class="buycard delcart" href="javascript:delModel({link:'<?php echo IUrl::creatUrl("/seller/teacher_del/id/".$item['id']."");?>'})">删除</a>
			</div>
		</li>
	<?php }?>
</ul>
<?php }else{?>
<div class="mui-card">
	<div class="mui-card-content">
		<div class="mui-card-content-inner">
			没有教师
		</div>
	</div>
</div>
<?php }?>
<div class="mui-content-padded">
	<button type="button" class="mui-btn mui-btn-primary mui-btn-block mui-btn-block-self" onclick="window.location.href='<?php echo IUrl::creatUrl("/seller/teacher_edit");?>'">添加老师</button>
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
