<?php $menuData=menu::init($this->admin['role_id']);?>
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
			<?php $adminId = $this->admin['admin_id']?>
			<?php $query = new IQuery("quick_naviga");$query->where = "admin_id = $adminId and is_del = 0";$items = $query->find(); foreach($items as $key => $item){?>
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
						<li><a href="<?php echo IUrl::creatUrl("".$leftKey."");?>"><?php echo isset($leftValue)?$leftValue:"";?></a></li>
						<?php }?>
					</ul>
				</li>
				<?php }?>
			</ul>
			<div id="copyright"></div>
		</div>

		<div id="admin_right">
			<style>
.hide { display: none;}
.price { color: #ff5500;font-family:"Arial";font-size: 12px;font-weight: 700;}
.t-right {margin-left: 20px;margin-top: 3px;}
</style>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>

<div class="headbar">
	<div class="position">订单<span>></span><span>订单管理</span><span>></span><span>订单列表</span></div>
	<div class="operating">
		<a href="javascript:void(0);"><button class="operating_btn" type="button" onclick="window.location='<?php echo IUrl::creatUrl("/order/order_edit");?>'"><span class="addition">添加订单</span></button></a>
		<a href="javascript:void(0);" onclick="selectAll('id[]')"><button class="operating_btn" type="button"><span class="sel_all">全选</span></button></a>
		<a href="javascript:void(0);" onclick="delModel({form:'orderForm'})"><button class="operating_btn" type="button"><span class="delete">批量删除</span></button></a>
		<a href="javascript:void(0);" onclick="$('#orderForm').attr('action','<?php echo IUrl::creatUrl("/order/expresswaybill_template");?>');$('#orderForm').submit();"><button class="operating_btn"><span class="export">批量打印快递单</span></button></a>
		<a href="javascript:void(0);"><button class="operating_btn" onclick="location.href='<?php echo IUrl::creatUrl("/order/print_template");?>'"><span class="export">单据模板</span></button></a>
		<a href="javascript:void(0);"><button class="operating_btn" type="button" onclick="location.href='<?php echo IUrl::creatUrl("/order/order_recycle_list");?>'"><span class="recycle">回收站</span></button></a>
	</div>
	<div class="searchbar">
		<form action="<?php echo IUrl::creatUrl("/");?>" method="get" name="order_list">
			<input type='hidden' name='controller' value='order' />
			<input type='hidden' name='action' value='order_prop_list' />

			从<input type="text" name="search[start_time]" class="small" placeholder="开始时间" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})"/>
			-<input type="text" name="search[end_time]" class="small" placeholder="结束时间" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})"/>
			&nbsp;
			<select name="search[seller_id]" class="auto">
				<option value="">选择类型</option>
				<option value="0">平台自营</option>
				<?php $query = new IQuery("seller");$query->where = "is_del = 0";$items = $query->find(); foreach($items as $key => $item){?>
				<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['true_name'])?$item['true_name']:"";?></option>
				<?php }?>
			</select>

			<select name="search[pay_status]" class="auto">
				<option value="">选择支付状态</option>
				<option value="0">未支付</option>
				<option value="1">已支付</option>
			</select>

			<select name="search[distribution_status]" class="auto hide">
				<option value="">选择发货状态</option>
				<option value="0">未发货</option>
				<option value="1">已发货</option>
				<option value="2">部分发货</option>
			</select>

			<select name="search[status]" class="auto">
				<option value="">选择订单状态</option>
				<option value="1">新订单</option>
				<option value="2">确认订单</option>
				<option value="3">取消订单</option>
				<option value="4">作废订单</option>
				<option value="5">完成订单</option>
				<option value="6">退款</option>
				<option value="7">部分退款</option>
			</select>

			<select class="auto" name="search[name]">
				<option value="">选择订单条件</option>
				<option value="accept_name">收件人姓名</option>
				<option value="order_no">订单号</option>
				<option value="seller_name">商户真实名称</option>
			</select>
			<input class="small" name="search[keywords]" type="text" value="" />
			<button class="btn" type="submit"  onclick='changeAction(false)'><span class="sel">筛 选</span></button>
			<button class="btn" onclick='changeAction(true)'><span class="sel">导出Excel</span></button>
			<span class="t-right">共<?php echo isset($order_count)?$order_count:"";?>条订单，订单总金额为：<span class="price"><?php echo isset($order_amount)?$order_amount:"";?></span>元
		</form>
	</div>
</div>

<form name="orderForm" id="orderForm" action="<?php echo IUrl::creatUrl("/order/order_del");?>" method="post">
	<div>
		<table class="list_table">
			<colgroup>
				<col width="30px" />
				<col width="110px" />
				<col width="130px" />
				<col width="60px" />
				<col width="70px" />
				<col width="70px" />
				<col width="140px" />
				<col width="75px" />
				<col width="75px" />
				<col width="110px" />
				<col width="115px" />
			</colgroup>

			<thead>
				<tr>
					<th>选择</th>
					<th>订单号</th>
					<th>学校名称</th>
					<th>用户名</th>
					<th>姓名</th>
					<th>订单金额</th>
					<th>下单时间</th>
					<th>订单状态</th>
					<th>结算类型</th>
					<th class="hide">打印</th>
					<th>支付方式</th>
					<th>操作</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($order_list as $key => $item){?>
				<tr>
					<td><input name="id[]" type="checkbox" value="<?php echo isset($item['id'])?$item['id']:"";?>" /></td>
					<td title="<?php echo isset($item['order_no'])?$item['order_no']:"";?>" name="orderStatusColor<?php echo isset($item['status'])?$item['status']:"";?>"><a href="<?php echo IUrl::creatUrl("/order/order_show/id/".$item['id']."");?>"><?php echo isset($item['order_no'])?$item['order_no']:"";?></a></td>
					<td><a href="<?php echo IUrl::creatUrl("/site/seller/id/".$item['seller_id']."");?>" target="_blank"><?php echo isset($item['seller_info']['true_name'])?$item['seller_info']['true_name']:"";?></a></td>
					<td><?php echo $item['username']=='' ? '游客' : $item['username'];?></td>
					<td title="<?php echo isset($item['accept_name'])?$item['accept_name']:"";?>"><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td>
					<td class="price">&yen<?php echo isset($item['order_amount'])?$item['order_amount']:"";?></td>
					<td title="<?php echo isset($item['create_time'])?$item['create_time']:"";?>"><?php echo isset($item['create_time'])?$item['create_time']:"";?></td>
					<td><b class="<?php if($item['order_status_t'] >= 6){?>green<?php }else{?>orange<?php }?>"><?php echo isset($item['status_str'])?$item['status_str']:"";?></b></td>
					<td><?php if($item['statement'] == 1){?>全款<?php }elseif($item['statement'] == 2){?>代金券<?php }else{?>定金<?php }?></td>
					<td class="hide">
						<span class="prt" title="购物清单打印" onclick="window.open('<?php echo IUrl::creatUrl("/order/shop_template/id/".$item['id']."");?>');">购</span>
						<span class="prt" title="配货单打印" onclick="window.open('<?php echo IUrl::creatUrl("/order/pick_template/id/".$item['id']."");?>');">配</span>
						<span class="prt" title="联合打印" onclick="window.open('<?php echo IUrl::creatUrl("/order/merge_template/id/".$item['id']."");?>');">合</span>
						<span class="prt" title="快递单打印" onclick="window.open('<?php echo IUrl::creatUrl("/order/expresswaybill_template/id/".$item['id']."");?>');">递</span>
					</td>
					<td><?php echo isset($item['payment_name'])?$item['payment_name']:"";?></td>
					<td>
						<a href="<?php echo IUrl::creatUrl("/order/order_show/id/".$item['id']."");?>"><img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_check.gif";?>" title="查看" /></a>
						<?php if(Order_class::getOrderStatus($item) < 3){?>
						<a href="<?php echo IUrl::creatUrl("/order/order_edit/id/".$item['id']."");?>"><img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_edit.gif";?>" title="编辑"/></a>
						<?php }?>
						<a href="javascript:void(0)" onclick="delModel({link:'<?php echo IUrl::creatUrl("/order/order_del/id/".$item['id']."");?>'})" ><img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_del.gif";?>" title="删除"/></a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
	<?php echo isset($page_info)?$page_info:"";?>
</form>

<script type='text/javascript'>
//DOM加载结束
$(function(){
	var searchData = <?php echo JSON::encode($this->search);?>;
	for(var index in searchData)
	{
		$('[name="search['+index+']"]').val(searchData[index]);
	}

	//高亮色彩
	$('[name="payStatusColor1"]').addClass('green');
	$('[name="disStatusColor1"]').addClass('green');
	$('[name="orderStatusColor3"]').addClass('red');
	$('[name="orderStatusColor4"]').addClass('red');
	$('[name="orderStatusColor5"]').addClass('green');
});
function changeAction(excel)
{
	if (excel){
		$("input[name=\"action\"]").val("order_report");
		$("form[name=\"order_list\"]").attr("target", "_blank");
	}else{
		$("input[name=\"action\"]").val("order_prop_list");
		$("form[name=\"order_list\"]").attr("target", "_self");
	}
}
</script>

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
