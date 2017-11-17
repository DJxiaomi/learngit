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
	<div class="position"><span>营销</span><span>></span><span>营销活动管理</span><span>></span><span><?php if(isset($this->promotionRow['id'])){?>编辑<?php }else{?>添加<?php }?>组合套餐</span></div>
</div>
<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/market/brand_zuhe_save");?>"  method="post" name='pro_edit'>
			<input type='hidden' name='id' />
			<table class="form_table">
				<col width="150px" />
				<col />
				<tr>
					<th>组合套餐名称：</th>
					<td><input type='text' class='normal' name='name' pattern='required' alt='组合套餐名称' value="<?php echo isset($zuhe_info['name'])?$zuhe_info['name']:"";?>" /><label>* 组合套餐名称</label></td>
				</tr>
				<tr>
					<th>组合套餐时间：</th>
					<td>
						<input type='text' name='start_time' class='Wdate' pattern='datetime' value="<?php echo isset($zuhe_info['start_time'])?$zuhe_info['start_time']:"";?>" readonly=true onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" alt='开始日期' />
						<input type='text' name='end_time' class='Wdate' pattern='datetime' value="<?php echo isset($zuhe_info['end_time'])?$zuhe_info['end_time']:"";?>" readonly=true onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" alt='结束日期' />
						<label>* 此组合套餐时间段</label>
					</td>
				</tr>
				<tr>
					<th>设置抢购代金券：</th>
					<td>
						<table class='border_table' style='width:65%'>
							<col width="100px" />
							<col width="200px" />
							<col />
							<input type='hidden' name='condition' />
							<thead>
								<tr>
									<th>短期课名称</th>
									<th>单价</th>
									<th>套餐价</th>
									<th>手续费</th>
									<th>课时</th>
								</tr>
							</thead>
							<tbody id='speed_goods'>
								<?php if($zuhe_detail_list){?>
									<?php foreach($zuhe_detail_list as $key => $item){?>
									<tr>
										<td><?php echo isset($item['name'])?$item['name']:"";?></td>
										<td><?php echo isset($item['max_price'])?$item['max_price']:"";?></td>
										<td><?php echo isset($item['tc_price'])?$item['tc_price']:"";?></td>
										<td><?php echo isset($item['commission'])?$item['commission']:"";?></td>
										<td><?php echo isset($item['use_times'])?$item['use_times']:"";?></td>
									</tr>
									<?php }?>
								<?php }?>
							</tbody>
						</table>
					</td>
				</tr>				<tr>					<th>价格：</th>					<td><input type='text' class='normal' name='price' pattern='required' alt='价格不能为空' value="<?php echo isset($zuhe_info['price'])?$zuhe_info['price']:"";?>" /><label>*</label></td>				</tr>
				<tr>
					<th>介绍：</th>
					<td><textarea class='textarea' name='content'><?php echo isset($zuhe_info['content'])?$zuhe_info['content']:"";?></textarea></td>
				</tr>
				<tr><td></td><td>
				<input type="hidden" name="prop_id" value="<?php echo isset($zuhe_info['prop_id'])?$zuhe_info['prop_id']:"";?>" />
				<input type="hidden" name="zuhe_id" value="<?php echo isset($zuhe_info['id'])?$zuhe_info['id']:"";?>" />
				<button class="submit" type='submit'><span>确 定</span></button></td></tr>
			</table>
		</form>
	</div>
</div>

<script type='text/javascript'>
	//输入筛选商品的条件
	function searchGoodsCallback(goodsList)
	{
		goodsList.each(function(){
			var temp = $.parseJSON($(this).attr('data'));
			var prop_id = $('input[name=prop_id]').val();

			var html = '<tr>';
			if ( prop_id == '')
			{
				$('input[name=prop_id]').val(temp.id);			} else {				$('input[name=prop_id]').val(prop_id + ',' + temp.id);			}

			html += '<td>' + temp.name + '</td>' +
							'<td>' + temp.max_price + '</td>' +
							'<td>' + temp.commission + '</td>' +
							'<td>' + temp.use_times + '</td><td></td>';
			html += '</tr>';

			$('#speed_goods').append(html);


		});
	}

	//预定义商品绑定
	//relationCallBack(<?php echo isset($this->promotionRow['goodsRow'])?$this->promotionRow['goodsRow']:"";?>);

	//表单回填
	var formObj = new Form('pro_edit');
	formObj.init(<?php echo JSON::encode($this->promotionRow);?>);
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
