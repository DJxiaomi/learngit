<?php $menuData=menu::init($this->admin['role_id']);?>
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
	<span class="zhong"><?php echo isset($this->admin['admin_role_name'])?$this->admin['admin_role_name']:"";?>:<?php echo isset($this->admin['admin_name'])?$this->admin['admin_name']:"";?></span>
		<div id="header">
          <div id="menu">
			<ul name="topMenu">
				<li class="first"> <a href="/index.php?controller=system&amp;action=default">首页</a></li> 

				
				
				
				<li><a hidefocus="true" href="/order/order_list">订单管理</a></li>			
				<li><a hidefocus="true" href="/market/brand_chit_list">新代金券</a></li>
                <li><a hidefocus="true" href="/order/order_collection_list">成交明细</a></li>
                <li><a hidefocus="true" href="/order/refundment_list">退款申请</a></li>				
						<li><a href="/member/withdraw_list">用户提现</a></li>
				<li><a hidefocus="true" href="/market/bill_list">结算申请</a></li>

				<li><a hidefocus="true" href="/goods/goods_list">课程管理</li>
				<li><a hidefocus="true" href="/member/member_list">用户管理</a></li>
				<li><a href="/brand/brand_list">学校资料</a></li>
				<li><a href="/member/seller_list">学校认证</a></li>
				<li><a href="/member/seller_edit">添加认证</a></li>
				<li><a href="/member/teacher_list">教师列表</a></li>
					
				<li><a href="/tools/notice_list">公告管理</a></li>
				<li><a hidefocus="true" href="/tools/article_list">文章管理</a></li>
				<li><a hidefocus="true" href="/tools/ad_list">广告管理</a></li>
				<li><a href="/comment/discussion_list">讨论管理</a></li>
				<li><a href="/comment/refer_list">咨询管理</a></li>
				<li class="last"><a href="/index.php?controller=systemadmin&amp;action=logout">退出</a></li> 
			</ul>
			</div>
			
		</div>

		<div id="admin_left">
			<ul class="submenu">
				<?php $leftMenu=menu::get($menuData,IWeb::$app->getController()->getId().'/'.IWeb::$app->getController()->getAction()->getId())?>
				<?php foreach(current($leftMenu) as $key => $item){?>
				<li>
					<span><?php echo isset($key)?$key:"";?></span>
					<ul name="leftMenu">
						<?php foreach($item as $leftKey => $leftValue){?>
						<li><a href="<?php echo IUrl::creatUrl("".$leftKey."");?>"><?php echo isset($leftValue)?$leftValue:"";?></a></li>
						<?php }?>
					</ul>
				</li>
				<?php }?>
			</ul>
			<div id="copyright"></div>
		</div>

		<div id="admin_right">
			<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<div class="content_box" style="border:none">
	<div class="content">


		<table width="98%" cellspacing="0" cellpadding="5" class="border_table_org" style="float:left">
			<thead>
				<tr><th>基础统计</th></tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<table class="list_table2" width="98%">
							<colgroup>
								<col width="80px" />
								<col />
							</colgroup>
							<tbody>
								<tr><th>商家数量</th><td><?php $query = new IQuery("seller");$query->fields = "count(*) as amount";$items = $query->find(); foreach($items as $key => $item){?><a href="<?php echo IUrl::creatUrl("/member/seller_list");?>"><b class="f14 red3"><?php echo isset($item['amount'])?$item['amount']:"";?></b> 家</a><?php }?></td></tr>
								<tr><th>注册用户</th><td><?php $query = new IQuery("user");$query->fields = "count(id) as countNums";$items = $query->find(); foreach($items as $key => $item){?><a href="<?php echo IUrl::creatUrl("/member/member_list");?>"><b class="f14 red3"><?php echo isset($item['countNums'])?$item['countNums']:"";?></b> 个</a><?php }?></td></tr>
								<tr><th>课程数量</th><td><a href="<?php echo IUrl::creatUrl("/goods/goods_list");?>"><b class="f14 red3"><?php echo statistics::goodsCount();?></b> 个</a></td></tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	
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
