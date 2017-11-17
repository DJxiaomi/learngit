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
			<div class="headbar">
	<div class="position"><span>营销</span><span>></span><span>代金券管理</span><span>></span><span>代金券列表2</span></div>
	<div class="searchbar">
		<form action="<?php echo IUrl::creatUrl("/");?>" method="get" name="searchListForm">
			<input type='hidden' name='controller' value='market' />
			<input type='hidden' name='action' value='brand_chit_list2' />
			<select class="auto" name="search[seller_id]">
				<option value="0">选择商户</option>
				<?php foreach($seller_list as $key => $item){?>
				<option value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($search['seller_id'] && $search['seller_id'] == $item['id']){?>selected<?php }?>><?php echo isset($item['shortname'])?$item['shortname']:"";?></option>
				<?php }?>
			</select>
			<!-- <select class="auto" name="search[manual_category_id]">
				<option value="">选择分类</option>
				<?php foreach($category_list as $key => $item){?>
				<option value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($search['manual_category_id'] == $item['id']){?>selected<?php }?>><?php echo isset($item['name'])?$item['name']:"";?></option>
				<?php }?>
			</select>
			<select class="auto" name="search[is_intro]">
				<option value="">选择推荐</option>
				<option value="1" <?php if($search['is_intro'] == 1){?>selected<?php }?>>是</option>
				<option value="0" <?php if($search['is_intro'] != '' && $search['is_intro'] == '0'){?>selected<?php }?>>否</option>
			</select>
			<select class="auto" name="search[is_top]">
				<option value="">选择置顶</option>
				<option value="1" <?php if($search['is_top'] == 1){?>selected<?php }?>>是</option>
				<option value="0" <?php if($search['is_top'] != '' && $search['is_top'] == '0'){?>selected<?php }?>>否</option>
			</select>
			<select class="auto" name="search[is_del]">
				<option value="">选择状态</option>
				<option value="1" <?php if($search['is_del'] == 1){?>selected<?php }?>>上架</option>
				<option value="0" <?php if($search['is_del'] != '' && $search['is_del'] == '0'){?>selected<?php }?>>下架</option>
			</select> -->
			<input class="small" name="search[keywords]" type="text" value="<?php if($search['keywords']){?><?php echo isset($search['keywords'])?$search['keywords']:"";?><?php }?>" placeholder="请输入关键词" />

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
	<form method='post' action='#'>
		<table class="list_table">
			<colgroup>
				<col width="40px" />
				<col width="100px" />
				<col width="300px" />
				<col width="80px" />
				<col width="140px" />
			</colgroup>

			<thead>
				<tr>
					<th>选择</th>
					<th>商户</th>
					<th>折扣信息</th>
					<th>图片</th>
					<th>操作</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($brand_chit_list as $key => $item){?>
				<tr>
					<td></td>
					<td><?php echo isset($item['seller_info']['shortname'])?$item['seller_info']['shortname']:"";?></td>
					<td><?php echo isset($item['name'])?$item['name']:"";?></td>
					<td><a href="<?php echo IUrl::creatUrl("")."".$item['logo']."";?>" target="_blank"><img src="<?php echo IUrl::creatUrl("")."".$item['logo']."";?>" width="80" height="80" /></a></td>
					<td>
						<a href='<?php echo IUrl::creatUrl("/brand/brand_chit_edit3/id/".$item['id']."/page/".$page."");?>'>
							<img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_edit.gif";?>" alt="修改" title="修改" />
						</a>

						<a href='javascript:void(0)' onclick="delModel({link:'<?php echo IUrl::creatUrl("/market/brand_chit_del3/id/".$item['id']."");?>'});">
							<img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_del.gif";?>" alt="删除" title="删除" />
						</a>
					</td>
				</tr>
				<?php }?>
				<?php if($page_info){?>
				<tr>
					<td colspan="5"><?php echo isset($page_info)?$page_info:"";?></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</form>
</div>

<script type='text/javascript'>
	//创建优惠券
	function create_dialog(ticket_id)
	{
		art.dialog.prompt('请输入生成线下实体代金券数量：',function(num)
		{
			var num = parseInt(num);
			if(isNaN(num) || num <= 0)
			{
				alert('请填写正确的数量');
				return false;
			}

			var url = '<?php echo IUrl::creatUrl("/market/ticket_create/ticket_id/@ticket_id@/num/@num@");?>';
			    url = url.replace('@ticket_id@',ticket_id).replace('@num@',num);
			window.location.href = url;
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
