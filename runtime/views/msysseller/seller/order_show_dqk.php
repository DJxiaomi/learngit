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
<style>
td {text-align:center;}
</style>
<div class="mui-card">
	<div class="mui-card-header">学员信息</div>
	<div class="mui-card-content">
		<div class="mui-card-content-inner">
			<p>姓名：<?php echo isset($accept_name)?$accept_name:"";?></p>
			<p>手机：<?php echo isset($mobile)?$mobile:"";?></p>
			<?php if($send_time){?>
			<p>报名时间：<?php echo isset($send_time)?$send_time:"";?></p>
			<?php }?>

			<?php if(in_array( order_class::getOrderStatus( $orderRow ), array(4))){?>
				<input type="button" class="alt_btn" onclick="finish_order('<?php echo isset($orderRow['order_id'])?$orderRow['order_id']:"";?>');" value="订单完成" />
			<?php }?>
		</div>
	</div>
</div>
<div class="mui-card">
	<div class="mui-card-header">基本信息</div>
	<div class="mui-card-content">
		<div class="mui-card-content-inner">
			<table class="tablesorter clear">
				<colgroup>
					<col width="25%" />
					<col width="25%" />
					<col width="25%" />
				</colgroup>

				<thead>
					<tr>
						<th>短期课名称</th>
						<th>价格</th>
						<th>可用次数</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach($dqk_list as $key => $item){?>
					<tr>
						<td><?php echo isset($item['name'])?$item['name']:"";?></td>
						<td>￥<?php echo isset($item['max_price'])?$item['max_price']:"";?></td>
						<td><?php if($item['availeble_use_times'] > 0 ){?><?php echo floor($item['availeble_use_times'] / $item['each_times']);?>次<?php echo isset($item['availeble_use_times'])?$item['availeble_use_times']:"";?>课时<?php }else{?>0课时<?php }?></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php  $cost_price = $item['cost_price']; ?>
<?php  $goods_nums = $item['goods_nums']; ?>

<div class="mui-card">
	<div class="mui-card-header">订单信息</div>
	<div class="mui-card-content">
		<div class="mui-card-content-inner">
			<p>订单号：<?php echo isset($order_no)?$order_no:"";?></p>
			<p>下单时间：<?php echo  date('Y-m-d H:i', strtotime($create_time));?></p>
			<p><?php if($statement == 1){?>总金额<?php }elseif($statement == 2){?>代金券<?php }else{?>定金<?php }?>:</th><td>￥
				<?php if($statement == 1){?>
					<?php echo isset($order_amount)?$order_amount:"";?>
				<?php }elseif($statement == 3 && $coupon_nums <= 0){?>
				￥<?php echo $cost_price - $rest_price;?>
				<?php }else{?>
				<?php echo isset($payable_amount)?$payable_amount:"";?>
				<?php }?>
			</p>
			<?php if($statement == 2){?>
			<p>抵用：￥<?php echo isset($chit)?$chit:"";?></p>
			<p>付全款：￥<?php echo isset($rest_price)?$rest_price:"";?></p>
			<?php }elseif($statement == 3){?>
			<p>尾款：￥<?php echo isset($rest_price)?$rest_price:"";?></p>
			<?php }?>
			<p>订单状态：<?php echo order_class::orderStatusText(order_class::getOrderStatus($orderRow),2, $orderRow['statement']);?></p>
		</div>
	</div>
</div>
<div class="mui-card" style="padding-bottom:50px;">
	<div class="mui-card-header">订单日志</div>
	<div class="mui-card-content">
		<div class="mui-card-content-inner">
			<?php $query = new IQuery("order_log as ol");$query->where = "ol.order_id = $order_id";$items = $query->find(); foreach($items as $key => $item){?>
			<p>时间：<?php echo isset($item['addtime'])?$item['addtime']:"";?></p>
			<p>动作：<?php echo order_log_class::read_log($item);?></p>
			<?php }?>
		</div>
	</div>
</div>


<script language="javascript">
var _update_dqk_ajax = '<?php echo IUrl::creatUrl("/seller/update_dqk_status");?>';
var _order_id = <?php echo isset($order_id)?$order_id:"";?>;

function finish_order()
{
	url = "<?php echo IUrl::creatUrl("/seller/order_finish/order_id/".$orderRow['order_id']."");?>";
	window.location.href = url;
}
//DOM加载完毕后运行
$(function()
{
	$('.confirm_dqk').click(function(){
		var _id = $(this).attr('id');
		var btnArray = ['取消','确定'];
		mui.confirm('您确定用户已经使用了短期课吗？', '提示信息', btnArray, function(e) {
				if (e.index == 1)
				{
					$.post(_update_dqk_ajax,{id:_id,order_id:_order_id},function(result){
							if ( result == '1')
							{
								location.reload();
							} else {
								if ( result == '-1')
								{
									layer.alert('参数不正确');
								} else {
									layer.alert('操作失败');
								}
							}
					})
				}
		});
	});
});
</script>

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
