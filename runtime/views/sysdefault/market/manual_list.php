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

	<script src="/resource/scripts/bootstrap/bootstrap.min.js"></script>
	<script src="/resource/scripts/bootstrap/bootstrp-selelct/js/bootstrap-select.js"></script>
	<link rel="stylesheet" href="/resource/scripts/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="/resource/scripts/bootstrap/bootstrp-selelct/css/bootstrap-select.css">
	<style>
	.container {width:100%;}
	.btn {height:20px;}
	.bootstrap-select > .dropdown-toggle {width:80%;}
	button span {background: none;}
	* {box-sizing:inherit;}
	#menu {background:none;}
	.bootstrap-select.btn-group .dropdown-toggle .caret {display:none;}
	</style>
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
			<script type="text/javascript" src="/resource/scripts/layer/layer.js"></script>
<link rel="stylesheet" href="/resource/scripts/layer/skin/layer.css" />
<div class="headbar">
	<div class="position"><span>营销</span><span>></span><span>教育手册</span><span>></span><span>手册列表</span></div>
	<div class="searchbar">
		<form action="<?php echo IUrl::creatUrl("/");?>" method="get" name="searchListForm">
			<input type='hidden' name='controller' value='market' />
			<input type='hidden' name='action' value='manual_list' />
			<select class="auto" name="search[user_id]">
				<option value="">选择用户</option>
				<?php foreach($manual_user_list as $key => $item){?>
				<option value="<?php echo isset($item['user_id'])?$item['user_id']:"";?>" <?php if($search['user_id'] == $item['user_id']){?>selected<?php }?>><?php echo isset($item['username'])?$item['username']:"";?></option>
				<?php }?>
			</select>
			<select class="auto" name="search[is_activation]">
				<option value="">是否激活</option>
				<option value="1" <?php if($search[is_activation] == 1){?>selected<?php }?>>已激活</option>
				<option value="2" <?php if($search[is_activation] == 2){?>selected<?php }?>>未激活</option>
			</select>
			<button class="btn" type="submit"><span class="sel">过 滤</span></button>
			<button class="btn" type="button" onclick="add_manual();"><span class="sel">添加手册</span></button>
		</form>
	</div>
</div>
<div class="content">
	<form method='post' action='#'>
		<table class="list_table">
			<colgroup>
				<col width="40px" />
				<col width="120px" />
				<col width="70px" />
				<col width="70px" />
				<col width="70px" />
				<col width="70px" />
				<col width="140px" />
			</colgroup>

			<thead>
				<tr>
					<th>选择</th>
					<th>绑定用户</th>
					<th>激活时间</th>
					<th>过期时间</th>
					<th>激活码</th>
					<th>是否激活</th>
					<th>下载激活二维码</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($manual_list as $key => $item){?>
				<tr>
					<td></td>
					<td><?php echo ($item['username']) ? $item['username'] : '无';?></td>
					<td><?php if($item['is_activation']){?><?php echo date('Y-m-d',$item['start_time']);?><?php }else{?><?php }?></td>
					<td><?php if($item['is_activation']){?><?php echo date('Y-m-d',$item['end_time']);?><?php }else{?><?php }?></td>
					<td><?php echo isset($item['activation_code'])?$item['activation_code']:"";?></td>
					<td><?php echo  ($item['is_activation']) ? '已激活' : '未激活';?></td>
					<td><a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/plugins/phpqrcode/index.php?data=http://www.dsanke.com/site/manual_activation/code/<?php echo isset($item['activation_code'])?$item['activation_code']:"";?>" target="_blank">点击查看</a></td>
				</tr>
				<?php }?>
				<?php if($page_info){?>
				<tr>
					<td colspan="7"><?php echo isset($page_info)?$page_info:"";?></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</form>
</div>

<script type='text/javascript'>
function add_manual()
{
	layer.prompt({title: '请输入要添加的数量（最多100个）', formType: 0}, function(value, index, elem){
  	layer.close(index);
		var nums = parseInt(value);
		if ( nums <= 0 || nums > 1000 )
		{
			layer.alert('参数不正确');
		} else {
			var url = '<?php echo IUrl::creatUrl("/market/create_manual/nums/@nums@");?>';
			url = url.replace('@nums', nums);
			location.href = url;
		}
	});
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
