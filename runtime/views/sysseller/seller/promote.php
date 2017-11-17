<?php $seller_id = $this->seller['seller_id'];$seller_name = $this->seller['seller_name'];?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>商家管理后台</title>
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
<style>
 header#header h2.section_title{
  width:40%;
 }
</style>
<body>
	<!--头部 开始-->
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="<?php echo IUrl::creatUrl("/seller/index");?>"><img src="<?php echo $this->getWebSkinPath()."images/main/logo.png";?>" /></a></h1>
			<h2 class="section_title"></h2>
			<div class="btn_view_site"><a href="http://www.lelele999.net" target="_blank">管理公众号</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("");?>" target="_blank">网站首页</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("/site/home/id/".$seller_id."");?>" target="_blank">商家主页</a></div>
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
		<h3><?php echo isset($key)?$key:"";?></h3>
		<ul class="toggle">
			<?php foreach($item as $moreKey => $moreValue){?>
			<li><a href="<?php echo IUrl::creatUrl("".$moreKey."");?>"><?php echo isset($moreValue)?$moreValue:"";?></a></li>
			<?php }?>
		</ul>
		<?php }?>

		<footer>
			<hr />
			<p><strong>Copyright &copy; 2010-2017</strong></p>
			<p>Powered by <a href="http://www.dsanke.com">dsanke.com</a></p>
		</footer>
	</aside>
	<!--侧边栏菜单 结束-->

	<!--主体内容 开始-->
	<section id="main" class="column">
		<link href="/views/default/skin/default/css/ucenter_promote.css" rel="stylesheet" type="text/css" />
<style>
.new-box {width: 97%;margin: 0px auto;}
.promo_code {padding-left: 10px; height: 35px; line-height: 35px;}
.promo_code b {color: red;}
.tablesorter em {font-style: normal;}
.tablesorter a {font-weight: 600;}
</style>
<article class="module width_full">
	<header><h3>我的推广</h3></header>
	<div class="module_content">
		<table border="0">
			<tr>
				<td class="promo_code">我的推广码：<b><?php echo isset($my_promote_code)?$my_promote_code:"";?></b></td>
			</tr>
		</table>
		<table class="tablesorter" cellspacing="0">
			<thead>
				<tr>
								<th>我的推广</th>
								<th>个人用户</th>
								<th>个人返佣</th>
								<th>&nbsp;</th>
								<th>培训机构</th>
								<th>机构返佣</th>
								<th>下级推广</th>
								<th>下级返佣</th>
							</tr>
						</thead>
			<tbody>

				<tr>
					<td>总推广</td>
					<td><a href="<?php echo IUrl::creatUrl("/seller/promote_user_list");?>"><?php echo isset($promote_statics['user_count'])?$promote_statics['user_count']:"";?></a></td>
					<td><?php echo isset($promote_statics['user_prommission_count'])?$promote_statics['user_prommission_count']:"";?></td>
					<td>&nbsp;</td>
					<td><a href="<?php echo IUrl::creatUrl("/seller/promote_seller_list");?>"><?php echo isset($promote_statics['seller_count'])?$promote_statics['seller_count']:"";?></a></td>
					<td><?php echo isset($promote_statics['seller_prommission_count'])?$promote_statics['seller_prommission_count']:"";?></td>
					<td><a href="<?php echo IUrl::creatUrl("/seller/promote_subordinate_user_list");?>"><?php echo isset($promote_statics['get_promote_list_by_account'])?$promote_statics['get_promote_list_by_account']:"";?></td>
					<td><?php echo isset($promote_statics['other_commision_count'])?$promote_statics['other_commision_count']:"";?></td>
				</tr>
				<tr>
					<td><a href="<?php echo IUrl::creatUrl("/seller/promote_previous_month");?>">上月推广</a></td>
					<td><?php echo isset($promote_statics['user_count_by_month'])?$promote_statics['user_count_by_month']:"";?></td>
					<td><?php echo isset($promote_statics['user_prommission_count_by_month'])?$promote_statics['user_prommission_count_by_month']:"";?></td>
					<td>&nbsp;</td>
					<td><?php echo isset($promote_statics['seller_count_by_month'])?$promote_statics['seller_count_by_month']:"";?></td>
					<td><?php echo isset($promote_statics['seller_prommission_count_by_month'])?$promote_statics['seller_prommission_count_by_month']:"";?></td>
					<td><?php echo isset($promote_statics['get_promote_list_by_account_by_month'])?$promote_statics['get_promote_list_by_account_by_month']:"";?></td>
					<td><?php echo isset($promote_statics['other_commision_count_by_month'])?$promote_statics['other_commision_count_by_month']:"";?></td>
				</tr>
			</tbody>
		</table>
	</div>

  <div class="main f_r">
      <div class="new-box">
          <div class="hd">
            <ul>
              <li <?php if($type == '1'){?>class="active"<?php }?>><a href="<?php echo IUrl::creatUrl("/seller/promote/type/1");?>">最新推广</a></li>
              <li <?php if($type == '2'){?>class="active"<?php }?>><a href="<?php echo IUrl::creatUrl("/seller/promote/type/2");?>">最新成交</a></li>
              <li <?php if($type == '3'){?>class="active"<?php }?>><a href="<?php echo IUrl::creatUrl("/seller/promote/type/3");?>">商家用户</a></li>
              <li <?php if($type == '4'){?>class="active"<?php }?>><a href="<?php echo IUrl::creatUrl("/seller/promote/type/4");?>">个人用户</a></li>
            </ul>
          </div>

          <?php if($type == 1){?>
          <!-- 最新推广 -->
          <table class="tablesorter" cellspacing="0">
              <thead>
                <tr>
                  <th>编号</th>
                  <th>用户</th>
                  <th>日期</th>
                </tr>
              </thead>

              <tbody>
                <?php foreach($promotelist as $key => $item){?>
                    <tr>
                        <td><?php echo $key+1;?></td>
                        <td><?php echo isset($item['username'])?$item['username']:"";?></td>
                        <td><?php if($item['create_time']){?><?php echo date('Y-m-d',strtotime($item['create_time']));?><?php }?></td>
                    </tr>
                <?php }?>
                <?php if(!$promotelist){?>
                  <tr>
                    <td style="text-align:center" colspan="5">没有任何记录</td>
                  </tr>
                <?php }?>
            </tbody>
          </table>
          <?php }elseif($type == 2){?>
          <!-- 最新成交 -->
          <table class="tablesorter" cellspacing="0">
            <thead>
              <tr>
                <th>编号</th>
                <th>用户</th>
                <th>课程</th>
								<th>预计提成</th>
                <th>日期</th>
              </tr>
            </thead>

            <tbody>
              <?php foreach($promotelistorder as $key => $item){?>
                  <tr>
                      <td><?php echo $key+1;?></td>
                      <td><?php echo isset($item['username'])?$item['username']:"";?></td>
                      <td><?php echo isset($item['goods_name'])?$item['goods_name']:"";?></td>
											<td><?php echo isset($item['commission'])?$item['commission']:"";?></td>
                      <td><?php echo date('Y-m-d',strtotime($item['create_time']));?></td>
                  </tr>
              <?php }?>
              <?php if(!$promotelistorder){?>
                <tr>
                  <td style="text-align:center" colspan="5">没有任何记录</td>
                </tr>
              <?php }?>
            </tbody>
          </table>
          <?php }elseif($type == 3){?>
          <!-- 商家用户 -->
          <table class="tablesorter" cellspacing="0">
            <thead>
              <tr>
                <th>编号</th>
                <th>用户</th>
                <th>注册日期</th>
              </tr>
            </thead>

            <tbody>
              <?php foreach($promotelistseller as $key => $item){?>
                  <tr>
                      <td><?php echo $key+1;?></td>
                      <td><?php echo isset($item['username'])?$item['username']:"";?></td>
                      <td><?php echo date('Y-m-d',strtotime($item['create_time']));?></td>
                  </tr>
              <?php }?>
              <?php if(!$promotelistseller){?>
                <tr>
                  <td style="text-align:center" colspan="3">没有任何记录</td>
                </tr>
              <?php }?>
            </tbody>
          </table>
          <?php }else{?>
          <!-- 个人用户 -->
          <table class="tablesorter" cellspacing="0">
            <thead>
              <tr>
                <th>编号</th>
                <th>用户</th>
                <th>注册日期</th>
              </tr>
            </thead>

            <tbody>
              <?php foreach($promotelistperson as $key => $item){?>
                  <tr>
                      <td><?php echo $key+1;?></td>
                      <td><?php echo isset($item['username'])?$item['username']:"";?></td>
                      <td><?php echo date('Y-m-d',strtotime($item['create_time']));?></td>
                  </tr>
              <?php }?>
              <?php if(!$promotelistperson){?>
                <tr>
                  <td style="text-align:center" colspan="3">没有任何记录</td>
                </tr>
              <?php }?>
            </tbody>
          </table>
          <?php }?>
      </div>
  </div>
</article>

	</section>
	<!--主题内容 结束-->

	<script type="text/javascript">
	//菜单图片ICO配置
	function menuIco(val)
	{
		var icoConfig = {
			"管理首页" : "icn_tags",
			"销售额统计" : "icn_settings",
			"货款明细列表" : "icn_categories",
			"货款结算申请" : "icn_photo",
			"商品列表" : "icn_categories",
			"添加商品" : "icn_new_article",
			"平台共享商品" : "icn_photo",
			"商品咨询" : "icn_audio",
			"商品评价" : "icn_audio",
			"商品退款" : "icn_audio",
			"规格列表" : "icn_categories",
			"订单列表" : "icn_categories",
			"团购" : "icn_view_users",
			"促销活动列表" : "icn_categories",
			"物流配送" : "icn_folder",
			"发货地址" : "icn_jump_back",
			"资料修改" : "icn_profile",
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