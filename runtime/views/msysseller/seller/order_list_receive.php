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
	<?php $seller_id = $this->seller['seller_id']?>
<?php $searchParam = http_build_query(Util::getUrlParam('search'))?>
<?php $condition = Util::search(IReq::get('search'));
	$where = $condition ? " and ".$condition : "";
?>
<?php $query = new IQuery("delivery");$items = $query->find(); foreach($items as $key => $item){?>
	<?php $delivery_id=$item['id']?>
	<?php $kuaidi["$delivery_id"] = $item['name']?>
<?php }?>
<h5 class="mui-content-padded">订单列表</h5>
<?php $page = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1?>
<?php $orderObject = new IQuery("order_goods as og");$orderObject->join = "left join goods as go on go.id = og.goods_id left join order as o on o.id = og.order_id";$orderObject->fields = "o.*";$orderObject->page = "$page";$orderObject->where = "o.pay_status = 1 and o.seller_id = $seller_id and o.if_del = 0 and o.statement = 4 and o.status not in(3,4) $where";$orderObject->group = "og.order_id";$orderObject->order = "o.id desc";$items = $orderObject->find(); foreach($items as $key => $item){?>
<?php $order_status_t = Order_Class::getOrderStatus($item);?>
<?php $goods_list = Order_Class::get_order_goods_list($item['id'])?>
<?php $goods = $goods_list[0]?>
<?php $goods_array = $goods['goods_array']?>
<?php
	$order_goods_list = Order_Class::get_order_goods_list( $item['id'] );
?>
<div class="mui-card">
    <div class="mui-card-header"><?php echo isset($item['order_no'])?$item['order_no']:"";?></div>
    <div class="mui-card-content">
        <ul class="mui-table-view">
        	<?php foreach($order_goods_list as $key => $it){?>
            <li class="mui-table-view-cell mui-media">
                <a href="<?php echo IUrl::creatUrl("/seller/order_show/id/".$item['id']."");?>">
                    <img class="mui-media-object mui-pull-left" src="/<?php echo isset($it['img'])?$it['img']:"";?>">
                    <div class="mui-media-body">
                    	<?php $goods_array = $it['goods_array']; ?>
                        <p class="ordbigbt"><?php echo $goods_array->name;?> <?php echo $goods_array->value;?></p>
                        <p class="ordbigbt"><?php echo isset($goods['goods_price'])?$goods['goods_price']:"";?> x <?php echo isset($it['goods_nums'])?$it['goods_nums']:"";?></p>
                    </div>
                </a>
            </li>
            <?php }?>
        </ul>
        <div class="mui-card-content-inner">
            <p class="ordbigbt"><span>联系人：</span><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></p>
            <p class="ordbigbt"><span>联系电话：</span><?php echo isset($item['mobile'])?$item['mobile']:"";?></p>
            <p>订单状态：<?php echo order_class::orderStatusText(order_class::getOrderStatus($item), 2, $item['statement']);?></p>
            <p>下单时间：<?php echo isset($item['create_time'])?$item['create_time']:"";?></p>
            <p>小计：&yen;<?php echo isset($item['order_amount'])?$item['order_amount']:"";?></p>
        </div>
    </div>
    <div class="mui-card-footer">
    	<?php if(Order_class::isGoDelivery($item)){?>
    	<a href="<?php echo IUrl::creatUrl("/seller/order_deliver/id/".$item['id']."");?>" class="mui-card-link">确认授课</a>
    	<?php }?>
        <a href="<?php echo IUrl::creatUrl("/seller/order_show/id/".$item['id']."");?>" class="mui-card-link">查看详情</a>
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
