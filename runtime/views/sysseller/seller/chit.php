<?php $seller_id = $this->seller['seller_id'];$seller_name = $this->seller['seller_name'];?>
<?php $this->seller_info = seller_class::get_seller_info($seller_id);?>
<?php $this->brand_info = brand_class::get_brand_info($this->seller_info['brand_id'])?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php if($this->brand_info['category_ids'] != 16 ){?>学校<?php }else{?>个人教师<?php }?>管理后台</title>
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/html5.js";?>"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/common.js";?>"></script>
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/ie.css";?>" type="text/css" media="screen" />
	<![endif]-->
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/admin.css";?>" type="text/css" media="screen" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
</head>

<body>
	<!--头部 开始-->
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="<?php echo IUrl::creatUrl("/seller/index");?>"></a></h1>
			<h2 class="section_title"></h2>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("");?>" target="_blank">网站首页</a></div>
			<div class="btn_view_site"><a href="http://dsk.dsanke.com" target="_blank">商户服务</a></div>
			<div class="btn_view_site"><?php if($this->brand_info['category_ids'] != 16){?><a href="<?php echo IUrl::creatUrl("school/home/id/".$seller_id."");?>" target="_blank">学校主页</a><?php }else{?><a href="<?php echo IUrl::creatUrl("/site/tutor_info/id/".$seller_id."");?>" target="_blank">个人教师主页</a><?php }?></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("/systemseller/logout");?>">退出登录</a></div>
		</hgroup>
	</header>
	<!--头部 结束-->

	<!--面包屑导航 开始-->
	<section id="secondary_bar">
		<div class="user">
			<p><?php echo isset($seller_name)?$seller_name:"";?></p>
		</div>
	</section>
	<!--面包屑导航 结束-->

	<!--侧边栏菜单 开始-->
	<aside id="sidebar" class="column">
		<?php foreach(menuSeller::init() as $key => $item){?>
		<?php if($this->brand_info['category_ids'] != 16 && $key == '教师管理'){?>

		<?php }elseif($this->brand_info['category_ids'] == 16 && ($key == '学校管理' || $key == '课程管理' || $key == '配置模块')){?>

		<?php }else{?>
			<h3><?php echo isset($key)?$key:"";?></h3>
			<ul class="toggle">
				<?php foreach($item as $moreKey => $moreValue){?>
				<?php if(($this->brand_info['category_ids'] == 16 && !in_array($moreKey, array('seller/order_list','seller/order_prop_list','seller/order_list2','/seller/goods_list','/seller/goods_edit','/seller/chit','/seller/virtual','/seller/promote','/seller/seller_edit','/seller/teacher_list','/seller/order_verification','/seller/order_list'))) || ($this->brand_info['category_ids'] != 16 && !in_array($moreKey, array('seller/order_tutor_list','/seller/seller_tutor_list','/seller/auth','/seller/seller_edit4','/seller/seller_edit5','/seller/order_tutor_list')))){?>
				<?php if((!in_array($moreKey,array('/seller/my_equity'))) || in_array($moreKey,array('/seller/my_equity')) && $this->seller_info['is_equity'] == 1){?>
				<?php if($this->seller_info['is_system_seller'] && $moreKey == '/seller/goods_edit2'){?>
				<li><a href="<?php echo IUrl::creatUrl("/seller/goods_edit");?>">特殊商家添加课程</a></li>
				<?php }else{?>
				<li><a href="<?php echo IUrl::creatUrl("".$moreKey."");?>"><?php echo isset($moreValue)?$moreValue:"";?></a></li>
				<?php }?>
				<?php }?>
				<?php }?>
				<?php }?>				
			</ul>
		<?php }?>
		<?php }?>

		<footer>
			<hr />
			<p><strong>Copyright &copy; 2014-2017 第三课</strong></p>
			<p>Powered by <a href="http://www.dsanke.com">第三课</a></p>
		</footer>
	</aside>
	<!--侧边栏菜单 结束-->

	<!--主体内容 开始-->
	<section id="main" class="column">
		<article class="module width_full">
	<header>
		<h3 class="tabs_involved">代金券列表</h3>
    <ul class="tabs">
      <li><input type="button" class="alt_btn" onclick="window.location.href = '<?php echo IUrl::creatUrl("/seller/chit_edit");?>'" value="发布代金券" /></li>
    </ul>
	</header>

	<table class="tablesorter" cellspacing="0">
		<colgroup>
			<col width="150px" />
			<col width="150px" />
			<col width="120px" />
			<col width="85px" />
      <col width="85px" />
	  <col width="50px" />
			<col />
		</colgroup>
		<thead>
			<tr>
				<th>代金券售价</th>
				<th>抵扣现金金额</th>
				<th>类型</th>
				<th>时间</th>
				<th>限购</th>
             <th>操作</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($brand_chit_list as $key => $item){?>
			<tr>
				<td><?php echo isset($item['max_price'])?$item['max_price']:"";?></td>
				<td><em>￥</em><?php echo isset($item['max_order_chit'])?$item['max_order_chit']:"";?></td>
				<td>专用券</em><?php echo isset($item['shortname'])?$item['shortname']:"";?></td>
				<td><?php echo date('Y-m-d', $item['limittime']);?>结束</td>
				<td>每人限购<?php echo isset($item['limitnum'])?$item['limitnum']:"";?>张</td>
                <td>
					 <a href="<?php echo IUrl::creatUrl("/seller/chit_edit/id/".$item['id']."");?>">编辑</a>
					 
				</td> 
			</tr>
			<?php }?>
		</tbody>
	</table>
</article>

	</section>
	<!--主题内容 结束-->

	<script type="text/javascript">
	//菜单图片ICO配置
	function menuIco(val)
	{
		var icoConfig = {
			"管理首页" : "icn_tags",
			"交易额统计" : "icn_settings",
			"成交明细列表" : "icn_categories",
			"成交结算申请" : "icn_photo",
			"课程列表" : "icn_categories",
			"添加课程" : "icn_new_article",
			"平台共享课程" : "icn_photo",
			"课程咨询" : "icn_audio",
			"课程评价" : "icn_audio",
			"课程退款" : "icn_audio",
			"参数属性" : "icn_categories",
			"订单列表" : "icn_categories",
			"团购" : "icn_view_users",
			"促销活动列表" : "icn_categories",
			"授课方式" : "icn_folder",
			"授课地址" : "icn_jump_back",
			"学校主页" : "icn_profile",
		};
		return icoConfig[val] ? icoConfig[val] : "icn_categories";
	}

	$(".toggle>li").each(function()
	{
		$(this).addClass(menuIco($(this).text()));
	});
	</script>
</body>
</html>
