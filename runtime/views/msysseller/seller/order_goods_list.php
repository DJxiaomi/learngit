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
	<?php $this->title="成交明细"; ?>

<?php $seller_id = $this->seller['seller_id']?>
<?php $siteConfig = new Config("site_config")?>

<style>
  .uinn-a6 { padding: 1em 0.65em 0 0.65em; }
  .alt_btn { padding: 5px; }
  .uinn-t-rank {font-size: 80%; margin-top: 12px; font-family:"微软雅黑"; }
  .uinn-t-rank li { width: 96%; padding-left: 2%; padding-right: 2%; background-color: #fff; margin-bottom: 10px; }
  .uinn-t-rank li a { color: #000; text-decoration: none; }
  .uinn-t-rank .order_no, .uinn-t-rank .order_static { height: 25px; line-height: 25px; }
  .uinn-t-rank .order_action { height: 25px; overflow: hidden; width: 100%; }
  .uinn-t-rank .order_action .t-right { width: 20%; }
  .uinn-t-rank .order_action a.send { width: 100%; height: 23px; line-height: 23px; overflow: hidden; background-color: #ff5500; color: #fff; text-align: center; display: block; border-radius: 5px; }
  .uinn-t-rank .gray { color: #919090; }
  .uinn-t-rank .order_goods_list { clear: both; overflow: hidden; }
  .uinn-t-rank .order_goods_list .goods_info { margin-top: 5px; margin-bottom: 5px; clear: both; }
  .uinn-t-rank .order_static .format { color: #ff5500; }
  .uinn-t-rank .order_goods_list .goods_image { float: left; width: 50px; height: 50px; background-color: #f4f4f4; }
  .uinn-t-rank .order_goods_list .goods_image img { max-width: 100%; height: 100%; }
  .uinn-t-rank .order_goods_list .goods_infos { float: left; margin-left: 2%; line-height: 25px; }
  .uinn-t-rank .order_goods_list .goods_amount { float: left; color: #ff5500; margin-left: 3%; line-height: 25px; }
  .uinn-t-rank .notice { height: 25px; line-height: 25px; color: red; }
			.pages_bar { text-align: center; }
			.pages_bar a { color: red; margin-right: 3px; }
</style>


<div class="ub ub-ver">
    <div class="ub ub-ver uinn-a1">
        <div class="ub-img-rank rank-bg uinn-t-rank">
        	<div class="notice">
            	仅统计已使用的在线支付非货到付款的课程
            </div>
            <ul>
			<?php 
				$page = (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;
				$orderGoodsQuery = CountSum::getSellerGoodsFeeQuery($seller_id);
				$orderGoodsQuery->page = $page;
			?>
			<?php foreach($orderGoodsQuery->find() as $key => $item){?>

			<?php $countData = CountSum::countSellerOrderFee(array($item))?>

                <li>
                    <div class="order_no">
                        <div class="t-left">
                            订单号：<span class="gray"><?php echo isset($item['order_no'])?$item['order_no']:"";?></span>
                        </div>
                    </div>
                    <div class="order_static">
                        下单时间：<span class="gray"><?php echo isset($item['create_time'])?$item['create_time']:"";?></span>
                    </div>

                    <div class="order_static">
	                    小计：<span class="format">&yen;<?php echo isset($item['order_amount'])?$item['order_amount']:"";?></span>
                    </div>

                    <div class="order_static">
	                    促销活动：￥<?php echo isset($countData['platformFee'])?$countData['platformFee']:"";?><br/>
                    </div>

                    <div class="order_static">
                    	退款金额：￥<?php echo isset($countData['refundFee'])?$countData['refundFee']:"";?><br/>
                    </div>

                    <div class="order_action">
                        <div class="t-left">
                            订单状态：<?php echo Order_class::getOrderPayStatusText($item);?>-<?php echo Order_class::getOrderDistributionStatusText($item);?>
                        </div>
                        <div class="t-right">
                            <a href="<?php echo IUrl::creatUrl("/seller/order_show/id/".$item['id']."");?>" class="send">详情</a>
                        </div>
                    </div>
                </li>

            <?php }?>
            </ul>
            <?php echo $orderGoodsQuery->getPageBar();?>
        </div>
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
