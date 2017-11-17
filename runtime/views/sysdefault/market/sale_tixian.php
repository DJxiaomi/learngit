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
			<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<style>
.num {
	font-size: 14px;
	color: red;
}
.list_table a {
	display: block;
	background: url(/views/sysdefault/skin/default/images/admin/admin_bg.gif) 0 -250px no-repeat;
	float: left;
	width: 50px;
	height: 22px;
	line-height: 22px;
	color: #fff;
	text-align: center;
}
.list_table a.deny {
	background: url(/views/sysdefault/skin/default/images/admin/admin_bg.gif) 0 -191px no-repeat;
	color: #000;
	margin-left: 10px;
	border: 1px solid #ccc;
}
</style>

<div class="headbar">
	<div class="position"><span>统计</span><span>></span><span>商户数据统计</span><span>></span><span>货款结算列表</span></div>
	<div class="operating">
		<div class="search f_l">
			<form name="searchBill" action="<?php echo IUrl::creatUrl("/");?>" method="get">
				<input type='hidden' name='controller' value='market' />
				<input type='hidden' name='action' value='fanli_tixian' />

				<span>
				商家名称
				<input type="text" class="small" name="search[seller_name=]" />
				</span>

				<select class="auto" name="search[status=]">
					<option value="" selected="selected">结算状态</option>
					<option value="0">未处理</option>
					<option value="1">已同意</option>
					<option value="2">已拒绝</option>
				</select>

				<button class="btn" type="submit"><span class="sch">搜 索</span></button>
			</form>
		</div>
	</div>
</div>

<div class="content">
	<table class="list_table">
		<colgroup>
			<col width="30px" />
			<col width="" />
			<col width="100px" />
			<col width="100px" />
			<col width="155px" />
			<col width="120px" />
			<col width="155px" />
			<col width="155px" />
			<col width="100px" />
		</colgroup>

		<thead>
			<tr>
				<th></th>
				<th>商户名称</th>
				<th>账户类型</th>
				<th>银行名称</th>
				<th>开户支行</th>
				<th>收款姓名</th>
				<th>收款帐号</th>
				<th>提现金额</th>
				<th>申请时间</th>
				<th>处理时间</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($sale_tixian_list as $key => $item){?>
			<tr>
				<td></td>
				<td><?php echo isset($item['true_name'])?$item['true_name']:"";?></td>
				<td><?php if($item['bank'] == 1){?>银行<?php }else{?>支付宝<?php }?></td>
				<td><?php if($item['account_bank_name']){?><?php echo isset($item['account_bank_name'])?$item['account_bank_name']:"";?><?php }else{?>-<?php }?></td>
				<td><?php if($item['account_bank_branch']){?><?php echo isset($item['account_bank_branch'])?$item['account_bank_branch']:"";?><?php }else{?>-<?php }?></td>
				<td><?php if($item['bank'] == 1){?><?php echo isset($item['account_name'])?$item['account_name']:"";?><?php }else{?><?php echo isset($item['alipayname'])?$item['alipayname']:"";?><?php }?></td>
				<td><?php if($item['bank'] == 1){?><?php echo isset($item['account_cart_no'])?$item['account_cart_no']:"";?><?php }else{?><?php echo isset($item['alipaysn'])?$item['alipaysn']:"";?><?php }?></td>
				<td class="brown num"><b><?php echo isset($item['num'])?$item['num']:"";?></b></td>
				<td><?php echo date('Y-m-d H:m',$item['create_time']);?></td>
				<td>
					<?php if($item['end_time']>0){?>
						<?php echo date('Y-m-d H:m',$item['end_time']);?>
					<?php }?>
				</td>
				<td>
					<?php if($item['status'] == 1){?>
						<label class="green">已同意</label>
					<?php }elseif($item['status'] == 2){?>
						<label class="red">已驳回</label>
					<?php }else{?>
						<label class="orange">未处理</label>
					<?php }?>
				</td>
				<td>
					<?php if($item['status'] == 0){?>
					<a href="<?php echo IUrl::creatUrl("/market/sale_work/id/".$item['id']."/result/1");?>">
						同意
					</a>
					<?php }?>
				</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
</div>
<?php echo isset($page_info)?$page_info:"";?>

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
