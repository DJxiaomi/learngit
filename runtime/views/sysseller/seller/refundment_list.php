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
			<p><strong>Copyright &copy; 2010-2015 iWebShop</strong></p>
			<p>Powered by <a href="http://www.aircheng.com">iWebShop</a></p>
		</footer>
	</aside>
	<!--侧边栏菜单 结束-->

	<!--主体内容 开始-->
	<section id="main" class="column">
		<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<?php $where = Util::search(IReq::get('search'));?>
<article class="module width_full">
	<header>
		<h3 class="tabs_involved">退款列表</h3>
		<ul class="tabs">
			<li><input type="button" class="alt_btn" onclick="filterResult();" value="检索" /></li>
		</ul>
	</header>

	<table class="tablesorter" cellspacing="0">
		<colgroup>
			<col width="160px" />
			<col width="180px" />
			<col />
			<col width="100px" />
			<col width="120px" />
		</colgroup>

		<thead>
			<tr>
				<th>订单号</th>
				<th>申请时间</th>
				<th>退款商品名称</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
		</thead>

		<tbody>
			<?php $seller_id = $this->seller['seller_id']?>
			<?php $page=(isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;?>
			<?php $refundDB = new IQuery("refundment_doc as rd");$refundDB->where = "rd.if_del = 0 and rd.seller_id = $seller_id and $where";$refundDB->order = "id desc";$refundDB->page = "$page";$items = $refundDB->find(); foreach($items as $key => $item){?>
			<tr>
				<td><?php echo isset($item['order_no'])?$item['order_no']:"";?></td>
				<td><?php echo isset($item['time'])?$item['time']:"";?></td>
				<td>
					<?php $query = new IQuery("order_goods");$query->where = "id in ($item[order_goods_id])";$items = $query->find(); foreach($items as $key => $itemGoods){?>
					<?php $goods = JSON::decode($itemGoods['goods_array'])?>
					<p><a href="<?php echo IUrl::creatUrl("/site/products/id/".$itemGoods['goods_id']."");?>" target="_blank"><?php echo isset($goods['name'])?$goods['name']:"";?> X <?php echo isset($itemGoods['goods_nums'])?$itemGoods['goods_nums']:"";?></a></p>
					<?php }?>
				</td>
				<td><?php echo Order_Class::refundmentText($item['pay_status']);?></th>
				<td><a href="<?php echo IUrl::creatUrl("/seller/refundment_show/id/".$item['id']."");?>"><img class="operator" src="<?php echo $this->getWebSkinPath()."images/main/icn_settings.png";?>" title="查看" /></a></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	<?php echo $refundDB->getPageBar();?>
</article>

<script type="text/html" id="filterTemplate">
<form action="<?php echo IUrl::creatUrl("/");?>" method="get" name="filterForm">
	<input type='hidden' name='controller' value='seller' />
	<input type='hidden' name='action' value='refundment_list' />
	<div class="module_content">
		<fieldset>
			<label>开始时间：</label>
			<input type="text" name="search[rd.time>=]" onfocus="WdatePicker()" />
		</fieldset>
		<fieldset>
			<label>截止时间：</label>
			<input type="text" name="search[rd.time<=]" onfocus="WdatePicker()" />
		</fieldset>
		<fieldset>
			<label>回复状态：</label>
			<select name="search[rd.pay_status=]">
				<option value="">不限</option>
				<option value="0">申请退款</option>
				<option value="1">退款失败</option>
				<option value="2">退款成功</option>
			</select>
		</fieldset>
    </div>
</form>
</script>

<script type="text/javascript">
//检索商品
function filterResult()
{
	var filterTemplate = template.render('filterTemplate');
	art.dialog(
	{
		"init":function()
		{
			var filterPost = <?php echo JSON::encode(IReq::get('search'));?>;
			var formObj = new Form('filterForm');
			for(var index in filterPost)
			{
				formObj.setValue("search["+index+"]",filterPost[index]);
			}
		},
		"title":"检索条件",
		"content":filterTemplate,
		"okVal":"立即检索",
		"ok":function(iframeWin, topWin)
		{
			iframeWin.document.forms[0].submit();
		}
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