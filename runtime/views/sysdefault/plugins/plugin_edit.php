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
			<div class="headbar">
	<div class="position"><span>工具</span><span>></span><span>插件管理</span><span>></span><span>配置插件</span></div>
</div>

<div class="content_box">
	<div class="content">
		<form action="<?php echo IUrl::creatUrl("/plugins/plugin_update");?>" method="post">
			<input type='hidden' name='class_name' value='' />
			<table class="form_table" cellpadding="0" cellspacing="0">
				<colgroup>
					<col width="200px" />
					<col />
				</colgroup>

				<tr>
					<th>插件名称：</th>
					<td><?php echo isset($this->pluginRow['name'])?$this->pluginRow['name']:"";?></td>
				</tr>

				<tr>
					<th>插件简述：</th>
					<td><?php echo isset($this->pluginRow['description'])?$this->pluginRow['description']:"";?></td>
				</tr>

				<?php if($this->pluginRow['explain']){?>
				<tr>
					<th>使用说明：</th>
					<td><?php echo isset($this->pluginRow['explain'])?$this->pluginRow['explain']:"";?></td>
				</tr>
				<?php }?>

				<tr>
					<th>插件排序：</th><td><input class="small" name="sort" type="text" value="" pattern="required" alt="排序不能为空！" /></td>
				</tr>

				<tr>
					<th>插件状态：</th>
					<td>
						<label class='attr'><input name="is_open" type="radio" value="1" checked="checked" />开启</label>
						<label class='attr'><input name="is_open" type="radio" value="0" />关闭</label>
					</td>
				</tr>
				<tr>
					<th></th>
					<td>
						<button class="submit" type='submit'><span>确 定</span></button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<!--数据录入模板-->
<script type='text/html' id='paramTemplate'>
<%for(var item in templateData){%>
<%var key = item;%>
<%var item = templateData[item];%>
<%var valueItems = item['value'];%>
<tr>
	<th><%=item["name"]%>：</th>
	<td>
		<%if(item['type'] == "radio"){%>
			<%for(var tempKey in valueItems){%>
			<%tempVal = valueItems[tempKey]%>
				<label class="attr"><input type="radio" name="<%=key%>" value="<%=tempVal%>" /><%=tempKey%></label>
			<%}%>
		<%}else if(item['type'] == "checkbox"){%>
			<%for(var tempKey in valueItems){%>
			<%tempVal = valueItems[tempKey]%>
				<label class="attr"><input type="checkbox" name="<%=key%>[]" value="<%=tempVal%>" /><%=tempKey%></label>
			<%}%>
		<%}else if(item['type'] == "select"){%>
			<select class="auto" name="<%=key%>" pattern="<%=item['pattern']%>">
			<%for(var tempKey in valueItems){%>
			<%tempVal = valueItems[tempKey]%>
			<option value="<%=tempVal%>"><%=tempKey%></option>
			<%}%>
			</select>
		<%}else if(item['type'] == "text"){%>
			<input type="text" name="<%=key%>" value="<%=item['value']%>" class="normal" pattern="<%=item['pattern']%>" />
		<%}%>

		<%if(item['info']){%>
			<label><%=item['info']%></label>
		<%}%>
	</td>
</tr>
<%}%>
</script>

<script language="javascript">
//DOM加载完毕
$(function()
{
	//加载插件配置
	var paramHtml = template.render('paramTemplate',{'templateData':<?php echo JSON::encode($this->pluginRow['config_name']);?>});
	$('.form_table tr:eq(1)').after(paramHtml);

	//数据加载
	var formInstance = new Form();
	formInstance.init(<?php echo JSON::encode($this->pluginRow['config_param']);?>);
	formInstance.init(<?php echo JSON::encode($this->pluginRow);?>);
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
