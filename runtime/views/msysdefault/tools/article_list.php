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
			<div class="headbar">
	<div class="position"><span>工具</span><span>></span><span>文章管理</span><span>></span><span>文章列表</span></div>
	<div class="operating">
		<a href="javascript:void(0)" onclick="event_link('<?php echo IUrl::creatUrl("/tools/article_edit");?>')"><button class="operating_btn" type="button"><span class="addition">添加文章</span></button></a>
		<a href="javascript:void(0)" onclick="selectAll('id[]');"><button class="operating_btn" type="button"><span class="sel_all">全选</span></button></a>
		<a href="javascript:void(0)" onclick="delModel();"><button class="operating_btn" type="button"><span class="delete">批量删除</span></button></a>
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
				<?php $page= (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;?>
				<?php $query = new IQuery("article as ar");$query->join = "left join article_category as ac on ac.id = ar.category_id";$query->order = "ar.sort asc,ar.id desc";$query->page = "$page";$query->fields = "ar.id,ar.title,ar.create_time,ar.top,ar.style,ar.color,ar.sort,ar.visibility,ac.name";$items = $query->find(); foreach($items as $key => $item){?>
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
<?php echo $query->getPageBar();?>

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
