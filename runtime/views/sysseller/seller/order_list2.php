<?php $seller_id = $this->seller['seller_id'];$seller_name = $this->seller['seller_name'];?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>商家管理后台</title>
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/html5.js";?>"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/common.js";?>"></script>
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/ie.css";?>" type="text/css" media="screen" />
	<![endif]-->
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/admin.css";?>" type="text/css" media="screen" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
</head>

<body>
	<!--头部 开始-->
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="<?php echo IUrl::creatUrl("/seller/index");?>"><img src="<?php echo $this->getWebSkinPath()."images/main/logo.png";?>" /></a></h1>
			<h2 class="section_title"></h2>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("");?>" target="_blank">网站首页</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("/site/home/id/".$seller_id."");?>" target="_blank">商家主页</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("/systemseller/logout");?>">退出登录</a></div>
		</hgroup>
	</header>
	<!--头部 结束-->

	<!--面包屑导航 开始-->
	<section id="secondary_bar">
		<div class="user">
			<p><?php echo isset($seller_name)?$seller_name:"";?></p>
		</div>
	</section>
	<!--面包屑导航 结束-->

	<!--侧边栏菜单 开始-->
	<aside id="sidebar" class="column">
		<?php foreach(menuSeller::init() as $key => $item){?>
		<h3><?php echo isset($key)?$key:"";?></h3>
		<ul class="toggle">
			<?php foreach($item as $moreKey => $moreValue){?>
			<li><a href="<?php echo IUrl::creatUrl("".$moreKey."");?>"><?php echo isset($moreValue)?$moreValue:"";?></a></li>
			<?php }?>
		</ul>
		<?php }?>

		<footer>
			<hr />
			<p><strong>Copyright &copy; 2010-2017</strong></p>
			<p>Powered by <a href="http://www.dsanke.com">dsanke.com</a></p>
		</footer>
	</aside>
	<!--侧边栏菜单 结束-->

	<!--主体内容 开始-->
	<section id="main" class="column">
		<?php $seller_id = $this->seller['seller_id']?>

<?php $searchParam = http_build_query(Util::getUrlParam('search'))?>

<?php $condition = Util::search(IReq::get('search'));

	$where = $condition ? " and ".$condition : "";

?>

<?php $query = new IQuery("delivery");$items = $query->find(); foreach($items as $key => $item){?>

	<?php $delivery_id=$item['id']?>

	<?php $kuaidi["$delivery_id"] = $item['name']?>

<?php }?>
<style>
	.tab_current{background:#24b408 !important;color:#fff !important;}
</style>
<article class="module width_full">

	<header>

		<h3 class="tabs_involved">定金列表</h3>

		<ul class="tabs">

			<!-- <li><input type="button" class="alt_btn" onclick="filterResult();" value="搜索订单" /></li> -->
			<li><input type="button" class="alt_btn" onclick="javascript:location.href='/seller/order_list'" value="全款订单" /></li>
			<li><input type="button" class="alt_btn" onclick="javascript:location.href='/seller/order_prop_list'" value="推荐订单" /></li>
			<li><input type="button" class="alt_btn tab_current" onclick="javascript:location.href='/seller/order_list2'" value="定金订单" /></li>
			<li><input type="button" class="alt_btn" onclick="javascript:location.href='/seller/order_seat_list'" value="购票订单" /></li>
			<li><input type="button" class="alt_btn" onclick="javascript:location.href='/seller/sale_tixian'" value="帐务中心" /></li>

		</ul>

	</header>



	<table class="tablesorter" cellspacing="0">

		<colgroup>

			<col width="205px" />

			<col width="150px" />

			<col width="120px" />

			<col width="105px" />

			<col width="105px" />

			<col width="105px" />

			<col width="115px" />

			<col width="115px" />

			<col width="115px" />

			<col width="115px" />

			<col />

		</colgroup>

		<thead>

			<tr>

				<th>订单号</th>

				<th>课程名称</th>

				<th>课程属性</th>

				<th>学员姓名</th>

				<th>联系电话</th>

				<th>服务保证金</th>

				<th>未付学费</th>

				<th>课程学费</th>

				<th>订单状态</th>

				<th>下单时间</th>

				<th>入学时间</th>

				<th>提示</th>

				<th>操作</th>

			</tr>

		</thead>



		<tbody>

			<?php $page = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1?>

			<?php $orderObject = new IQuery("order_goods as og");$orderObject->join = "left join goods as go on go.id = og.goods_id left join order as o on o.id = og.order_id";$orderObject->fields = "o.*";$orderObject->page = "$page";$orderObject->where = "o.pay_status = 1 and go.seller_id = $seller_id and o.if_del = 0 and o.statement = 3 and o.status not in(3,4) $where";$orderObject->group = "og.order_id";$orderObject->order = "o.id desc";$items = $orderObject->find(); foreach($items as $key => $item){?>

			<?php $order_status_t = Order_Class::getOrderStatus($item);?>

			<?php $goods_list = Order_Class::get_order_goods_list($item['id'])?>

			<?php $goods = $goods_list[0]?>

			<?php $goods_array = $goods['goods_array']?>

			<tr>

				<td title="<?php echo isset($item['order_no'])?$item['order_no']:"";?>" name="orderStatusColor<?php echo isset($item['status'])?$item['status']:"";?>"><?php echo isset($item['order_no'])?$item['order_no']:"";?></td>

				<td><a href="<?php echo IUrl::creatUrl("/site/products/id/".$goods['goods_id']."");?>" target="_blank"><?php echo $goods_array->name;?></a></td>

				<td><?php echo $goods_array->value;?></td>

				<td title="<?php echo isset($item['accept_name'])?$item['accept_name']:"";?>"><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td>

				<td title="<?php echo isset($item['mobile'])?$item['mobile']:"";?>"><?php echo isset($item['mobile'])?$item['mobile']:"";?></td>

				<td><?php echo number_format($goods['cost_price'] - $item['rest_price'], 2, '.', '');?></td>

				<td><?php echo isset($item['rest_price'])?$item['rest_price']:"";?></td>

				<td><?php echo isset($goods['cost_price'])?$goods['cost_price']:"";?></td>

				<td><b class="<?php if($order_status_t >= 6){?>green<?php }else{?>orange<?php }?>"><?php echo order_class::orderStatusText(order_class::getOrderStatus($item),2, $item['statement']);?></b></td>

				<td title="<?php echo isset($item['create_time'])?$item['create_time']:"";?>"><?php echo  date('Y-m-d H:i', strtotime($item['create_time']));?></td>

				<td><?php echo date('Y-m-d',$item['choose_date']);?></td>

				<td><?php echo order_class::get_order_notice(order_class::getOrderStatus($item),2);?></td>

				<td>

					<?php if(in_array( order_class::getOrderStatus( $item ), array(4))){?>

						<a href="<?php echo IUrl::creatUrl("/seller/order_finish/order_id/".$item['id']."");?>">确认收款</a>

					<?php }?>

					<a href="<?php echo IUrl::creatUrl("/seller/order_show_ding/id/".$item['id']."");?>">详情</a>

				</td>

			</tr>

			<?php }?>

		</tbody>

	</table>

	<?php echo $orderObject->getPageBar();?>

</article>



<script type="text/html" id="orderTemplate">

	<form action="<?php echo IUrl::creatUrl("/");?>" method="get" name="filterForm">

		<input type='hidden' name='controller' value='seller' />

		<input type='hidden' name='action' value='order_list2' />

		<div class="module_content">

			<fieldset>

				<label>订单号</label>

				<input name="search[order_no=]" value="" type="text" />

			</fieldset>



			<fieldset>

				<label>学员姓名</label>

				<input name="search[accept_name=]" value="" type="text" />

			</fieldset>



			<fieldset>

				<label>选择支付状态</label>

				<select name="search[pay_status=]">

					<option value="">全部</option>

					<option value="0">未支付</option>

					<option value="1">已支付</option>

					<option value="2">退款成功</option>

				</select>

			</fieldset>



			<fieldset>

				<label>选择发货状态</label>

				<select name="search[distribution_status=]">

					<option value="">全部</option>

					<option value="0">未进行</option>

					<option value="1">已完成</option>

					<option value="2">部分完成</option>

				</select>

			</fieldset>



			<fieldset>

				<label>订单状态</label>

				<select name="search[o.status=]">

					<option value="">全部</option>

					<option value="1">新订单</option>

					<option value="2">确认订单</option>

					<option value="3">取消订单</option>

					<option value="4">作废订单</option>

					<option value="5">完成订单</option>

				</select>

			</fieldset>

		</div>

	</form>

</script>



<script language="javascript">

	//检索课程

	function filterResult(){

		var ordersHeadHtml = template.render('orderTemplate');

		art.dialog(	{		"init":function()

		{

			var filterPost = <?php echo JSON::encode(IReq::get('search'));?>;

			var formObj = new Form('filterForm');

			for(var index in filterPost)

			{

				formObj.setValue("search["+index+"]",filterPost[index]);

			}

		},

		"title":"检索条件",

		"content":ordersHeadHtml,

		"okVal":"立即检索",

		"ok":function(iframeWin, topWin)

		{

			iframeWin.document.forms[0].submit();

		}

	});

}



//DOM加载结束

$(function(){

	//高亮色彩

	$('[name="payStatusColor1"]').addClass('green');

	$('[name="disStatusColor1"]').addClass('green');

	$('[name="orderStatusColor3"]').addClass('red');

	$('[name="orderStatusColor4"]').addClass('red');

	$('[name="orderStatusColor5"]').addClass('green');

});

</script>


	</section>
	<!--主题内容 结束-->

	<script type="text/javascript">
	//菜单图片ICO配置
	function menuIco(val)
	{
		var icoConfig = {
			"管理首页" : "icn_tags",
			"销售额统计" : "icn_settings",
			"货款明细列表" : "icn_categories",
			"货款结算申请" : "icn_photo",
			"商品列表" : "icn_categories",
			"添加商品" : "icn_new_article",
			"平台共享商品" : "icn_photo",
			"商品咨询" : "icn_audio",
			"商品评价" : "icn_audio",
			"商品退款" : "icn_audio",
			"规格列表" : "icn_categories",
			"订单列表" : "icn_categories",
			"团购" : "icn_view_users",
			"促销活动列表" : "icn_categories",
			"物流配送" : "icn_folder",
			"发货地址" : "icn_jump_back",
			"资料修改" : "icn_profile",
		};
		return icoConfig[val] ? icoConfig[val] : "icn_categories";
	}

	$(".toggle>li").each(function()
	{
		$(this).addClass(menuIco($(this).text()));
	});
	</script>
</body>
</html>