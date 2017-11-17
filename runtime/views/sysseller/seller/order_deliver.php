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
		<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/areaSelect/areaSelect.js"></script>
<article class="module width_full">
	<header>
		<h3 class="tabs_involved">确认上课</h3>
	</header>

	<form action="<?php echo IUrl::creatUrl("/seller/order_delivery_doc");?>" method="post" id="deliver_form">
		<input type="hidden" name="order_no" value="<?php echo isset($order_no)?$order_no:"";?>"/>
		<input type="hidden" name="id" value="<?php echo isset($order_id)?$order_id:"";?>"/>
		<input type="hidden" name="user_id" value="<?php echo isset($user_id)?$user_id:"";?>"/>
		<input type="hidden" name="freight" value="<?php echo isset($real_freight)?$real_freight:"";?>" />
		<input type="hidden" name="delivery_type" value="<?php echo isset($distribution)?$distribution:"";?>" />

		<fieldset>
			<table class="tablesorter clear">
				<thead>
					<tr>
						<th>商品名称</th>
						<th>商品价格</th>
						<th>购买数量</th>
						<th onclick="selectAll('sendgoods[]')">选择发货</th>
					</tr>
				</thead>

				<tbody>
					<?php $seller_id = $this->seller['seller_id']?>
					<?php $query = new IQuery("order_goods");$query->where = "order_id = $order_id and seller_id = $seller_id";$items = $query->find(); foreach($items as $key => $item){?>
					<tr>
						<td>
							<?php $goodsRow = JSON::decode($item['goods_array'])?>
							<?php echo isset($goodsRow['name'])?$goodsRow['name']:"";?> &nbsp;&nbsp; <?php echo isset($goodsRow['value'])?$goodsRow['value']:"";?>
						</td>
						<td><?php echo isset($item['real_price'])?$item['real_price']:"";?></td>
						<td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td>
						<td>
							<?php if($item['is_send'] == 0){?>
							<input type="checkbox" name="sendgoods[]" value="<?php echo isset($item['id'])?$item['id']:"";?>" />
							<?php }else{?>
							<?php echo Order_class::goodsSendStatus($item['is_send']);?>
							<?php }?>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</fieldset>

		<fieldset>
			<table class="tablesorter clear">
				<colgroup>
					<col width="120px" />
					<col />
					<col width="120px" />
					<col />
				</colgroup>

				<tbody>
					<tr>
						<th>订单号:</th><td align="left"><?php echo isset($order_no)?$order_no:"";?></td>
						<th>下单时间:</th><td align="left"><?php echo isset($create_time)?$create_time:"";?></td>
					</tr>
					<tr>
						<th>配送方式:</th>
						<td align="left">
							<?php $query = new IQuery("delivery");$query->where = "id = $distribution";$items = $query->find(); foreach($items as $key => $item){?><?php echo isset($item['name'])?$item['name']:"";?><?php }?>
						</td>
						<th>配送费用:</th><td align="left"><?php echo isset($real_freight)?$real_freight:"";?></td>
					</tr>
					<tr>
						<th>保价费用:</th><td align="left">￥<?php echo isset($insured)?$insured:"";?></td>
					</tr>
					<tr>
						<th>收货人姓名:</th><td align="left"><input type="text" class="small" name="name" value="<?php echo isset($accept_name)?$accept_name:"";?>" pattern="required"/></td>
						<th>电话:</th><td align="left"><input type="text" class="small" name="telphone" value="<?php echo isset($telphone)?$telphone:"";?>" pattern="phone" empty /></td>
					</tr>
					<tr>
						<th>手机:</th><td align="left"><input type="text" class="small" name="mobile" value="<?php echo isset($mobile)?$mobile:"";?>" pattern="mobi"/></td>
						<th>邮政编码:</th><td align="left"><input type="text" name="postcode" class="small" value="<?php echo isset($postcode)?$postcode:"";?>" pattern="zip" empty /></td>
					</tr>
					<tr>
						<th>物流公司：</th>
						<td align="left">
							<select name="freight_id" alt="选择物流公司" class="auto">
								<option value="">选择物流公司</option>
								<?php $query = new IQuery("freight_company");$query->where = "is_del = 0";$items = $query->find(); foreach($items as $key => $item){?>
								<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['freight_name'])?$item['freight_name']:"";?></option>
								<?php }?>
							</select>
							<label class="tip">选择物流公司</label>
						</td>
						<th>配送单号:</th><td align="left"><input type="text" class="normal" name="delivery_code" /></td>
					</tr>
					<tr>
						<th>地区:</th>
						<td align="left" colspan="3">
							<select name="province" child="city,area" class="auto"></select>
							<select name="city" child="area" class="auto"></select>
							<select name="area" class="auto"></select>
						</td>
					</tr>
					<tr>
						<th>地址:</th><td align="left" colspan="3"><input type="text" class="normal" name="address" value="<?php echo isset($address)?$address:"";?>" size="50" pattern="required"/></td>
					</tr>
					<tr>
						<th>发货单备注:</th><td align="left" colspan="3"><textarea name="note" class="normal"></textarea></td>
					</tr>
				</tbody>
			</table>
		</fieldset>

		<footer>
			<div class="submit_link">
				<input type="submit" class="alt_btn" value="确 定" onclick="return checkForm()" />
				<input type="reset" value="重 置" />
			</div>
		</footer>
	</form>
</article>

<script type="text/javascript">
//DOM加载完毕
$(function(){
	var areaInstance = new areaSelect('province');
	areaInstance.init({"province":"<?php echo isset($province)?$province:"";?>","city":"<?php echo isset($city)?$city:"";?>","area":"<?php echo isset($area)?$area:"";?>"});
});

//表单提交前检测
function checkForm()
{
	var checkedNum = $('input[name="sendgoods[]"]:checked').length;
	if(checkedNum == 0)
	{
		alert('请选择要确认的课程');
		return false;
	}
	return true;
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
