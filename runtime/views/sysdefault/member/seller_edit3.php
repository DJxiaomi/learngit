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
			<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/areaSelect/areaSelect.js"></script>

<div class="headbar">
	<div class="position"><span>会员</span><span>></span><span>商户管理</span><span>></span><span>商户功能设置</span></div>
</div>

<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/member/seller_add3");?>" method="post" name="sellerForm" enctype='multipart/form-data'>
			<input name="id" value="" type="hidden" />

			<table class="form_table">
				<colgroup>
					<col width="150px" />
					<col />
				</colgroup>

				<tbody>
					<tr>
						<th>商户名称：</th>
						<td>
							<select class="auto selectpicker show-tick form-control" name="seller_id" data-live-search="true">
								<option value="">请选择商户</option>
								<?php $query = new IQuery("seller");$query->where = "is_del = 0";$query->order = "id desc";$items = $query->find(); foreach($items as $key => $item){?>
								<option value="<?php echo isset($item['id'])?$item['id']:"";?>"<?php if($item['id'] == $this->sellerRow['id']){?> selected<?php }?>><?php echo isset($item['true_name'])?$item['true_name']:"";?>-<?php echo isset($item['seller_name'])?$item['seller_name']:"";?></option>
								<?php }?>
							</select>
						</td>
					</tr>

					<tr>
						<th>商户真实全称：</th>
						<td><input class="normal" name="true_name" type="text" value="" pattern="required" /></td>
					</tr>

						<tr>
						<th>在线课堂</th>
						<td>
							<label class='attr'><input type='radio' name='is_support_zxkt' value='0' checked='checked' />不开通</label>
							<label class='attr'><input type='radio' name='is_support_zxkt' value='1' />开通</label>
						</td>
					</tr>
					<tr>
						<th>订票系统</th>
						<td>
							<label class='attr'><input type='radio' name='is_support_dp' value='0' checked='checked' />不开通</label>
							<label class='attr'><input type='radio' name='is_support_dp' value='1' />开通</label>
						</td>
					</tr>
					<tr>
						<th>虚拟商品</th>
						<td>
							<label class='attr'><input type='radio' name='is_virtual' value='0' checked='checked' />不开通</label>
							<label class='attr'><input type='radio' name='is_virtual' value='1' />开通</label>
						</td>
					</tr>
					<tr>
						<th>投票功能</th>
						<td>
							<label class='attr'><input type='radio' name='is_vote' value='0' checked='checked' />不开通</label>
							<label class='attr'><input type='radio' name='is_vote' value='1' />开通</label>
						</td>
					</tr>
					<tr>
						<td></td><td><button class="submit" type="submit"><span>确 定</span></button></td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>

<script language="javascript">
//DOM加载完毕
$(function()
{
	$('select[name=seller_id]').change(function(){
		var seller_id = $(this).val();
		$.getJSON('<?php echo IUrl::creatUrl("/member/get_seller_info");?>',{seller_id:seller_id},function(res){
			if(res.status == 1){
				var data = res.data;
				$('input[name=true_name]').val(data.true_name);
				$('input[name=is_support_zxkt][value='+data.is_support_zxkt+']').attr('checked','checked').siblings('label').removeAttr('checked');
				$('input[name=is_support_dp][value='+data.is_support_dp+']').attr('checked','checked').siblings('label').removeAttr('checked');
				$('input[name=is_virtual][value='+data.is_virtual+']').attr('checked','checked').siblings('label').removeAttr('checked');
				$('input[name=is_vote][value='+data.is_vote+']').attr('checked','checked').siblings('label').removeAttr('checked');
			}
		})
	})

	//修改模式
	<?php if($this->sellerRow){?>
	var formObj = new Form('sellerForm');
	formObj.init(<?php echo JSON::encode($this->sellerRow);?>);

	//锁定字段一旦注册无法修改
	if($('[name="id"]').val())
	{
		var lockCols = ['seller_name'];
		for(var index in lockCols)
		{
			$('input:text[name="'+lockCols[index]+'"]').addClass('readonly');
			$('input:text[name="'+lockCols[index]+'"]').attr('readonly',true);
		}
	}
	<?php }?>

	//地区联动插件
	var areaInstance = new areaSelect('province');
	areaInstance.init(<?php echo JSON::encode($this->sellerRow);?>);
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
