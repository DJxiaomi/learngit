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
			<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/editor/kindeditor-min.js"></script><script type="text/javascript">window.KindEditor.options.uploadJson = "/pic/upload_json";window.KindEditor.options.fileManagerJson = "/pic/file_manager_json";</script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<script type="text/javascript" src="/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/plugins/ueditor/ueditor.all.min.js"></script>

<div class="headbar">
	<div class="position"><span>学校</span><span>></span><span>学校管理</span><span>></span><span>优惠券</span></div>
</div>
<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/brand/brand_chit_save2");?>" method="post" enctype='multipart/form-data'>
			<table class="form_table" cellpadding="0" cellspacing="0">
				<col width="150px" />
				<col />
				<tr>
					<th>名称：</th>
					<td><input class="normal" name="name" type="text" value="<?php echo isset($chit2['name'])?$chit2['name']:"";?>" pattern="required" alt="券名称不能为空" />
					</td>
				</tr>
				<tr>
					<th>logo：</th>
					<td>
						<?php if($chit2['logo']){?><img src="<?php echo IUrl::creatUrl("")."".$chit2['logo']."";?>" width="80" height="80" /><br /><?php }?>
						<input class="normal" name="logo" type="file" value="<?php echo isset($chit2['logo'])?$chit2['logo']:"";?>"  />
						<input class="normal" name="logo2" type="hidden" value="<?php echo isset($chit2['logo'])?$chit2['logo']:"";?>"  />
					</td>
				</tr>
				<tr>
					<th>价格：</th>
					<td><input class="normal" name="max_price" type="float" value="<?php echo isset($chit2['max_price'])?$chit2['max_price']:"";?>" pattern="required" alt="券价格不能为空" />
					</td>
				</tr>
				<tr>
					<th>套餐价格：</th>
					<td><input class="normal" name="tc_price" type="float" value="<?php echo isset($chit2['tc_price'])?$chit2['tc_price']:"";?>" pattern="required" alt="套餐价格不能为空" />
					</td>
				</tr>
				<tr>
					<th>原价：</th>
					<td><input class="normal" name="max_order_chit" type="float" value="<?php echo isset($chit2['max_order_chit'])?$chit2['max_order_chit']:"";?>" pattern="required" alt="原价不能为空" />
					</td>
				</tr>
				<tr>
					<th>商家返还：</th><td><input class="normal" name="commission" type="float" value="<?php echo isset($chit2['commission'])?$chit2['commission']:"";?>" /></td>
				</tr>
				<tr>
					<th>结束时间：</th>
					<td><input class="normal" name="limittime" type="text" value="<?php if($chit2['limittime']){?><?php echo date('Y-m-d', $chit2['limittime']);?><?php }?>" onfocus='WdatePicker()' />
					</td>
				</tr>
				<tr>
					<th>限购次数：</th><td><input class="normal" name="limitnum" type="number" value="<?php if(!$chit2['limitnum']){?>0<?php }else{?><?php echo isset($chit2['limitnum'])?$chit2['limitnum']:"";?><?php }?>" /></td>
				</tr>
				<tr>
					<th>总课时：</th><td><input class="normal" name="use_times" type="number" value="<?php if(!$chit2['use_times']){?>1<?php }else{?><?php echo isset($chit2['use_times'])?$chit2['use_times']:"";?><?php }?>" /></td>
				</tr>
				<tr>
					<th>每次：</th><td><input class="normal" name="each_times" type="number" value="<?php if(!$chit2['each_times']){?>1<?php }else{?><?php echo isset($chit2['each_times'])?$chit2['each_times']:"";?><?php }?>" />课时</td>
				</tr>
				<tr>
					<th>上课时间：</th><td><input class="normal" name="class_time" type="text" value="<?php if(!$chit2['class_time']){?><?php }else{?><?php echo isset($chit2['class_time'])?$chit2['class_time']:"";?><?php }?>" /></td>
				</tr>
				<tr>
					<th>是否需要预约：</th><td><input name="is_booking" type="radio" value="1" <?php if($chit2['is_booking']){?>checked<?php }?>/>是&nbsp; &nbsp; <input name="is_booking" type="radio" value="0" <?php if(!$chit2['is_booking']){?>checked<?php }?> />否</td>
				</tr>
				<tr>
					<th>是否推荐：</th><td><input name="is_intro" type="radio" value="1" <?php if($chit2['is_intro']){?>checked<?php }?>/>是&nbsp; &nbsp; <input name="is_intro" type="radio" value="0" <?php if(!$chit2['is_intro']){?>checked<?php }?> />否</td>
				</tr>
				<tr>
					<th>预约说明：</th><td><input class="normal" name="booking_desc" type="text" value="<?php if(!$chit2['booking_desc']){?>请提前电话预约上课时间！<?php }else{?><?php echo isset($chit2['booking_desc'])?$chit2['booking_desc']:"";?><?php }?>" /></td>
				</tr>
				<tr>
					<th>上下架：</th><td><input name="is_del" type="radio" value="1" <?php if($chit2['is_del']){?>checked<?php }?>/>下架&nbsp; &nbsp; <input name="is_del" type="radio" value="0" <?php if(!$chit2['is_del']){?>checked<?php }?> />上架</td>
				</tr>
				<tr>
					<th>是否置顶：</th><td><input name="is_top" type="radio" value="1" <?php if($chit2['is_top']){?>checked<?php }?>/>是&nbsp; &nbsp; <input name="is_top" type="radio" value="0" <?php if(!$chit2['is_top']){?>checked<?php }?> />否</td>
				</tr>
				<tr>
					<th>课程介绍：</th><td><textarea class="normal" name="content" id="content" type="text" style="width:700px;height:400px;"><?php echo isset($chit2['content'])?$chit2['content']:"";?></textarea></td>
				</tr>
				<tr>
					<th>使用说明：</th><td><textarea class="normal" name="limitinfo" id="limitinfo" type="text" style="width:700px;height:200px;"><?php echo isset($chit2['limitinfo'])?$chit2['limitinfo']:"";?></textarea></td>
				</tr>
				<tr>
					<td>
						<input type="hidden" name="isedit" value="<?php echo isset($isedit)?$isedit:"";?>" />
						<input type="hidden" name="id" value="<?php echo isset($chit2['id'])?$chit2['id']:"";?>" />
						<input type="hidden" name="page" value="<?php echo isset($page)?$page:"";?>" />
						<input type="hidden" name="brand_id" id="brand_id" value="<?php echo isset($chit2['brand_id'])?$chit2['brand_id']:"";?>" />
						<button class="submit" type="submit"><span>确 定</span></button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<script language="javascript">
$(function(){
	UE.getEditor('content');
	UE.getEditor('limitinfo');
})
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
