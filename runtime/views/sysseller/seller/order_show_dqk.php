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
<style>
 header#header h2.section_title{
  width:40%;
 }
</style>
<body>
	<!--头部 开始-->
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="<?php echo IUrl::creatUrl("/seller/index");?>"><img src="<?php echo $this->getWebSkinPath()."images/main/logo.png";?>" /></a></h1>
			<h2 class="section_title"></h2>
			<div class="btn_view_site"><a href="http://www.lelele999.net" target="_blank">管理公众号</a></div>
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
<script type="text/javascript" charset="UTF-8" src="/resource/scripts/layer/layer.js"></script>
<link rel="stylesheet" type="text/css" href="/resource/scripts/layer/skin/layer.css" />

<article class="module width_full">
	<header>
		<h3 class="tabs_involved">短期课订单查看</h3>

		<ul class="tabs" name="menu1">
			<li id="li_1" class="active"><a href="javascript:select_tab('1');">基本信息</a></li>
			<li id="li_2"><a href="javascript:select_tab('2');">收退款记录</a></li>
			<li id="li_3"><a href="javascript:select_tab('3');">发货记录</a></li>
			<li id="li_4"><a href="javascript:select_tab('4');">订单备注</a></li>
			<li id="li_5"><a href="javascript:select_tab('5');">订单日志</a></li>
			<li id="li_6"><a href="javascript:select_tab('6');">订单附言</a></li>
		</ul>
	</header>

	<div class="module_content" id="tab-1">
		<fieldset>
			<?php $orderInstance = new Order_Class();$orderRow = $orderInstance->getOrderShow($id)?>
			<table class="tablesorter clear">
				<colgroup>
					<col width="120px" />
					<col />
				</colgroup>

				<thead>
					<tr><th colspan="2">订单信息</th></tr>
				</thead>
				<tbody>
					<tr>
						<th>订单号:</th><td><?php echo isset($order_no)?$order_no:"";?></td>
					</tr>
					<tr>
						<th>当前状态:</th><td><?php echo order_class::orderStatusText(order_class::getOrderStatus($orderRow));?></td>
					</tr>
					<tr>
						<th>支付状态:</th><td><?php echo order_class::getOrderPayStatusText($orderRow);?></td>
					</tr>
					<tr>
						<th>配送状态:</th><td><?php echo order_class::getOrderDistributionStatusText($orderRow);?></td>
					</tr>
					<tr>
						<th>订单类型:</th><td><?php echo order_class::getOrderTypeText($orderRow);?></td>
					</tr>
					<tr>
						<th>平台货款结算:</th><td><?php if($is_checkout == 1){?>已结算<?php }else{?>未结算<?php }?></td>
					</tr>
				</tbody>
			</table>
		</fieldset>

		<fieldset>
			<table class="tablesorter clear">
				<colgroup>
					<col width="200px" />
					<col width="90px" />
					<col width="90px" />
					<col width="250px" />
					<col />
				</colgroup>

				<thead>
					<tr>
						<th>短期课名称</th>
						<th>价格</th>
						<th>剩余课时</th>
						<th>使用规则</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach($dqk_list as $key => $item){?>
					<tr>
						<td><?php echo isset($item['name'])?$item['name']:"";?></td>
						<td>￥<?php echo isset($item['max_price'])?$item['max_price']:"";?></td>
						<td><?php if($item['availeble_use_times'] > 0 ){?><?php echo floor($item['availeble_use_times'] / $item['each_times']);?>次<?php echo isset($item['availeble_use_times'])?$item['availeble_use_times']:"";?>课时<?php }else{?>0课时<?php }?></td>
						<td><?php echo isset($item['limitinfo'])?$item['limitinfo']:"";?></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</fieldset>

		<fieldset style="display:none;">
			<table class="tablesorter clear">
				<colgroup>
					<col width="120px" />
					<col />
				</colgroup>

				<thead>
					<tr><th colspan="2">订单金额明细</th></tr>
				</thead>

				<tbody>
					<tr>
						<th>商品总额:</th><td>￥<?php echo isset($payable_amount)?$payable_amount:"";?></td>
					</tr>
					<tr>
						<th>配送费用:</th><td>￥<?php echo isset($real_freight)?$real_freight:"";?></td>
					</tr>
					<tr>
						<th>保价费用:</th><td>￥<?php echo isset($insured)?$insured:"";?></td>
					</tr>
					<tr>
						<th>税金:</th><td>￥<?php echo isset($taxes)?$taxes:"";?></td>
					</tr>
					<?php if(isset($prop) && $prop){?>
					<tr>
						<th>代金券:</th><td><?php $query = new IQuery("prop");$query->where = "id = $prop";$items = $query->find(); foreach($items as $key => $item){?><?php echo isset($item['value'])?$item['value']:"";?><?php }?></td>
					</tr>
					<?php }?>
					<tr>
						<th>优惠总额:</th><td>￥<?php echo isset($promotions)?$promotions:"";?></td>
					</tr>
					<tr>
						<th>增加或减少金额:</th>
						<td>
							￥
							<?php if(Order_class::getOrderStatus($orderRow) < 3){?>
							<input type='text' value='<?php echo isset($discount)?$discount:"";?>' class='tiny' onchange='updateDiscount();' name='discount' />
							<?php }else{?>
							<?php echo isset($discount)?$discount:"";?>
							<?php }?>
							<label class='tip'>折扣用" - ",涨价用" + "</label>
						</td>
					</tr>
					<!-- <tr>
						<th>订单总额:</th><td>￥<span id="orderAmount"><?php echo isset($order_amount)?$order_amount:"";?></span></td>
					</tr>
					<tr>
						<th>已支付金额:</th><td><?php $query = new IQuery("collection_doc");$query->where = "order_id = $order_id and if_del = 0";$query->fields = "amount";$items = $query->find(); foreach($items as $key => $item){?>￥<?php echo isset($item['amount'])?$item['amount']:"";?><?php }?></td>
					</tr> -->
				</tbody>
			</table>
		</fieldset>

		<fieldset style="display:none;">
			<table class="tablesorter clear">
				<colgroup>
					<col width="120px" />
					<col />
				</colgroup>

				<thead>
					<tr><th colspan="2">支付和配送信息</th></tr>
				</thead>

				<tbody>
					<tr>
						<th>配送方式:</th><td><?php echo isset($delivery)?$delivery:"";?></td>
					</tr>

					<?php if($takeself){?>
					<tr>
						<th>自提地址:</th>
						<td>
							<?php echo isset($takeself['province_str'])?$takeself['province_str']:"";?>
							<?php echo isset($takeself['city_str'])?$takeself['city_str']:"";?>
							<?php echo isset($takeself['area_str'])?$takeself['area_str']:"";?>
							<?php echo isset($takeself['address'])?$takeself['address']:"";?>
						</td>
					</tr>
					<tr>
						<th>自提联系方式:</th>
						<td>
							座机：<?php echo isset($takeself['phone'])?$takeself['phone']:"";?> &nbsp;&nbsp;
							手机：<?php echo isset($takeself['mobile'])?$takeself['mobile']:"";?>
						</td>
					</tr>
					<?php }?>

					<tr>
						<th>商品重量:</th><td><?php echo isset($goods_weight)?$goods_weight:"";?> g</td>
					</tr>
					<tr>
						<th>支付方式:</th><td><?php echo isset($payment)?$payment:"";?></td>
					</tr>
					<tr>
						<th>是否开票:</th><td><?php if($invoice==0){?>否<?php }else{?>是<?php }?></td>
					</tr>
					<tr>
						<th>发票抬头:</th><td><?php echo isset($invoice_title)?$invoice_title:"";?></td>
					</tr>
					<tr>
						<th>可得积分:</th><td><?php echo isset($point)?$point:"";?></td>
					</tr>
				</tbody>
			</table>
		</fieldset>

		<fieldset>
			<table class="tablesorter clear">
				<colgroup>
					<col width="120px" />
					<col />
				</colgroup>

				<thead>
					<tr><th colspan="2">收货人信息</th></tr>
				</thead>

				<tbody>
					<tr>
						<th>发货日期:</th><td><?php echo isset($send_time)?$send_time:"";?></td>
					</tr>
					<tr>
						<th>姓名:</th><td><?php echo isset($accept_name)?$accept_name:"";?></td>
					</tr>
					<tr>
						<th>电话:</th><td><?php echo isset($telphone)?$telphone:"";?></td>
					</tr>
					<tr>
						<th>手机 :</th><td><?php echo isset($mobile)?$mobile:"";?></td>
					</tr>
					<tr>
						<th>地区:</th><td><?php echo isset($area_addr)?$area_addr:"";?></td>
					</tr>
					<tr>
						<th>地址:</th><td><?php echo isset($address)?$address:"";?></td>
					</tr>
					<tr>
						<th>邮编:</th><td><?php echo isset($postcode)?$postcode:"";?></td>
					</tr>
					<tr>
						<th>送货时间:</th><td><?php echo isset($accept_time)?$accept_time:"";?></td>
					</tr>
				</tbody>
			</table>
		</fieldset>
	</div>

	<div class="module_content" id="tab-2">
		<fieldset>
			<table class="tablesorter clear">
				<colgroup>
					<col width="120px" />
					<col />
				</colgroup>

				<thead>
					<tr><th colspan="2">收款单据</th></tr>
				</thead>

				<tbody>
					<?php $query = new IQuery("collection_doc as c");$query->join = "left join payment as p on c.payment_id = p.id";$query->where = "c.order_id = $order_id";$query->fields = "c.*,p.name";$collectionData = $query->find(); foreach($collectionData as $key => $item){?>
					<tr>
						<th>付款时间：</th><td><?php echo isset($item['time'])?$item['time']:"";?></td>
					</tr>
					<tr>
						<th>金额：</th><td><?php echo isset($item['amount'])?$item['amount']:"";?></td>
					</tr>
					<tr>
						<th>支付方式：</th><td><?php echo isset($item['name'])?$item['name']:"";?></td>
					</tr>
					<tr>
						<th>付款备注：</th><td><?php echo isset($item['note'])?$item['note']:"";?></td>
					</tr>
					<tr>
						<th>状态：</th><td><?php if($item['pay_status']==0){?>准备中<?php }else{?>支付完成<?php }?></td>
					</tr>
					<tr><th colspan="2"></th></tr>
					<?php }?>
				</tbody>
			</table>
		</fieldset>

		<fieldset>
			<table class="tablesorter clear">
				<colgroup>
					<col width="120px" />
					<col />
				</colgroup>

				<thead>
					<tr><th colspan="2">退款单据</th></tr>
				</thead>
				<tbody>
					<?php $query = new IQuery("refundment_doc");$query->where = "order_id = $order_id";$refundmentData = $query->find(); foreach($refundmentData as $key => $item){?>
					<tr>
						<th>退款商品：</th>
						<td>
							<?php $query = new IQuery("order_goods");$query->where = "id in ($item[order_goods_id])";$items = $query->find(); foreach($items as $key => $orderGoodsItem){?>
							<?php $goods = JSON::decode($orderGoodsItem['goods_array'])?>
							<p><a href="<?php echo IUrl::creatUrl("/site/products/id/".$orderGoodsItem['goods_id']."");?>" target="_blank" title="<?php echo isset($goods['name'])?$goods['name']:"";?>"><?php echo isset($goods['name'])?$goods['name']:"";?> X <?php echo isset($orderGoodsItem['goods_nums'])?$orderGoodsItem['goods_nums']:"";?> </a></p>
							<?php }?>
						</td>
					</tr>
					<tr>
						<th>退款金额：</th><td><?php echo isset($item['amount'])?$item['amount']:"";?></td>
					</tr>
					<tr>
						<th>申请时间：</th><td><?php echo isset($item['time'])?$item['time']:"";?></td>
					</tr>
					<tr>
						<th>状态：</th><td><?php echo Order_Class::refundmentText($item['pay_status']);?></td>
					</tr>
					<tr>
						<th>退款理由：</th><td><?php echo isset($item['content'])?$item['content']:"";?></td>
					</tr>
					<tr>
						<th>退款方式：</th><td><?php echo Order_Class::refundWay($item['way']);?></td>
					</tr>
					<tr><th colspan="2"></th></tr>
					<?php }?>
				</tbody>
			</table>
		</fieldset>
	</div>

	<div class="module_content" id="tab-3">
		<fieldset>
			<table class="tablesorter clear">
				<colgroup>
					<col width="150px" />
					<col width="120px" />
					<col width="120px" />
					<col width="150px" />
					<col width="150px" />
					<col />
				</colgroup>

				<thead>
					<tr>
						<th>配送时间</th>
						<th>配送方式</th>
						<th>物流公司</th>
						<th>物流单号</th>
						<th>收件人</th>
						<th>备注</th>
					</tr>
				</thead>

				<tbody>
					<?php $query = new IQuery("delivery_doc as c");$query->join = "left join delivery as p on c.delivery_type = p.id";$query->fields = "c.*,p.name as pname";$query->where = "c.order_id = $order_id";$deliveryData = $query->find(); foreach($deliveryData as $key => $item){?>
					<tr>
						<td><?php echo isset($item['time'])?$item['time']:"";?></td>
						<td><?php echo isset($item['pname'])?$item['pname']:"";?></td>
						<td><?php $query = new IQuery("freight_company");$query->where = "id = $item[freight_id]";$items = $query->find(); foreach($items as $key => $tempFreight){?><?php echo isset($tempFreight['freight_name'])?$tempFreight['freight_name']:"";?><?php }?></td>
						<td><?php echo isset($item['delivery_code'])?$item['delivery_code']:"";?></td>
						<td><?php echo isset($item['name'])?$item['name']:"";?></td>
						<td><?php echo isset($item['note'])?$item['note']:"";?></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</fieldset>
	</div>

	<div class="module_content" id="tab-4">
		<form action="<?php echo IUrl::creatUrl("/seller/order_note");?>" method="post">
		<input type="hidden" name="order_id" value="<?php echo isset($order_id)?$order_id:"";?>"/>
		<fieldset>
			<label>订单备注</label>
			<textarea name="note"><?php echo isset($note)?$note:"";?></textarea>

			<div class="submit_link">
				<input type="submit" class="alt_btn" value="确 定" />
				<input type="reset" value="重 置" />
			</div>
		</fieldset>
		</form>
	</div>

	<div class="module_content" id="tab-5">
		<fieldset>
			<table class="tablesorter clear">
				<colgroup>
					<col width="200px">
					<col width="150px">
					<col width="150px">
					<col width="100px">
					<col />
				</colgroup>
				<thead>
					<tr>
						<th>时间</th>
						<th>操作人</th>
						<th>动作</th>
						<th>结果</th>
						<th>备注</th>
					</tr>
				</thead>
				<tbody>
					<?php $query = new IQuery("order_log as ol");$query->where = "ol.order_id = $order_id";$items = $query->find(); foreach($items as $key => $item){?>
					<tr>
						<td><?php echo isset($item['addtime'])?$item['addtime']:"";?></td>
						<td><?php echo isset($item['user'])?$item['user']:"";?></td>
						<td><?php echo isset($item['action'])?$item['action']:"";?></td>
						<td><?php echo isset($item['result'])?$item['result']:"";?></td>
						<td><?php echo isset($item['note'])?$item['note']:"";?></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</fieldset>
	</div>

	<div class="module_content" id="tab-6">
		<fieldset>
			<label>订单附言</label>
			<div class="box"><?php echo isset($postscript)?$postscript:"";?></div>
		</fieldset>
	</div>
</article>

<script type='text/javascript'>

var pay_status = '<?php echo isset($pay_status)?$pay_status:"";?>';
var _update_dqk_ajax = '<?php echo IUrl::creatUrl("/seller/update_dqk_status");?>';
var _order_id = <?php echo isset($order_id)?$order_id:"";?>;

//DOM加载完毕后运行
$(function()
{
	select_tab(1);
	$('.confirm_dqk').click(function(){
		var _id = $(this).attr('id');
		layer.confirm('您确定用户已经使用了短期课吗？', {
		  btn: ['确定','取消'] //按钮
		}, function(){
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
		}, function(){
		});
	})
});

//选择当前Tab
function select_tab(curr_tab)
{
	$("div.module_content").hide();
	$("#tab-"+curr_tab).show();
	$("ul[name=menu1] > li").removeClass('active');
	$('#li_'+curr_tab).addClass('active');
}

//快递跟踪
function freightLine(doc_id)
{
	var urlVal = "<?php echo IUrl::creatUrl("/block/freight/id/@id@");?>";
	urlVal = urlVal.replace("@id@",doc_id);
	art.dialog.open(urlVal,{title:'轨迹查询',width:'600px',height:'500px'});
}

//修改订单价格
function updateDiscount()
{
	var order_id = <?php echo isset($id)?$id:"";?>;
	var discount = $('input[name="discount"]').val();
	$.getJSON("<?php echo IUrl::creatUrl("/seller/order_discount");?>",{'order_id':order_id,'discount':discount},function(json)
	{
		if(json.result == true)
		{
			tips('价格修改成功');
			$('#orderAmount').text(json.orderAmount);
			$('#orderAmount').addClass("red");
			return;
		}
		tips('价格修改失败');
	});
}
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