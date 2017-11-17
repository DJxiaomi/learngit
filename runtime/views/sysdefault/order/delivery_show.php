<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>后台管理</title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/admin.css";?>" />
	<meta name="robots" content="noindex,nofollow">
	<link rel="shortcut icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/common.js";?>"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/admin.js";?>"></script>
</head>
<body>
	<div class="container">
		<div id="header">
			<div class="logo">
				<a href="<?php echo IUrl::creatUrl("/system/default");?>"><img src="<?php echo $this->getWebSkinPath()."images/admin/logo.png";?>" width="303" height="43" /></a>
			</div>
			<div id="menu">
				<ul name="topMenu">
					<?php $menuData=menu::init($this->admin['role_id']);?>
					<?php foreach(menu::getTopMenu($menuData) as $key => $item){?>
					<li>
						<a hidefocus="true" href="<?php echo IUrl::creatUrl("".$item."");?>"><?php echo isset($key)?$key:"";?></a>
					</li>
					<?php }?>
				</ul>
			</div>
			<p><a href="<?php echo IUrl::creatUrl("/systemadmin/logout");?>">退出管理</a> <a href="<?php echo IUrl::creatUrl("/system/admin_repwd");?>">修改密码</a> <a href="<?php echo IUrl::creatUrl("/system/default");?>">后台首页</a> <a href="<?php echo IUrl::creatUrl("");?>" target='_blank'>商城首页</a> <span>您好 <label class='bold'><?php echo isset($this->admin['admin_name'])?$this->admin['admin_name']:"";?></label>，当前身份 <label class='bold'><?php echo isset($this->admin['admin_role_name'])?$this->admin['admin_role_name']:"";?></label></span></p>
		</div>
		<div id="info_bar">
			<label class="navindex"><a href="<?php echo IUrl::creatUrl("/system/navigation");?>">快速导航管理</a></label>
			<span class="nav_sec">
			<?php $query = new IQuery("quick_naviga");$query->where = "admin_id = {$this->admin['admin_id']} and is_del = 0";$items = $query->find(); foreach($items as $key => $item){?>
			<a href="<?php echo isset($item['url'])?$item['url']:"";?>" class="selected"><?php echo isset($item['naviga_name'])?$item['naviga_name']:"";?></a>
			<?php }?>
			</span>
		</div>

		<div id="admin_left">
			<ul class="submenu">
				<?php $leftMenu=menu::get($menuData,IWeb::$app->getController()->getId().'/'.IWeb::$app->getController()->getAction()->getId())?>
				<?php foreach(current($leftMenu) as $key => $item){?>
				<li>
					<span><?php echo isset($key)?$key:"";?></span>
					<ul name="leftMenu">
						<?php foreach($item as $leftKey => $leftValue){?>
						<li><a <?php if(stripos($leftKey,"javascript:")===0){?>href="javascript:void(0)" onclick="<?php echo isset($leftKey)?$leftKey:"";?>" <?php }else{?> href="<?php echo IUrl::creatUrl("".$leftKey."");?>"<?php }?>><?php echo isset($leftValue)?$leftValue:"";?></a></li>
						<?php }?>
					</ul>
				</li>
				<?php }?>
			</ul>
			<div id="copyright"></div>
		</div>

		<div id="admin_right">
			<div class="headbar clearfix">
	<div class="position">订单<span>></span><span>单据管理</span><span>></span><span>发货单信息</span></div>
</div>
<div class="content">
	<table width="98%" class="border_table" style="margin:10px auto">
		<tbody>
			<tr>
				<th>订单号：</th><td><?php echo isset($order_no)?$order_no:"";?></td><th>配送方式：</th><td><?php echo isset($pname)?$pname:"";?></td><th>订单时间：</th><td><?php echo isset($create_time)?$create_time:"";?></td>
			</tr>
			<tr>
				<th>操作员：</th><td><?php echo isset($admin)?$admin:"";?></td><th>会员名：</th><td><?php echo isset($username)?$username:"";?></td><th>收货人：</th><td><?php echo isset($name)?$name:"";?></td>
			</tr>
			<tr>
				<th>收货地区：</th><td><?php echo isset($country)?$country:"";?></td><th>收货地址：</th><td><?php echo isset($address)?$address:"";?></td><th>邮编：</th><td><?php echo isset($postcode)?$postcode:"";?></td>
			</tr>
			<tr>
				<th>电话：</th><td><?php echo isset($telphone)?$telphone:"";?></td><th>手机：</th><td><?php echo isset($mobile)?$mobile:"";?></td><th>运费：</th><td><?php echo isset($freight)?$freight:"";?></td>
			</tr>
			<tr>
				<th>物流单号：</th><td><?php echo isset($delivery_code)?$delivery_code:"";?></td><th>生成时间:</th><td colspan="3"><?php echo isset($time)?$time:"";?></td>
			</tr>
			<tr>
				<th>备注：</th><td colspan="5"><?php echo isset($note)?$note:"";?></td>
			</tr>
		</tbody>
	</table>
	<table width="98%" class="border_table" style="margin:10px auto">
		<col />
		<col width="150px" />
		<thead>
			<tr>
				<th>商品名称</th>
				<th>商品数量</th>
			</tr>
		</thead>
		<tbody>
			<?php $query = new IQuery("order_goods");$query->where = "delivery_id = $id";$items = $query->find(); foreach($items as $key => $item){?>
			<?php $goodsRow = JSON::decode($item['goods_array'])?>
			<tr>
				<td>
					<?php echo isset($goodsRow['name'])?$goodsRow['name']:"";?> &nbsp;&nbsp; <?php echo isset($goodsRow['value'])?$goodsRow['value']:"";?>
				</td>
				<td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
</div>
		</div>
	</div>

	<script type='text/javascript'>
	//隔行换色
	$(".list_table tr:nth-child(even)").addClass('even');
	$(".list_table tr").hover(
		function () {
			$(this).addClass("sel");
		},
		function () {
			$(this).removeClass("sel");
		}
	);

	//按钮高亮
	var topItem  = "<?php echo key($leftMenu);?>";
	$("ul[name='topMenu']>li:contains('"+topItem+"')").addClass("selected");

	var leftItem = "<?php echo IUrl::getUri();?>";
	$("ul[name='leftMenu']>li a[href^='"+leftItem+"']").parent().addClass("selected");
	</script>
</body>
</html>
