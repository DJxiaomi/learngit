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
	<div class="position"><span>会员</span><span>></span><span>商户管理</span><span>></span><span>编辑商户信息</span></div>
</div>

<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/member/seller_add");?>" method="post" name="sellerForm" enctype='multipart/form-data'>
			<input name="id" value="" type="hidden" />

			<table class="form_table">
				<colgroup>
					<col width="150px" />
					<col />
				</colgroup>

				<tbody>
					<tr>
						<th>登陆用户名：</th>
						<td><input class="normal" name="seller_name" type="text" value="" pattern="required" alt="用户名不能为空" /><label>* 用户名称（必填）</label></td>
					</tr>
					<tr>
						<th>密码：</th><td><input class="normal" name="password" type="password" bind='repassword' empty /><label>* 登录密码</label></td>
					</tr>
					<tr>
						<th>确认密码：</th><td><input class="normal" name="repassword" type="password" bind='password' empty /><label>* 重复确认密码</label></td>
					</tr>
					<tr>
						<th>商户真实全称：</th>
						<td><input class="normal" name="true_name" type="text" value="" pattern="required" /></td>
					</tr>
					<tr>
						<th>商户简称：</th>
						<td><input class="normal" name="shortname" type="text" value="" pattern="required" /></td>
					</tr>
					<tr>
						<th>短期课分类：</th>
						<td>
							<select name="manual_category_id">
								<option value="0">请选择分类</option>
								<?php foreach($this->manual_category_list as $key => $item){?>
									<option value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($this->sellerRow['manual_category_id'] == $item['id']){?>selected<?php }?>><?php echo isset($item['name'])?$item['name']:"";?></option>
								<?php }?>
							</select>
						</td>
					</tr>
					<tr>
						<th>邮箱：</th>
						<td><input type="text" class="normal" name="email" pattern="email" empty /></td>
					</tr>
					<tr>
						<th>地区：</th>
						<td>
							<select name="province" child="city,area"></select>
							<select name="city" child="area"></select>
							<select name="area"></select>
						</td>
					</tr>
					<tr>
						<th>详细地址：</th><td><input class="normal" name="address" type="text" empty value="" /></td>
					</tr>
					<tr>
						<th>座机号码：</th>
						<td><input class="normal" name="phone" type="text" empty value="" /></td>
					</tr>
					<tr>
						<th>客服QQ号码：</th>
						<td><input class="normal" name="server_num" type="text" empty value="" /></td>
					</tr>


					<tr style="display:none;">
						<th>短期课次数：</th>
						<td><input type='text' class='small' name='class_number' /></td>
					</tr>
					<tr style="display:none;">
						<th>免费体验课：</th>
						<td>
							<label class='attr'><input type='radio' name='is_free' value='0' checked='checked' />无</label>
							<label class='attr'><input type='radio' name='is_free' value='1' />有</label>
						</td>
					</tr>
						<tr style="display:none;">
						<th>是否特殊商家</th>
						<td>
							<label class='attr'><input type='radio' name='is_system_seller' value='0' checked='checked' />无</label>
							<label class='attr'><input type='radio' name='is_system_seller' value='1' />有</label>
						</td>
					</tr>
					<tr style="display:none;">
						<th>特殊商家首页模板：</th>
						<td><input type='text' class='small' name='template' /></td>
					</tr>
					<tr style="display:none;">
						<th>特殊商家详情页模板：</th>
						<td><input type='text' class='small' name='product_template' /></td>
					</tr>
					<tr>
						<th>上级推广人：</th>
						<td><input type='text' class='small' name='promo_code' /></td>
					</tr>
					<tr style="display:none;">
						<th>是否支持通用代金券</th>
						<td>
							<label class='attr'><input type='radio' name='is_support_props' value='0' checked='checked' />无</label>
							<label class='attr'><input type='radio' name='is_support_props' value='1' />有</label>
						</td>
					</tr>
					<tr>
						<th>是否锁定</th>
						<td>
							<label class='attr'><input type='radio' name='is_auth' value='0' checked='checked' />无</label>
							<label class='attr'><input type='radio' name='is_auth' value='1' />有</label>
						</td>
					</tr>	
					<tr>
						<th>是否未认证但可交易</th>
						<td>
							<label class='attr'><input type='radio' name='is_authentication' value='0' checked='checked' />无</label>
							<label class='attr'><input type='radio' name='is_authentication' value='1' />有</label>
						</td>
					</tr>						
					<tr>
						<th>是否开通：</th>
						<td>
							<label class='attr'><input type='radio' name='is_lock' value='0' checked='checked' />开通</label>
							<label class='attr'><input type='radio' name='is_lock' value='1' />锁定</label>
							<label>锁定后商户无法登陆进行管理</label>
						</td>
					</tr>
					<tr>
						<th>是否VIP：</th>
						<td>
							<label class='attr'><input type='radio' name='is_vip' value='0' checked='checked' />否</label>
							<label class='attr'><input type='radio' name='is_vip' value='1' />是</label>
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
