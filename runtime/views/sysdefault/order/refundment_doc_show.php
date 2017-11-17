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
	<div class="position"><span>订单</span><span>></span><span>单据管理</span><span>></span><span>退款单申请信息</span></div>
</div>

<div class="content">
	<form method="post" action="<?php echo IUrl::creatUrl("/order/refundment_doc_show_save");?>">
		<input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>"/>
		<table class="border_table" width="100%" style="margin:10px auto">
			<colgroup>
				<col width="200px" />
				<col />
			</colgroup>

			<tbody>
				<tr>
					<th>订单号：</th><td align="left"><?php echo isset($order_no)?$order_no:"";?></td>
				</tr>
				<tr>
					<th>退款商品：</th>
					<td align="left">
						<?php $query = new IQuery("order_goods");$query->where = "id in ($order_goods_id)";$items = $query->find(); foreach($items as $key => $item){?>
						<?php $goods = JSON::decode($item['goods_array'])?>
						<p>
							<?php echo isset($goods['name'])?$goods['name']:"";?> X <?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?>件
							<span class="green">【<?php echo Order_Class::goodsSendStatus($item['is_send']);?>】</span>
							<span class="red">【商品金额：￥<?php echo $item['goods_nums']*$item['real_price'];?>】</span>
							<?php if($seller_id){?>
							<a href="<?php echo IUrl::creatUrl("/site/home/id/".$seller_id."");?>" target="_blank"><img src="<?php echo $this->getWebSkinPath()."images/admin/seller_ico.png";?>" /></a>
							<?php }?>
						</p>
						<?php }?>
					</td>
				</tr>
				<tr>
					<th>用户名：</th><td align="left"><?php $query = new IQuery("user");$query->fields = "username";$query->where = "id = $user_id";$items = $query->find(); foreach($items as $key => $item){?><?php echo isset($item['username'])?$item['username']:"";?><?php }?></td>
				</tr>
				<tr>
					<th>联系方式：</th><td align="left"><?php $query = new IQuery("member");$query->fields = "mobile";$query->where = "user_id = $user_id";$items = $query->find(); foreach($items as $key => $item){?><?php echo isset($item['mobile'])?$item['mobile']:"";?><?php }?></td>
				</tr>
				<tr>
					<th>申请时间：</th><td align="left"><?php echo isset($time)?$time:"";?></td>
				</tr>
				<tr>
					<th>退款原因：</th><td align="left"><?php echo isset($content)?$content:"";?></td>
				</tr>
				<tr>
					<th>处理：</th>
					<td align="left">
						<label><input type="radio" name="pay_status" value="2" checked='checked' />同意</label>&nbsp;&nbsp;
						<label><input type="radio" name="pay_status" value="1" />拒绝</label>
					</td>
				</tr>
				<tr>
					<th>处理意见：</th>
					<td align="left">
						<textarea name="dispose_idea" class="normal"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2"><button type="submit" class="submit" onclick="return checkForm()"><span>确 定</span></button></td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<script type="text/javascript">
//退款
function refundment(id,refundsId)
{
	var tempUrl = '<?php echo IUrl::creatUrl("/order/order_refundment/id/@id@/refunds_id/@refunds_id@");?>';
	tempUrl     = tempUrl.replace('@id@',id).replace('@refunds_id@',refundsId);;
	art.dialog.open(tempUrl,{
		id:'refundment',
		cancelVal:'关闭',
		okVal:'退款',
	    title: '订单号:<?php echo isset($order_no)?$order_no:"";?>【退款到余额账户】',
	    ok:function(iframeWin, topWin){
	    	var formObject = iframeWin.document.forms[0];
	    	if(formObject.onsubmit() == false)
	    	{
	    		return false;
	    	}
	    	formObject.submit();
	    	return false;
	    },
	    cancel:function(){
	    	return true;
		}
	});
}

//执行回调处理
function actionCallback(msg)
{
	if(msg)
	{
		alert(msg);
		window.history.go(-1);
		return;
	}
	document.forms[0].submit();
}

//表单提交
function checkForm()
{
	var payValue = $('[name="pay_status"]:checked').val();
	if(payValue == 2)
	{
		refundment(<?php echo isset($order_id)?$order_id:"";?>,<?php echo isset($id)?$id:"";?>);
		return false;
	}
	return true;
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
