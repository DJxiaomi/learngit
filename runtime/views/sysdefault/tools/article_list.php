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
	<div class="position"><span>工具</span><span>></span><span>文章管理</span><span>></span><span>文章列表</span></div>
	<div class="operating">
		<a href="javascript:void(0)" onclick="event_link('<?php echo IUrl::creatUrl("/tools/article_edit");?>')"><button class="operating_btn" type="button"><span class="addition">添加文章</span></button></a>
		<a href="javascript:void(0)" onclick="selectAll('id[]');"><button class="operating_btn" type="button"><span class="sel_all">全选</span></button></a>
		<a href="javascript:void(0)" onclick="delModel();"><button class="operating_btn" type="button"><span class="delete">批量删除</span></button></a>
	</div>
	<div class="searchbar">
		<form action="<?php echo IUrl::creatUrl("/");?>" method="get" name="searchListForm">
			<input type='hidden' name='controller' value='tools' />
			<input type='hidden' name='action' value='article_list' />
			<select class="auto" name="search[cat_id]">
				<option value="0">选择文章分类</option>
				<?php foreach($cat_list as $key => $item){?>
				<option value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($search['cat_id'] == $item['id']){?>selected<?php }?>><?php echo isset($item['name'])?$item['name']:"";?></option>
				<?php if($item['child']){?>
					<?php foreach($item['child'] as $key => $it){?>
						<option value="<?php echo isset($it['id'])?$it['id']:"";?>" <?php if($search['cat_id'] == $it['id']){?>selected<?php }?>><?php echo isset($item['name'])?$item['name']:"";?> - <?php echo isset($it['name'])?$it['name']:"";?></option>
					<?php }?>
				<?php }?>
				<?php }?>
				<option value="!=0">商户商品</option>
			</select>
			<input class="small" name="search[keywords]" type="text" value="<?php if($search['keywords']){?><?php echo isset($search['keywords'])?$search['keywords']:"";?><?php }?>" />

			<!--分类数据显示-->
			<span id="__categoryBox" style="margin-bottom:8px"></span>
			<button class="btn" type="submit"  onclick='changeAction(false)'><span class="sel">筛 选</span></button>
			<input type="hidden" name="search[adv_search]" value="" />
			<input type="hidden" name="search[brand_id]" value="" />
			<input type="hidden" name="search[sell_price]" value="" />
			<input type="hidden" name="search[create_time]" value="" />
		</form>
	</div>
</div>
<div class="content">
	<form action="<?php echo IUrl::creatUrl("/tools/article_del");?>" method="post" name="article">
		<table class="list_table">
			<colgroup>
				<col width="40px" />
				<col width="250px" />
				<col width="100px" />
				<col width="150px" />
				<col width="60px" />
				<col width="60px" />
				<col width="60px" />
				<col width="110px" />
			</colgroup>

			<thead>
				<tr>
					<th>选择</th>
					<th>标题</th>
					<th>文章分类</th>
					<th>发布时间</th>
					<th>展示</th>
					<th>首页推荐</th>
					<th>排序</th>
					<th>操作</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($article_list as $key => $item){?>
				<tr>
					<td><input type="checkbox" name="id[]" value="<?php echo isset($item['id'])?$item['id']:"";?>" /></td>
					<td><a target="_blank" href='<?php echo IUrl::creatUrl("/site/article_detail/id/".$item['id']."");?>' title='查看'><?php echo Article::showTitle($item['title'],$item['color'],$item['style']);?></a></td>
					<td><?php echo isset($item['name'])?$item['name']:"";?></td>
					<td><?php echo isset($item['create_time'])?$item['create_time']:"";?></td>
					<td><?php echo ($item['visibility']==1) ? '是':'否';?></td>
					<td><?php echo ($item['top']==1) ? '是':'否';?></td>
					<td><?php echo isset($item['sort'])?$item['sort']:"";?></td>
					<td>
						<a href='<?php echo IUrl::creatUrl("/tools/article_edit/id/".$item['id']."");?>'><img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_edit.gif";?>" alt="编辑" title="编辑" /></a>
						<a target="_blank" href='<?php echo IUrl::creatUrl("/site/article_detail/id/".$item['id']."");?>'><img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_check.gif";?>" alt="查看" title="查看" /></a>
						<a href='javascript:void(0)' onclick="delModel({link:'<?php echo IUrl::creatUrl("/tools/article_del/id/".$item['id']."");?>'});"><img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_del.gif";?>" alt="删除" title="删除" /></a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</form>
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
