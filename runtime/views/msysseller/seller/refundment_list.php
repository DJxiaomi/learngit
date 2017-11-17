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
	<?php $search = Util::search(IReq::get('search'));$where = $search ? " and ".$search : "";?>
<?php if($refund_list){?>
<?php foreach($refund_list as $key => $item){?>
<div class="mui-card">
	<div class="mui-card-content">
		<div class="mui-card-content-inner">
			<p>订单号：<span class="gray"><?php echo isset($item['order_no'])?$item['order_no']:"";?></span></p>
			<p>申请时间：<span class="gray"><?php echo isset($item['time'])?$item['time']:"";?></span></span></p>
			<p>退款状态：<?php echo Order_Class::refundmentText($item['r_pay_status']);?></p>
		</div>
		<h5>退款课程</h5>
		<ul class="mui-table-view">
        	<?php $query = new IQuery("order_goods");$query->where = "id in ($item[order_goods_id])";$items = $query->find(); foreach($items as $key => $itemGoods){?>
            <?php $goods = JSON::decode($itemGoods['goods_array'])?>
            <li class="mui-table-view-cell mui-media">
                <img class="mui-media-object mui-pull-left" src="<?php echo IUrl::creatUrl("")."".$itemGoods['img']."";?>">
                <div class="mui-media-body">
                	<?php $goods_array = $itemGoods['goods_array']; ?>
                    <p><?php echo isset($goods['name'])?$goods['name']:"";?> <?php echo isset($goods['value'])?$goods['value']:"";?></p>
                    <p class="ordbigbt"><?php echo isset($itemGoods['goods_price'])?$itemGoods['goods_price']:"";?> x <?php echo isset($itemGoods['goods_nums'])?$itemGoods['goods_nums']:"";?></p>
                </div>
            </li>
            <?php }?>
        </ul>
	</div>
	<div class="mui-card-footer">
		<a class="mui-card-link" href="<?php echo IUrl::creatUrl("/seller/refundment_show/id/".$item['rid']."");?>">详情</a>
	</div>
</div>
<?php }?>
<?php }else{?>
<div class="mui-card">
	<div class="mui-card-content">
		<div class="mui-card-content-inner">
			没有信息
		</div>
	</div>
</div>
<?php }?>

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
