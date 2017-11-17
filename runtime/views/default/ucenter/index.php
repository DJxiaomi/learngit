<?php 
	$myCartObj  = new Cart();
	$myCartInfo = $myCartObj->getMyCart();
	$siteConfig = new Config("site_config");
	$callback   = IReq::get('callback') ? urlencode(IFilter::act(IReq::get('callback'),'url')) : '';
	$navigation_list = navigation_class::get_navigation_list(1,0);
	$navigation_list2 = navigation_class::get_navigation_list(2,0);
	$user_id = $this->user['user_id'];
	$member_info = member_class::get_member_info($user_id);
	$user_info = user_class::get_user_info($user_id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php if($seo_data['title'] != ''){?><?php echo $seo_data['title'];?><?php }else{?><?php echo $siteConfig->index_seo_title;?><?php }?></title>
	<meta name="Keywords" content="<?php if($seo_data['keywords'] != ''){?><?php echo $seo_data['keywords'];?><?php }else{?><?php echo $siteConfig->index_seo_keywords;?><?php }?>" >
	<meta name="description" content="<?php if($seo_data['description'] !=''){?><?php echo $seo_data['description'];?><?php }else{?><?php echo $siteConfig->index_seo_description;?><?php }?>" />
	<meta property="qc:admins" content="246176725764545451116375" />
	<link type="image/x-icon" href="favicon.ico" rel="icon">

	<?php if(!$this->index){?>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<?php }?>
	<script type='text/javascript' src='<?php echo $this->getWebViewPath()."skin/default/school/js/jquery.min.js";?>'></script>
	<script type='text/javascript' src='<?php echo $this->getWebViewPath()."javascript/layer/layer.js";?>'></script>
	<script type='text/javascript' src='<?php echo $this->getWebViewPath()."javascript/site.js";?>'></script>
	<script type='text/javascript' src='<?php echo $this->getWebViewPath()."javascript/jquery_lazyload/jquery.lazyload.js";?>'></script>
	<link href="<?php echo $this->getWebSkinPath()."css/font-awesome.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/sited.css";?>" rel="stylesheet" type="text/css" />
</head>
<style>

</style>
<body class="index">

	<!-- 工具条 S -->
	 <div class="toolbar">
		<a href="#"><div class="top-btn"><i></i></div></a>
		<ul>
        	<a href="tencent://message/?Menu=yes&amp;uin=2821518520&amp;Service=58&amp;SigT=A7F6FEA02730C9881B11E0AE7AF2E2413E3090997F5951E7CFC7F66A8EF4F5D7A3233F568A8EBC2B984019AC21FF99093F241FB5CD7A7DD4C39596B28D63C849FBCF4A5AED55184EFE696F36F9FF6428EEC729D42EF963C0FD5E9BAC2AD18620E7ADFC9387D83C4B46A7B0C2DC4B63341934EE44C822C196"><li><div class="qq"><i></i></div></li></a>
            <li><div class="wechat-icon"><i></i></div><span class="phone-box"><i class="wechat-erweima"></i><p>微信公众号</p></span></li>
            <a href="<?php echo IUrl::creatUrl("/ucenter/index");?>"><li><div class="tel"><i></i></div><span class="normal tel_span"><p>0731-28308258</p></span></li></a>
			<a href="<?php echo IUrl::creatUrl("/ucenter/index");?>"><li><div class="yonghu"><i></i></div><span class="normal user_span"><p class="user">个人信息</p></span></li></a>
			<a href="<?php echo IUrl::creatUrl("/simple/cart");?>" ><li><div class="shopcar"><i></i></div><span class="normal"><p>课程表</p></span></li></a>
			<li><div class="phone-icon"><i></i></div><span class="phone-box"><i class="phone-erweima"></i><p class="phone">手机APP</p></span></li>

		</ul>

	 </div>
	 <!-- 工具条 E -->

	 <!-- fixed topbar start -->
	 <div class="TopBar fixtopbar">
		 <div class="Wrap">

				 <div class="fr head-right">
						<?php if($this->user){?>
							您好<a href="<?php echo IUrl::creatUrl("/ucenter/index");?>"><?php echo $this->user['username'];?></a>，欢迎来到<?php echo $siteConfig->name;?>！[<a href="<?php echo IUrl::creatUrl("/simple/logout");?>" class="reg red">退出</a>]
						<?php }else{?>
							<a href="<?php echo IUrl::creatUrl("ucenter/index");?>" >你好，请登录</a>
							<a href="<?php echo IUrl::creatUrl("simple/reg?callback=".$callback."");?>" >免费注册</a>
						<?php }?>

				<?php if($navigation_list){?>
					<?php foreach($navigation_list as $key => $item){?>
						<?php if($item['type'] == 1){?>
							<a href="<?php echo IUrl::creatUrl("".$item['link']."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a>
						<?php }elseif($item['type'] == 2){?>
							<a class="place-on navigation_menu" href="javascript:void(0);"><?php echo isset($item['name'])?$item['name']:"";?><i class="arrow-icon"></i></a>
							<?php if($item['child']){?>
								<ul class="navigation_child nav_module_<?php echo isset($key)?$key:"";?>">
									<?php foreach($item['child'] as $key => $val){?>
										<li><a class=" " href="<?php echo IUrl::creatUrl("".$val['link']."");?>"><?php echo isset($val['name'])?$val['name']:"";?></a></li>
									<?php }?>
								</ul>
							<?php }?>
						<?php }else{?>
							<a class="navigation_menu sjlx-on" href="javascript:void(0);"><i class="phone-icon"></i><?php echo isset($item['name'])?$item['name']:"";?><i class="arrow-icon"></i></a>
							<ul class="navigation_child sjlx">
								<li>
									<div class="erweima">
										<a href="javascript:void(0);">
											<img src="<?php echo $this->getWebSkinPath()."images/erweima.png";?>" data="<?php echo $this->getWebSkinPath()."images/erweima.png";?>" />
										</a>
									</div>
								</li>
							</ul>
						<?php }?>
					<?php }?>
				<?php }?>
				</div>
			<div class="clear"></div>
		</div>
	 </div>
	 <!-- fixed topbar end -->

	<!-- Header S -->
	<div class="Header ">
		 <!-- TopBar -->
		 <div class="TopBar">

		 </div>
		 <!-- TopBox -->
		 <div class="TopBox Wrap">
				 <!-- logo -->
				 <a class="logo fl" href="<?php echo IUrl::creatUrl("site");?>" title="乐享生活"></a>
				 <!-- search -->
				 <div class="search fl">
						<div class="searchTool">
								<form method='get' action='<?php echo IUrl::creatUrl("site/search_list");?>' id="form_keyword">
										<input type='hidden' name='controller' value='site' />
										<input type='hidden' name='action' value='pro_list' />
										<input class="txtSearch" type="text" name='word' autocomplete="off" placeholder="课程名称" <?php if($word){?>value="<?php echo isset($word)?$word:"";?>"<?php }?> />
										 <div class="btnSearch">
												<input class="lbl" type="button" value="搜索" onclick="checkInput('word','课程名称...');" />
										 </div>
										 <div class="clear"></div>
								 </form>
						</div>
						<div class="clear"></div>
				 </div>
				 <!-- signlan -->
				 <div class="sign fr">
					 <a class="shopping-car" href="<?php echo IUrl::creatUrl("/simple/cart");?>">
						 <i class="shopping-icon"></i>课程清单(<span name="mycart_count"><?php echo isset($myCartInfo['count'])?$myCartInfo['count']:"";?></span>)<i class="arrow-icon-right"></i>
					 </a>
				 </div>
				 <div class="clear"></div>
		 </div>
		 <!-- Nav -->
		 <div class="Nav">
			 <div class="Nav_left"></div>
				<div class="mainNav Wrap">
					 <ul class="nav_menu">
					 			<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '')){?>
						 		 <li  id="first_all" class="nav_menu-item first-child"><span>全部分类</span><div >ALL CATEGORIES</div>
					<div class="all_cate">
                     <?php foreach(Api::run('getCategoryListTop') as $k => $first){?>
	                    <div class="Title1 part01" id="title1<?php echo isset($first['id'])?$first['id']:"";?>">

						  <div class="title_menu">	<a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$first['id']."");?>" ><?php echo isset($first['name'])?$first['name']:"";?></a></div>

						 <div class="secnod_menu" id="second<?php echo isset($first['id'])?$first['id']:"";?>">
							<ul >				<?php foreach(Api::run('getCategoryByParentid',array('#parent_id#',$first['id'])) as $key => $second){?>

								<li ><a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$second['id']."");?>"><?php echo isset($second['name'])?$second['name']:"";?></a></li>
								<?php }?>

							</ul>
			              </div>
                         </div>
						 <?php }?>
						 </div>
								 </li>

								 <?php }else{?>
								 <li   class="nav_menu-item first-child"><a href="javascript:void(0);">全部分类<div>ALL CATEGORIES</div></a>




								 </li>
						 		 <?php }?>
								 <?php foreach(Api::run('getGuideList') as $kk => $item){?>

								 	<?php  $i = 0;?>
								 	<li class="nav_menu-item <?php if(!$kk){?>sec-child<?php }?>"><a href="<?php echo IUrl::creatUrl("".$item['link']."");?>"><?php echo isset($item['name'])?$item['name']:"";?><div><?php if(!$kk){?>HOME PAGE<?php }elseif($kk == 1){?>FREE CLASS<?php }elseif($kk==2){?>COUPONS<?php }elseif($kk == 3){?>PREFERENTIAL<?php }elseif($kk == 4){?>ORGANIZATION<?php }elseif($kk == 5){?>INDIVIDUAL<?php }elseif($kk==6){?>TUTORING<?php }else{?>INFORMATION<?php }?></div></a></li>
									<?php  $i++;?>
								 <?php }?>
								 <div class="clear"></div>
					 </ul>
				</div>
				<div class="Nav_right"></div>


		 </div>
		 <script>
		 $(document).ready(function(){
		  $("#first_all").mouseover(function(){
			$(".all_cate").css("display","block");
		  });
		  $(".all_cate").mouseout(function(){
			$(".all_cate").css("display","none");
		  });
       });


</script>

		 <script type="text/javascript">
				function set_navigation()
				{
					var left = ($(window).width() - 1200)/2;
					$('.Nav_left').css('width', left);
					$('.Nav_right').css('width', left);
				}
				window.onresize = set_navigation;
				$(document).ready(function(){
					set_navigation();
				});
		 </script>
	</div>
	<!-- Header E -->

	<!-- 内容 S -->
	<?php if($this->getId() != 'ucenter'){?>
	<div class="<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '') || ($this->getId() == 'site' && $_GET['action'] == 'intro')){?>module_content_index<?php }else{?>module_content<?php }?>">
		



<link href="<?php echo $this->getWebSkinPath()."css/ucenter_index.css";?>" rel="stylesheet" type="text/css" />

<div class="main f_r">
    <?php if($msgNum>0){?>
    <div class="prompt m_10">
        <b>温馨提示：</b>您有<span class="red"><?php echo isset($msgNum)?$msgNum:"";?></span> 条站内未读短信息，<a class="blue" href="<?php echo IUrl::creatUrl("/ucenter/message");?>">现在去看看</a>
    </div>
    <?php }?>

	<div class="userinfo_bar"><span class="f_r">上一次登录时间：<?php echo ISafe::get('last_login');?></span><b class="f14">您好，<?php echo isset($this->user['username'])?$this->user['username']:"";?> 欢迎回来!</b></div>
	<div class="box clearfix">
		<h3>用户信息</h3>
		<dl class="userinfo_box">
			<dt>
			<?php $user_ico = $this->user['head_ico']?>
			<a class="ico"><img id="user_ico_img" src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$user_ico."");?>"  alt="" onerror="this.src='<?php echo $this->getWebSkinPath()."images/front/user_ico.gif";?>'" /></a>
			<a class="blue" href="javascript:select_ico();">修改头像</a>
			</dt>
			<dd>
			<table width="100%" cellpadding="0" cellspacing="0">
				<col width="350px" />
				<col />
				<tr>
					<td>你的账户目前总积分：<b class="red2"><?php echo isset($user['point'])?$user['point']:"";?> 分</b>&nbsp;&nbsp;&nbsp;<a class="blue" href="<?php echo IUrl::creatUrl("/ucenter/integral");?>">查看积分历史</a></td>
					<td>你的订单交易总数量：<b class="red2"><?php echo isset($statistics['num'])?$statistics['num']:"";?> 笔</b>&nbsp;&nbsp;&nbsp;<a class="blue" href="<?php echo IUrl::creatUrl("/ucenter/order");?>">进入订单列表</a></td>
				</tr>
				<tr>
					<td>总消费额：<b class="red2">
					￥<?php echo isset($statistics['amount'])?$statistics['amount']:"";?></b></td>
					<td>预存款余额：<b class="red2">￥<?php echo isset($user['balance'])?$user['balance']:"";?></b></td>
				</tr>
				<tr>
					<td>代金券：<b class="red2"><?php echo isset($propData['prop_num'])?$propData['prop_num']:"";?> 张</b></td>
					<td>经验值：<b class="red2"><?php echo isset($user['exp'])?$user['exp']:"";?></b></td>
				</tr>
			</table>

			<div class="stat">
				<span>待评价商品：<label>(<b><a class="red2" href="<?php echo IUrl::creatUrl("/ucenter/evaluation");?>"><?php echo statistics::countUserWaitComment($this->user['user_id']);?></a></b>)</label></span>
				<span>待付款订单：<label>(<b><a class="red2" href="<?php echo IUrl::creatUrl("/ucenter/order");?>"><?php echo statistics::countUserWaitPay($this->user['user_id']);?></a></b>)</label></span>
				<span>待确认收货：<label>(<b><a class="red2" href="<?php echo IUrl::creatUrl("/ucenter/order");?>"><?php echo statistics::countUserWaitCommit($this->user['user_id']);?></a></b>)</label></span>
			</div>
			</dd>
		</dl>
	</div>
	<h3 class="bg">我的订单</h3>
	<div class="box m_10">
		<table class="list_table" width="100%" cellpadding="0" cellspacing="0">
			<col width="140px" />
			<tr>
				<th>订单编号</th><th>下单日期</th><th>收货人</th><th>支付方式</th><th>总金额</th><th>订单状态</th>
			</tr>
			<?php foreach(Api::run('getOrderListByUserid',array('#user_id#',$user['user_id'])) as $key => $item){?>
			<tr>
				<td><a href="<?php echo IUrl::creatUrl("/ucenter/order_detail/id/".$item['id']."");?>"><?php echo isset($item['order_no'])?$item['order_no']:"";?></a></td>
				<td><?php echo isset($item['create_time'])?$item['create_time']:"";?></td>
				<td><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td>
				<td><?php echo isset($this->payments[$item['pay_type']]['name'])?$this->payments[$item['pay_type']]['name']:"";?></td>
				<td>￥<?php echo ($item['order_amount']);?></td>
				<td>
					<?php $orderStatus = Order_Class::getOrderStatus($item)?>
					<b class="<?php if($orderStatus >= 6){?>green<?php }else{?>orange<?php }?>"><?php echo Order_Class::orderStatusText($orderStatus);?></b>
				</td>
			</tr>
			<?php }?>

			<tfoot><tr><td colspan="6" class="t_r"><a class="blue" href="<?php echo IUrl::creatUrl("/ucenter/order");?>">更多订单&gt;&gt;</a></td></tr></tfoot>
		</table>
	</div>
	<div class="box">
		<div class="title"><h2>也许你会对下列商品感兴趣</h2></div>
		<div class="cont clearfix">
			<ul class="prolist f_l">
				<?php foreach(Api::run('getGoodsByCommendgoods') as $key => $item){?>
				<?php $goodsObj1 = Seller_class::get_seller_info_by_bid($item['brand_id'])?>
				
				<li class="introd">
				<div class="pro_img">
				<a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>" target="_black"><img class="lazy" data-original="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."");?>" src="<?php echo $this->getWebSkinPath()."images/dsanke.png";?>" alt="<?php echo isset($item['name'])?$item['name']:"";?>" ></a>
				</div>
				<div class="intro">
				<p class="pro_title" ><a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>" target='_black'><?php echo isset($item['name'])?$item['name']:"";?></p>
				<p class="price_new"><?php echo isset($item['keywords'])?$item['keywords']:"";?></p>
				<p class="intro_short"><?php echo isset($goodsObj1['shortname'])?$goodsObj1['shortname']:"";?></p>
                <p class="intro_address"><?php echo isset($goodsObj1['address'])?$goodsObj1['address']:"";?></p>
				</a>
				</div>
				</li>
				<?php }?>
			</ul>
		</div>
	</div>
</div>
 
<script>
//鼠标划过事件
		$('.introd').hover(function(){
		$(this).addClass('hover');
	}, function(){
		$(this).removeClass('hover');
	});
 </script>

<script type='text/javascript'>
//选择头像
function select_ico()
{
	<?php $callback = urlencode(IUrl::creatUrl('/ucenter/user_ico_upload'))?>
	art.dialog.open('<?php echo IUrl::creatUrl("/block/photo_upload?callback=".$callback."");?>',
	{
		'id':'user_ico',
		'title':'设置头像',
		'ok':function(iframeWin, topWin)
		{
			iframeWin.document.forms[0].submit();
			return false;
		}
	});
}

//头像上传回调函数
function callback_user_ico(content)
{
	var content = eval(content);
	if(content.isError == true)
	{
		alert(content.message);
	}
	else
	{
		$('#user_ico_img').prop('src',content.data);
	}
	art.dialog({id:'user_ico'}).close();
}
</script>
	</div>
	<?php }else{?>
	<style>
	.f_l{float:left;}
	</style>
	<div class="module_content">
			<div class="ucenter container">
			<div class="position">
				您当前的位置： <a href="<?php echo IUrl::creatUrl("");?>">首页</a> » <a href="<?php echo IUrl::creatUrl("/ucenter/index");?>">我的账户</a>
			</div>
			<div class="wrapper clearfix">
				<div class="sidebar f_l">

					<div class="box">
						<div class="title"><h2 class='bg5'>个人中心</h2></div>
						<div class="cont">
							<ul class="list">
								<!-- <li><a href="<?php echo IUrl::creatUrl("/ucenter/address");?>">地址管理</a></li> -->
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/info");?>"><i class="icon-user"></i>个人信息</a></li>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/favorite");?>"><i class="icon-star"></i>收藏夹</a></li>
							</ul>
						</div>
					</div>

					<div class="box">
						<div class="title"><h2>财务中心</h2></div>
						<div class="cont">
							<ul class="list">
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/account_log");?>"><i class="icon-bookmark"></i>我的账户</a></li>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/redpacket");?>"><i class="icon-book"></i>我的代金券</a></li>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/order");?>"><i class="icon-shopping-cart"></i>我的订单</a></li>
							</ul>
						</div>
					</div>

					<div class="box">
						<div class="title"><h2>应用中心</h2></div>
						<div class="cont">
							<ul class="list">
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/order_transfer_list");?>"><i class="icon-share-alt"></i>我的转让</a></li>
								<?php if($user_info['is_equity'] == 1){?>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/equity");?>" class="bt-none"><i class="icon-money"></i>我的股权信息</a></li>
								<?php }?>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/tutor_list");?>" class="bt-none"><i class="icon-file"></i>我的家教</a></li>
								<?php if($member_info['group_id'] == 2){?>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/booking_list");?>" class="bt-none"><i class="icon-file"></i>我的预定表</a></li>
								<?php }?>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/promote");?>" class="bt-none"><i class="icon-group"></i>我的推广</a></li>
							</ul>
						</div>
					</div>

					<div class="box">
						<div class="title"><h2 class='bg2'>服务中心</h2></div>
						<div class="cont">
							<ul class="list">
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/complain");?>"><i class="icon-comment-alt"></i>站点建议</a></li>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/consult");?>"><i class="icon-comment"></i>报名咨询</a></li>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/evaluation");?>"><i class="icon-edit"></i>课后评价</a></li>
							</ul>
						</div>
					</div>

					<div class="box">
						<div class="title"><h2 class='bg3'>资讯</h2></div>
						<div class="cont">
							<ul class="list">
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/message");?>"><i class="icon-envelope"></i>短信息</a></li>
								<li ><a href="<?php echo IUrl::creatUrl("/ucenter/tuiguang");?>"><i class="icon-group"></i>推广人</a></li>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/article_list");?>" class="bt-none"><i class="icon-file"></i>我的文章</a></li>
							</ul>
						</div>
					</div>
				</div>
				



<link href="<?php echo $this->getWebSkinPath()."css/ucenter_index.css";?>" rel="stylesheet" type="text/css" />

<div class="main f_r">
    <?php if($msgNum>0){?>
    <div class="prompt m_10">
        <b>温馨提示：</b>您有<span class="red"><?php echo isset($msgNum)?$msgNum:"";?></span> 条站内未读短信息，<a class="blue" href="<?php echo IUrl::creatUrl("/ucenter/message");?>">现在去看看</a>
    </div>
    <?php }?>

	<div class="userinfo_bar"><span class="f_r">上一次登录时间：<?php echo ISafe::get('last_login');?></span><b class="f14">您好，<?php echo isset($this->user['username'])?$this->user['username']:"";?> 欢迎回来!</b></div>
	<div class="box clearfix">
		<h3>用户信息</h3>
		<dl class="userinfo_box">
			<dt>
			<?php $user_ico = $this->user['head_ico']?>
			<a class="ico"><img id="user_ico_img" src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$user_ico."");?>"  alt="" onerror="this.src='<?php echo $this->getWebSkinPath()."images/front/user_ico.gif";?>'" /></a>
			<a class="blue" href="javascript:select_ico();">修改头像</a>
			</dt>
			<dd>
			<table width="100%" cellpadding="0" cellspacing="0">
				<col width="350px" />
				<col />
				<tr>
					<td>你的账户目前总积分：<b class="red2"><?php echo isset($user['point'])?$user['point']:"";?> 分</b>&nbsp;&nbsp;&nbsp;<a class="blue" href="<?php echo IUrl::creatUrl("/ucenter/integral");?>">查看积分历史</a></td>
					<td>你的订单交易总数量：<b class="red2"><?php echo isset($statistics['num'])?$statistics['num']:"";?> 笔</b>&nbsp;&nbsp;&nbsp;<a class="blue" href="<?php echo IUrl::creatUrl("/ucenter/order");?>">进入订单列表</a></td>
				</tr>
				<tr>
					<td>总消费额：<b class="red2">
					￥<?php echo isset($statistics['amount'])?$statistics['amount']:"";?></b></td>
					<td>预存款余额：<b class="red2">￥<?php echo isset($user['balance'])?$user['balance']:"";?></b></td>
				</tr>
				<tr>
					<td>代金券：<b class="red2"><?php echo isset($propData['prop_num'])?$propData['prop_num']:"";?> 张</b></td>
					<td>经验值：<b class="red2"><?php echo isset($user['exp'])?$user['exp']:"";?></b></td>
				</tr>
			</table>

			<div class="stat">
				<span>待评价商品：<label>(<b><a class="red2" href="<?php echo IUrl::creatUrl("/ucenter/evaluation");?>"><?php echo statistics::countUserWaitComment($this->user['user_id']);?></a></b>)</label></span>
				<span>待付款订单：<label>(<b><a class="red2" href="<?php echo IUrl::creatUrl("/ucenter/order");?>"><?php echo statistics::countUserWaitPay($this->user['user_id']);?></a></b>)</label></span>
				<span>待确认收货：<label>(<b><a class="red2" href="<?php echo IUrl::creatUrl("/ucenter/order");?>"><?php echo statistics::countUserWaitCommit($this->user['user_id']);?></a></b>)</label></span>
			</div>
			</dd>
		</dl>
	</div>
	<h3 class="bg">我的订单</h3>
	<div class="box m_10">
		<table class="list_table" width="100%" cellpadding="0" cellspacing="0">
			<col width="140px" />
			<tr>
				<th>订单编号</th><th>下单日期</th><th>收货人</th><th>支付方式</th><th>总金额</th><th>订单状态</th>
			</tr>
			<?php foreach(Api::run('getOrderListByUserid',array('#user_id#',$user['user_id'])) as $key => $item){?>
			<tr>
				<td><a href="<?php echo IUrl::creatUrl("/ucenter/order_detail/id/".$item['id']."");?>"><?php echo isset($item['order_no'])?$item['order_no']:"";?></a></td>
				<td><?php echo isset($item['create_time'])?$item['create_time']:"";?></td>
				<td><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td>
				<td><?php echo isset($this->payments[$item['pay_type']]['name'])?$this->payments[$item['pay_type']]['name']:"";?></td>
				<td>￥<?php echo ($item['order_amount']);?></td>
				<td>
					<?php $orderStatus = Order_Class::getOrderStatus($item)?>
					<b class="<?php if($orderStatus >= 6){?>green<?php }else{?>orange<?php }?>"><?php echo Order_Class::orderStatusText($orderStatus);?></b>
				</td>
			</tr>
			<?php }?>

			<tfoot><tr><td colspan="6" class="t_r"><a class="blue" href="<?php echo IUrl::creatUrl("/ucenter/order");?>">更多订单&gt;&gt;</a></td></tr></tfoot>
		</table>
	</div>
	<div class="box">
		<div class="title"><h2>也许你会对下列商品感兴趣</h2></div>
		<div class="cont clearfix">
			<ul class="prolist f_l">
				<?php foreach(Api::run('getGoodsByCommendgoods') as $key => $item){?>
				<?php $goodsObj1 = Seller_class::get_seller_info_by_bid($item['brand_id'])?>
				
				<li class="introd">
				<div class="pro_img">
				<a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>" target="_black"><img class="lazy" data-original="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."");?>" src="<?php echo $this->getWebSkinPath()."images/dsanke.png";?>" alt="<?php echo isset($item['name'])?$item['name']:"";?>" ></a>
				</div>
				<div class="intro">
				<p class="pro_title" ><a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>" target='_black'><?php echo isset($item['name'])?$item['name']:"";?></p>
				<p class="price_new"><?php echo isset($item['keywords'])?$item['keywords']:"";?></p>
				<p class="intro_short"><?php echo isset($goodsObj1['shortname'])?$goodsObj1['shortname']:"";?></p>
                <p class="intro_address"><?php echo isset($goodsObj1['address'])?$goodsObj1['address']:"";?></p>
				</a>
				</div>
				</li>
				<?php }?>
			</ul>
		</div>
	</div>
</div>
 
<script>
//鼠标划过事件
		$('.introd').hover(function(){
		$(this).addClass('hover');
	}, function(){
		$(this).removeClass('hover');
	});
 </script>

<script type='text/javascript'>
//选择头像
function select_ico()
{
	<?php $callback = urlencode(IUrl::creatUrl('/ucenter/user_ico_upload'))?>
	art.dialog.open('<?php echo IUrl::creatUrl("/block/photo_upload?callback=".$callback."");?>',
	{
		'id':'user_ico',
		'title':'设置头像',
		'ok':function(iframeWin, topWin)
		{
			iframeWin.document.forms[0].submit();
			return false;
		}
	});
}

//头像上传回调函数
function callback_user_ico(content)
{
	var content = eval(content);
	if(content.isError == true)
	{
		alert(content.message);
	}
	else
	{
		$('#user_ico_img').prop('src',content.data);
	}
	art.dialog({id:'user_ico'}).close();
}
</script>
			</div>
		</div>
	<?php }?>
	<!-- 内容 E -->



	<!-- Footer S -->
	<div class="footer">
		<div class="Wrap">
	    	<!--up -->
		    <div class="footer-left">
					<?php foreach($navigation_list2 as $key => $helpCat){?>
						<?php if($key < 4){?>
				    	<ul>
				    		<h3 class="foot-title"><?php echo isset($helpCat['name'])?$helpCat['name']:"";?></h3>
				    		<?php foreach($helpCat['child'] as $key => $item){?>
									<li><a href="<?php echo IUrl::creatUrl("".$item['link']."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></li>
								<?php }?>
				    	</ul>
						<?php }?>
		    	<?php }?>
		    </div>
				<div class="footer-center">
					<ul>
						<li class="tel">全国统一免费咨询热线</li>
						<li class="tel_bg"></li>
						<li class="addr">地址：中心广场大汉希尔顿1栋2601</li>
					</ul>
				</div>
				<div class="footer-right">
					<ul>
						<li>
							第三课APP<br /><img class="lazy" data-original="<?php echo $this->getWebSkinPath()."images/qrcode_1.png";?>"/>
						</li>
						<li>
							第三课微信公众号<br /><img class="lazy" data-original="<?php echo $this->getWebSkinPath()."images/qrcode_2.png";?>" />
						</li>
					</ul>
				</div>
		    <div class="clear"></div>
		    <!-- copyright -->
		    <div class="copyright">
		        <div class="Wrap">
					<div class="tubbiao">
	<!-- <a href="http://webscan.360.cn/index/checkwebsite/url/www.dsanke.com"><img border="0" src="http://img.webscan.360.cn/status/pai/hash/a1f20bc445d31538899515dd5b5ff053"/></a> -->
  <a href="http://webscan.360.cn/index/checkwebsite/url/www.lelele999.com"><img src="<?php echo $this->getWebSkinPath()."images/t013365a715435676e8.jpg";?>"/></a>
		 </div>
		            <p clas="footP1">Powered by 第三课</p>
		            <p class="footP1">Copyright©2014-2017&nbsp;<a class="copyys" target="_blank" href="http://www.miibeian.gov.cn/">湘ICP备15005945号-1</a> &nbsp;版权所有</p>
		        </div>
		    </div>
	    </div>
	</div>
	<!-- Footer E -->

	<?php if($id == 851){?>
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/form.css";?>" />
	<script>var pid = <?php echo isset($id)?$id:"";?>;</script>
	<script language="javascript" src="<?php echo $this->getWebSkinPath()."scripts/form.js";?>"></script>
	<?php }?>
	<!-- 图片懒加载 -->



	<?php if($this->getId() == 'ucenter'){?>

	<script type='text/javascript'>
	//DOM加载完毕后运行
	$(function()
	{
		$(".tabs").each(function(i){
		    var parrent = $(this);
			$('.tabs_menu .node',this).each(function(j){
				var current=".node:eq("+j+")";
				$(this).bind('click',function(event){
					$('.tabs_menu .node',parrent).removeClass('current');
					$(this).addClass('current');
					$('.tabs_content>.node',parrent).css('display','none');
					$('.tabs_content>.node:eq('+j+')',parrent).css('display','block');
				});
			});
		});

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

		menu_current();

		/**
		$('input:text[name="word"]').bind({
			keyup:function(){autoComplete('<?php echo IUrl::creatUrl("/site/autoComplete");?>','<?php echo IUrl::creatUrl("/site/pro_list/word/@word@");?>','<?php echo $siteConfig->auto_finish;?>');}
		});
		**/

		<?php $word = IReq::get('word') ? IFilter::act(IReq::get('word'),'text') : '教育机构或课程名称...'?>
		//$('input:text[name="word"]').val("<?php echo isset($word)?$word:"";?>");

		//课程表div层
		$('.mycart').hover(
			function(){
				showCart('<?php echo IUrl::creatUrl("/simple/showCart");?>');
			},
			function(){
				$('#div_mycart').hide('slow');
			}
		);

		//二维码
		$('.erweima a').click(function(){
			var _data = $(this).find("img").attr('data');
			layer.open({
				type: 1,
				skin: 'layui-layer-demo', //样式类名
				closeBtn: 0, //不显示关闭按钮
				shadeClose: true, //开启遮罩关闭
				content: '<img src="' + _data + '" />'
			});
		})

		$('.navigation_menu').each(function(){
			var _parent_width = $(this).parent().width();
			var _left = $(this).position().left;
			var _width = $(this).width();
			$(this).next('.navigation_child').css('right', _parent_width - _left - _width - 16);
		})
	});
	</script>
	<?php }?>

	<?php if($this->getId() == 'ucenter'){?>
		<style>
		.module_content {width: 1200px; margin: 0px auto;}
		</style>
	<?php }?>
	   <script type="text/javascript" charset="utf-8">

 $(function(){
      $("img.lazy").lazyload({effect: "fadeIn"});
  });
</script>
</body>
</html>
