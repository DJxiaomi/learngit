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
			<style>
.hide { display: none;}
.price { color: #ff5500;font-family:"Arial";font-size: 12px;font-weight: 700;}
.t-right {margin-left: 20px;margin-top: 3px;}
</style>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>

<div class="headbar">
	<div class="position">营销<span>></span><span>分销推广</span><span>></span><span>推广用户列表</span></div>
	<div class="searchbar">
		<form action="<?php echo IUrl::creatUrl("/");?>" method="get" name="prom_user_list">
			<input type='hidden' name='controller' value='market' />
			<input type='hidden' name='action' value='prom_user_list' />

			从<input type="text" name="search[start_time]" class="small" placeholder="开始时间" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="<?php if($search['start_time']){?><?php echo isset($search['start_time'])?$search['start_time']:"";?><?php }?>" />
			-<input type="text" name="search[end_time]" class="small" placeholder="结束时间" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="<?php if($search['end_time']){?><?php echo isset($search['end_time'])?$search['end_time']:"";?><?php }?>" />
			&nbsp;
			<select name="search[promo_code]" class="auto">
				<option value="">选择推广人</option>
				<?php foreach($promotor_list as $key => $item){?>
				<option value="<?php echo isset($item['promo_code'])?$item['promo_code']:"";?>" <?php if($search['promo_code'] == $item['promo_code']){?>selected<?php }?>><?php echo promotor_class::get_promotor_name_by_promotor_info($item);?></option>
				<?php }?>
			</select>

			<button class="btn" type="submit"  onclick='changeAction(false)'><span class="sel">筛 选</span></button>
		</form>
	</div>
</div>

<form name="orderForm" id="orderForm" action="<?php echo IUrl::creatUrl("/market/prom_user_list");?>" method="post">
	<div>
		<table class="list_table">
			<colgroup>
				<col width="30px" />
				<col width="110px" />
				<col width="110px" />
				<col width="130px" />
				<col width="130px" />
				<col width="130px" />
				<col width="130px" />
			</colgroup>

			<thead>
				<tr>
					<th>选择</th>
					<th>用户名</th>
					<th>联系方式</th>
					<th>注册日期</th>
					<th>消费次数</th>
					<th>推广人</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($member_list as $key => $item){?>
				<tr>
					<td><input name="id[]" type="checkbox" value="<?php echo isset($item['id'])?$item['id']:"";?>" /></td>
					<td><?php echo isset($item['username'])?$item['username']:"";?></td>
					<td><?php echo isset($item['mobile'])?$item['mobile']:"";?></td>
					<td><?php echo isset($item['time'])?$item['time']:"";?></td>
					<td><?php echo isset($item['pay_count'])?$item['pay_count']:"";?></td>
					<td><?php echo isset($item['promotor_name'])?$item['promotor_name']:"";?></td>
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
