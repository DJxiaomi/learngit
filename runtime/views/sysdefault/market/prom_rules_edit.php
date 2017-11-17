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
	<div class="position"><span>营销</span><span>></span><span>推广设置</span><span>></span><span><?php if(isset($this->promotionRow['id'])){?>编辑<?php }else{?>添加<?php }?>提成规则</span></div>
</div>
<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/market/prom_rules_edit_act");?>" method="post" name='pro_rule_edit' >
			<input type='hidden' name='id' />
			<table class="form_table" name="rule_table">
				<col width="150px" />
				<col />
				<tr>
					<th>推广人级别：</th>
					<td>
						<select name="level" pattern='required' alt='请填写推广人级别' >
							<option value="">请选择推广人级别</option>
							<option value="1" <?php if($prom_rules_info['level'] == 1){?>selected<?php }?>>1</option>
							<option value="2" <?php if($prom_rules_info['level'] == 2){?>selected<?php }?>>2</option>
							<option value="3" <?php if($prom_rules_info['level'] == 3){?>selected<?php }?>>3</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>提成方式：</th>
					<td>
						<label class='attr'><input type='radio' name='promo_type' value='1' checked=checked />按比例提成</label>
						<label class='attr'><input type='radio' name='promo_type' value='2' <?php if($prom_rules_info['promo_type'] == 2){?>checked=checked<?php }?> />按固定金额提成</label>
						(按比例提成：课程销售额 * 折扣比例 * 提成比例)
					</td>
				</tr>
				<tr>
					<th>总提成：</th>
					<td>
						<input type="text" class="normal small" name="promo_value" pattern='float' empty alt='请填写提成' value="<?php echo isset($prom_rules_info['promo_value'])?$prom_rules_info['promo_value']:"";?>" /><span class="unit">%</span>
						<input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>" />
					</td>
				</tr>
				<tr>
					<th>用户推广人提成：</th>
					<td>
						<input type="text" class="normal small" name="user_value" pattern='float' empty alt='请填写提成' value="<?php echo isset($prom_rules_info['user_value'])?$prom_rules_info['user_value']:"";?>" />%
					</td>
				</tr>
				<tr>
					<th>商户推广人提成：</th>
					<td>
						<input type="text" class="normal small" name="seller_value" pattern='float' empty alt='请填写提成' value="<?php echo isset($prom_rules_info['seller_value'])?$prom_rules_info['seller_value']:"";?>" />%
					</td>
				</tr>
				<tr>
					<th>订单推广人提成：</th>
					<td>
						<input type="text" class="normal small" name="order_value" pattern='float' empty alt='请填写提成' value="<?php echo isset($prom_rules_info['order_value'])?$prom_rules_info['order_value']:"";?>" />%
					</td>
				</tr>
			</table>

			<button class="submit" type='button' onclick="check_form()"><span>确 定</span></button>
		</form>
	</div>
</div>

<script language="javascript">
	$(document).ready(function(){
		$("input[name=promo_type]").click(function(){
			var _val = $(this).val();
			if (_val == '1')
			{
				$('.unit').html('%');
			}
			else
			{
				$('.unit').html('元');
			}
		})

		<?php if($prom_rules_info['promo_type'] == 2){?>
			$('.proportion_type_view').hide();
			$('.unit').html('元');
		<?php }?>
	})

	function check_form()
	{
		var _user_value = $("input[name=user_value]").val();
		var _seller_value = $("input[name=seller_value]").val();
		var _order_value = $("input[name=order_value]").val();

		if ( parseFloat(_user_value) + parseFloat(_seller_value) + parseFloat(_order_value) > 100 )
		{
			alert('提成比例总额度大于100');
			return false;
		} else {
			$("form[name=pro_rule_edit]").submit();
		}
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
