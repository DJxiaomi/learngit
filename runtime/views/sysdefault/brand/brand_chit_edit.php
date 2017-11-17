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

<div class="headbar">
	<div class="position"><span>学校</span><span>></span><span>学校管理</span><span>></span><span>学习券</span></div>
</div>
<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/brand/brand_chit_save");?>" method="post" enctype='multipart/form-data'>
			<table class="form_table" cellpadding="0" cellspacing="0">
				<col width="150px" />
				<col />
				<tr>
					<th>类型：</th>
					<td>
						<input type="radio" name="type" value="1"<?php if(!$chit['type'] || $chit['type'] == 1){?> checked<?php }?><?php if($isedit  == 1){?> disabled <?php }?>> 出售
						<input type="radio" name="type" value="2"<?php if($chit['type'] == 2){?> checked<?php }?><?php if($isedit  == 1){?> disabled<?php }?>> 赠送
					</td>
				</tr>
				<tr>
					<th>券值：</th>
					<td><input class="normal" name="max_price" type="text" value="<?php echo isset($chit['max_price'])?$chit['max_price']:"";?>" pattern="required" alt="券值不能为空"<?php if($isedit  == 1){?> disabled<?php }?> />
						<label>*</label>
					</td>
				</tr>
				<tr>
					<th>抵扣值：</th>
					<td><input class="normal" name="max_order_chit" type="text" value="<?php echo isset($chit['max_order_chit'])?$chit['max_order_chit']:"";?>" pattern="required" alt="抵扣值不能为空" maxlength="8"<?php if($isedit  == 1){?> disabled<?php }?> />
						<label>*</label>
					</td>
				</tr>
				<tr style="display:none;">
					<th>满多少使用：</th>
					<td><input class="normal" name="max_order_amount" type="text" value="<?php echo isset($chit['max_order_amount'])?$chit['max_order_amount']:"";?>" maxlength="8"<?php if($isedit  == 1){?> disabled<?php }?> />元
						<label>*</label>
					</td>
				</tr>
				<tr>
					<th>商家返还：</th><td><input class="normal" name="commission" type="text" value="<?php echo isset($chit['commission'])?$chit['commission']:"";?>" /></td>
				</tr>
				<tr>
					<th>结束时间：</th>
					<td><input class="normal" name="limittime" type="text" value="<?php if($chit['limittime']){?><?php echo date('Y-m-d', $chit['limittime']);?><?php }?>" onfocus='WdatePicker()' /> 
					</td>
				</tr>
				<tr>
					<th>限购数量：</th><td><input class="normal" name="limitnum" type="text" value="<?php echo isset($chit['limitnum'])?$chit['limitnum']:"";?>" /></td>
				</tr>
				<tr>
					<th>限购说明：</th><td><input class="normal" name="limitinfo" type="text" value="<?php echo isset($chit['limitinfo'])?$chit['limitinfo']:"";?>" /></td>
				</tr>
				<tr>
					<th>使用说明：</th><td><textarea name="content" id="content" style="width:700px;height:200px;"><?php echo isset($chit['content'])?$chit['content']:"";?></textarea></td>
				</tr>
				<tr>
					<td>
						<input type="hidden" name="isedit" value="<?php echo isset($isedit)?$isedit:"";?>" />
						<input type="hidden" name="id" value="<?php echo isset($chit['id'])?$chit['id']:"";?>" />
						<input type="hidden" name="brand_id" id="brand_id" value="<?php echo isset($chit['brand_id'])?$chit['brand_id']:"";?>" />
						<button class="submit" type="submit"><span>确 定</span></button>
					</td>
				</tr>
			</table>
		</form>
	</div>
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
