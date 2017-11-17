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
		<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src='<?php echo $this->getWebViewPath()."javascript/artTemplate/area_select.js";?>'></script>
<link href="<?php echo $this->getWebSkinPath()."css/ucenter_order_detail.css";?>" rel="stylesheet" type="text/css" />
<script src="/resource/scripts/layer/layer.js"></script>
<script language="javascript">
var _check_trade_passwd_url = '<?php echo IUrl::creatUrl("/ucenter/check_trade_password/order_id/".$this->order_info[order_id]."");?>';
var _set_trade_passwd_url = '<?php echo IUrl::creatUrl("/ucenter/reset_trade_passwd");?>';
var _update_trade_passwd_url = '<?php echo IUrl::creatUrl("/ucenter/update_trade_password_ver/order_id/".$this->order_id."");?>';
</script>
<div class="main f_r">
	<div class="uc_title m_10">
		<label class="current"><span>订单详情</span></label>
	</div>

	<div class="prompt_2 m_10">
		<div class="t_part">
			<?php foreach($this->order_log_list as $key => $item){?>
			<p><?php echo isset($item['addtime'])?$item['addtime']:"";?>&nbsp;&nbsp;<span class="black"><?php echo order_log_class::read_log($item);?></span></p>
			<?php }?>
		</div>

		<p>
			<b>订单号：</b><?php echo isset($this->order_info['order_no'])?$this->order_info['order_no']:"";?>
			<b>下单日期：</b><?php echo isset($this->order_info['create_time'])?$this->order_info['create_time']:"";?>
			<b>状态：</b>
			<span class="red2">
				<b class="orange"><?php echo Order_Class::orderStatusText($orderStatus, 1, $this->order_info['statement']);?></b>
	        </span>
			<b>类型：</b><font color="green"><b>购买代金券套餐</b></font>
            <b>验证码：</b><font color="green"><b><?php echo isset($goods_list[0]['verification_code'])?$goods_list[0]['verification_code']:"";?></b></font>
        </p>
        <form action='<?php echo IUrl::creatUrl("/ucenter/order_status");?>' method='post'>
        <p>
	        <input type="hidden" name="order_id" value="<?php echo isset($this->order_info['order_id'])?$this->order_info['order_id']:"";?>" />
	    	  <?php if(in_array($orderStatus,array(1,2))){?>
	        <label class="btn_orange">
	        	<input type="hidden" name='op' value='cancel' />
	        	<input type="submit" value="取消" />
	        </label>
	        <?php }?>

			<?php if($orderStatus == 2 && $this->order_info['order_role'] == 1){?>
			<label class="btn_green">

				<?php if($is_set_trade_passwd){?>
					<input type="button" value="付款" onclick="check_trade_passwd()" />
				<?php }else{?>
					<input type="button" value="付款" onclick="set_trade_passwd()" />
				<?php }?>
			</label>

			<?php }?>


	    </p>
        </form>
	</div>

	<?php foreach($goods_list as $key => $item){?>
	<div class="box m_10" style="display:none;">
		<div class="title">
			<h2><span class="orange">订单信息</span></h2>
		</div>

		<!--收获信息展示-->
		<div class="cont clearfix" id="acceptShow">
			<table class="dotted_table f_l" width="100%" cellpadding="0" cellspacing="0">
				<col width="130px" />
				<col />
				<tr>
					<th>订单状态：</th>
					<td><?php echo Order_Class::orderStatusText($orderStatus);?></td>
				</tr>
				<tr>
					<th>学费：</th>
					<td>&yen;<?php echo  number_format($goods_list[0]['market_price'] * $goods_list[0]['goods_nums'], 2, '.', '');?></td>
				</tr>

				<?php if($this->order_info['order_chit'] > 0){?>
				<tr>
					<th>已付学费：</th>
					<td>&yen;<?php echo  number_format($goods_list[0]['market_price'] * $goods_list[0]['goods_nums'], 2, '.', '');?></td>
				</tr>
				<?php }?>

				<?php if($item['rest_price'] > 0){?>
				<tr>
					<th>未付学费：</th>
					<td>&yen;<?php echo isset($this->order_info['rest_price'])?$this->order_info['rest_price']:"";?></td>
				</tr>
				<?php }?>

				<?php if($item['statement'] == 3){?>
				<tr>
					<th>已付定金：</th>
					<td>&yen;<?php echo isset($item['order_amount'])?$item['order_amount']:"";?></td>
				</tr>
				<?php }?>
				<tr>
					<th>优惠后实缴：</th>
					<td>&yen;<?php echo order_class::get_sjzc($this->order_info, $goods_list[0]['market_price'], $item['discount'] );?></td>
				</tr>
			</table>
		</div>
	</div>
	<?php }?>

	<div class="box m_10">
		<div class="title">
			<h2><span class="orange">学员信息</span></h2>
		</div>

		<!--收获信息展示-->
		<div class="cont clearfix" id="acceptShow">
			<table class="dotted_table f_l" width="100%" cellpadding="0" cellspacing="0">
				<col width="130px" />
				<col />
				<tr>
					<th>学员姓名：</th>
					<td><?php echo isset($this->order_info['accept_name'])?$this->order_info['accept_name']:"";?></td>
				</tr>
				<?php if($this->order_info['telphone']){?>
				<tr>
					<th>固定电话：</th>
					<td><?php echo isset($this->order_info['telphone'])?$this->order_info['telphone']:"";?></td>
				</tr>
				<?php }?>
				<tr>
					<th>手机号码：</th>
					<td><?php echo isset($this->order_info['mobile'])?$this->order_info['mobile']:"";?></td>
				</tr>
				<tr class="hide">
					<th>邮编：</th>
					<td><?php echo isset($this->order_info['postcode'])?$this->order_info['postcode']:"";?></td>
				</tr>
			</table>
		</div>
	</div>

	<!--支付和配送-->
  <!--发票信息-->
  <?php if($this->order_info['invoice']==1){?>
	<div class="box m_10">
		<div class="title"><h2><span class="orange">发票信息</span></h2></div>
		<div class="cont clearfix">
			<table class="dotted_table f_l" width="100%" cellpadding="0" cellspacing="0">
				<col width="129px" />
				<col />
				<tr>
					<th>所需税金：</th>
					<td><?php echo isset($this->order_info['taxes'])?$this->order_info['taxes']:"";?></td>
				</tr>
				<tr>
					<th>发票抬头：</th>
					<td><?php echo isset($this->order_info['invoice_title'])?$this->order_info['invoice_title']:"";?></td>
				</tr>
			</table>
		</div>
	</div>
  <?php }?>

	<!--物品清单-->
	<div class="box m_10">
		<div class="title"><h2><span class="orange">套餐清单</span></h2></div>
		<div class="cont clearfix">
			<table class="list_table f_l" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<th>代金券名称</th>
						<th>价格</th>
						<th>总次数</th>
						<th>可用次数</th>
						<th>说明</th>
					</tr>
						<?php foreach($detail_list as $key => $item){?>
						<tr>
						<td><?php echo isset($item['name'])?$item['name']:"";?></td>
						<td><?php echo isset($item['max_price'])?$item['max_price']:"";?></td>
						<td><?php echo isset($item['use_times'])?$item['use_times']:"";?></td>
						<td><?php echo isset($item['availeble_use_times'])?$item['availeble_use_times']:"";?></td>
						<td><?php echo isset($item['limitinfo'])?$item['limitinfo']:"";?></td>
						</tr>
						<?php }?>
				</tbody>
			</table>

		</div>
	</div>

	<div class="gray_box">
		<div class="t_part" style="display: none;">
			<p>总金额：￥<?php echo isset($this->order_info['payable_amount'])?$this->order_info['payable_amount']:"";?></p>
            <?php if($this->order_info['taxes'] > 0){?>
            <p>+ 税金：￥<?php echo isset($this->order_info['taxes'])?$this->order_info['taxes']:"";?></p>
            <?php }?>

            <?php if($this->order_info['pay_fee'] > 0){?>
            <p>+ 支付手续费：￥<?php echo isset($this->order_info['pay_fee'])?$this->order_info['pay_fee']:"";?></p>
            <?php }?>

            <?php if($this->order_info['insured'] > 0){?>
            <p>+ 保价：￥<?php echo isset($this->order_info['insured'])?$this->order_info['insured']:"";?></p>
            <?php }?>

            <?php if($this->order_info['discount']){?>
            <p>订单折扣或涨价：￥<?php echo isset($this->order_info['discount'])?$this->order_info['discount']:"";?></p>
            <?php }?>

            <?php if($this->order_info['promotions'] > 0){?>
            <p>- 促销优惠金额：￥<?php echo isset($this->order_info['promotions'])?$this->order_info['promotions']:"";?></p>
            <?php }?>
		</div>

		<div class="b_part" style="display:none;">
			<p>订单支付金额：<span class="red2">￥<label><?php echo isset($this->order_info['order_amount'])?$this->order_info['order_amount']:"";?></label></span></p>
		</div>
	</div>


</div>

<div class="choose_seller" style="display:none;">
	<div class="seller_list">请选择要确认的学校：
		<select name="seller_id">
			<option value="0">请选择要确认的学校</option>
			<?php foreach($seller_list as $key => $item){?>
				<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['shortname'])?$item['shortname']:"";?></option>
			<?php }?>
		</select>

		<input type="button" class="choose_seller_btn" value="确定" class="btn">
	</div>
</div>




<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/ucenter_order_detail.js";?>"></script>
<script language="javascript">
$(document).ready(function(){
	$('.order_confirm').click(function(){
		layer.open({
            type: 1,
            title:false,
            closeBtn:1,
            area: ['545px', '64px'],
            content: $('.choose_seller')
          });
	});

	$('.choose_seller_btn').on('click',function(){
		var seller_id = $('.layui-layer-content select[name=seller_id]').val();
		if (parseInt(seller_id) == 0 )
		{
			mui.toast('请选择要确认的学校');
			return false;
		}

		var order_id = '<?php echo isset($this->order_info[order_id])?$this->order_info[order_id]:"";?>';
		var url = '/ucenter/order_confirm2/order_id/' + order_id + '/seller_id/' + seller_id;
		location.href = url;
	});
});
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
				<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src='<?php echo $this->getWebViewPath()."javascript/artTemplate/area_select.js";?>'></script>
<link href="<?php echo $this->getWebSkinPath()."css/ucenter_order_detail.css";?>" rel="stylesheet" type="text/css" />
<script src="/resource/scripts/layer/layer.js"></script>
<script language="javascript">
var _check_trade_passwd_url = '<?php echo IUrl::creatUrl("/ucenter/check_trade_password/order_id/".$this->order_info[order_id]."");?>';
var _set_trade_passwd_url = '<?php echo IUrl::creatUrl("/ucenter/reset_trade_passwd");?>';
var _update_trade_passwd_url = '<?php echo IUrl::creatUrl("/ucenter/update_trade_password_ver/order_id/".$this->order_id."");?>';
</script>
<div class="main f_r">
	<div class="uc_title m_10">
		<label class="current"><span>订单详情</span></label>
	</div>

	<div class="prompt_2 m_10">
		<div class="t_part">
			<?php foreach($this->order_log_list as $key => $item){?>
			<p><?php echo isset($item['addtime'])?$item['addtime']:"";?>&nbsp;&nbsp;<span class="black"><?php echo order_log_class::read_log($item);?></span></p>
			<?php }?>
		</div>

		<p>
			<b>订单号：</b><?php echo isset($this->order_info['order_no'])?$this->order_info['order_no']:"";?>
			<b>下单日期：</b><?php echo isset($this->order_info['create_time'])?$this->order_info['create_time']:"";?>
			<b>状态：</b>
			<span class="red2">
				<b class="orange"><?php echo Order_Class::orderStatusText($orderStatus, 1, $this->order_info['statement']);?></b>
	        </span>
			<b>类型：</b><font color="green"><b>购买代金券套餐</b></font>
            <b>验证码：</b><font color="green"><b><?php echo isset($goods_list[0]['verification_code'])?$goods_list[0]['verification_code']:"";?></b></font>
        </p>
        <form action='<?php echo IUrl::creatUrl("/ucenter/order_status");?>' method='post'>
        <p>
	        <input type="hidden" name="order_id" value="<?php echo isset($this->order_info['order_id'])?$this->order_info['order_id']:"";?>" />
	    	  <?php if(in_array($orderStatus,array(1,2))){?>
	        <label class="btn_orange">
	        	<input type="hidden" name='op' value='cancel' />
	        	<input type="submit" value="取消" />
	        </label>
	        <?php }?>

			<?php if($orderStatus == 2 && $this->order_info['order_role'] == 1){?>
			<label class="btn_green">

				<?php if($is_set_trade_passwd){?>
					<input type="button" value="付款" onclick="check_trade_passwd()" />
				<?php }else{?>
					<input type="button" value="付款" onclick="set_trade_passwd()" />
				<?php }?>
			</label>

			<?php }?>


	    </p>
        </form>
	</div>

	<?php foreach($goods_list as $key => $item){?>
	<div class="box m_10" style="display:none;">
		<div class="title">
			<h2><span class="orange">订单信息</span></h2>
		</div>

		<!--收获信息展示-->
		<div class="cont clearfix" id="acceptShow">
			<table class="dotted_table f_l" width="100%" cellpadding="0" cellspacing="0">
				<col width="130px" />
				<col />
				<tr>
					<th>订单状态：</th>
					<td><?php echo Order_Class::orderStatusText($orderStatus);?></td>
				</tr>
				<tr>
					<th>学费：</th>
					<td>&yen;<?php echo  number_format($goods_list[0]['market_price'] * $goods_list[0]['goods_nums'], 2, '.', '');?></td>
				</tr>

				<?php if($this->order_info['order_chit'] > 0){?>
				<tr>
					<th>已付学费：</th>
					<td>&yen;<?php echo  number_format($goods_list[0]['market_price'] * $goods_list[0]['goods_nums'], 2, '.', '');?></td>
				</tr>
				<?php }?>

				<?php if($item['rest_price'] > 0){?>
				<tr>
					<th>未付学费：</th>
					<td>&yen;<?php echo isset($this->order_info['rest_price'])?$this->order_info['rest_price']:"";?></td>
				</tr>
				<?php }?>

				<?php if($item['statement'] == 3){?>
				<tr>
					<th>已付定金：</th>
					<td>&yen;<?php echo isset($item['order_amount'])?$item['order_amount']:"";?></td>
				</tr>
				<?php }?>
				<tr>
					<th>优惠后实缴：</th>
					<td>&yen;<?php echo order_class::get_sjzc($this->order_info, $goods_list[0]['market_price'], $item['discount'] );?></td>
				</tr>
			</table>
		</div>
	</div>
	<?php }?>

	<div class="box m_10">
		<div class="title">
			<h2><span class="orange">学员信息</span></h2>
		</div>

		<!--收获信息展示-->
		<div class="cont clearfix" id="acceptShow">
			<table class="dotted_table f_l" width="100%" cellpadding="0" cellspacing="0">
				<col width="130px" />
				<col />
				<tr>
					<th>学员姓名：</th>
					<td><?php echo isset($this->order_info['accept_name'])?$this->order_info['accept_name']:"";?></td>
				</tr>
				<?php if($this->order_info['telphone']){?>
				<tr>
					<th>固定电话：</th>
					<td><?php echo isset($this->order_info['telphone'])?$this->order_info['telphone']:"";?></td>
				</tr>
				<?php }?>
				<tr>
					<th>手机号码：</th>
					<td><?php echo isset($this->order_info['mobile'])?$this->order_info['mobile']:"";?></td>
				</tr>
				<tr class="hide">
					<th>邮编：</th>
					<td><?php echo isset($this->order_info['postcode'])?$this->order_info['postcode']:"";?></td>
				</tr>
			</table>
		</div>
	</div>

	<!--支付和配送-->
  <!--发票信息-->
  <?php if($this->order_info['invoice']==1){?>
	<div class="box m_10">
		<div class="title"><h2><span class="orange">发票信息</span></h2></div>
		<div class="cont clearfix">
			<table class="dotted_table f_l" width="100%" cellpadding="0" cellspacing="0">
				<col width="129px" />
				<col />
				<tr>
					<th>所需税金：</th>
					<td><?php echo isset($this->order_info['taxes'])?$this->order_info['taxes']:"";?></td>
				</tr>
				<tr>
					<th>发票抬头：</th>
					<td><?php echo isset($this->order_info['invoice_title'])?$this->order_info['invoice_title']:"";?></td>
				</tr>
			</table>
		</div>
	</div>
  <?php }?>

	<!--物品清单-->
	<div class="box m_10">
		<div class="title"><h2><span class="orange">套餐清单</span></h2></div>
		<div class="cont clearfix">
			<table class="list_table f_l" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<th>代金券名称</th>
						<th>价格</th>
						<th>总次数</th>
						<th>可用次数</th>
						<th>说明</th>
					</tr>
						<?php foreach($detail_list as $key => $item){?>
						<tr>
						<td><?php echo isset($item['name'])?$item['name']:"";?></td>
						<td><?php echo isset($item['max_price'])?$item['max_price']:"";?></td>
						<td><?php echo isset($item['use_times'])?$item['use_times']:"";?></td>
						<td><?php echo isset($item['availeble_use_times'])?$item['availeble_use_times']:"";?></td>
						<td><?php echo isset($item['limitinfo'])?$item['limitinfo']:"";?></td>
						</tr>
						<?php }?>
				</tbody>
			</table>

		</div>
	</div>

	<div class="gray_box">
		<div class="t_part" style="display: none;">
			<p>总金额：￥<?php echo isset($this->order_info['payable_amount'])?$this->order_info['payable_amount']:"";?></p>
            <?php if($this->order_info['taxes'] > 0){?>
            <p>+ 税金：￥<?php echo isset($this->order_info['taxes'])?$this->order_info['taxes']:"";?></p>
            <?php }?>

            <?php if($this->order_info['pay_fee'] > 0){?>
            <p>+ 支付手续费：￥<?php echo isset($this->order_info['pay_fee'])?$this->order_info['pay_fee']:"";?></p>
            <?php }?>

            <?php if($this->order_info['insured'] > 0){?>
            <p>+ 保价：￥<?php echo isset($this->order_info['insured'])?$this->order_info['insured']:"";?></p>
            <?php }?>

            <?php if($this->order_info['discount']){?>
            <p>订单折扣或涨价：￥<?php echo isset($this->order_info['discount'])?$this->order_info['discount']:"";?></p>
            <?php }?>

            <?php if($this->order_info['promotions'] > 0){?>
            <p>- 促销优惠金额：￥<?php echo isset($this->order_info['promotions'])?$this->order_info['promotions']:"";?></p>
            <?php }?>
		</div>

		<div class="b_part" style="display:none;">
			<p>订单支付金额：<span class="red2">￥<label><?php echo isset($this->order_info['order_amount'])?$this->order_info['order_amount']:"";?></label></span></p>
		</div>
	</div>


</div>

<div class="choose_seller" style="display:none;">
	<div class="seller_list">请选择要确认的学校：
		<select name="seller_id">
			<option value="0">请选择要确认的学校</option>
			<?php foreach($seller_list as $key => $item){?>
				<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['shortname'])?$item['shortname']:"";?></option>
			<?php }?>
		</select>

		<input type="button" class="choose_seller_btn" value="确定" class="btn">
	</div>
</div>




<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/ucenter_order_detail.js";?>"></script>
<script language="javascript">
$(document).ready(function(){
	$('.order_confirm').click(function(){
		layer.open({
            type: 1,
            title:false,
            closeBtn:1,
            area: ['545px', '64px'],
            content: $('.choose_seller')
          });
	});

	$('.choose_seller_btn').on('click',function(){
		var seller_id = $('.layui-layer-content select[name=seller_id]').val();
		if (parseInt(seller_id) == 0 )
		{
			mui.toast('请选择要确认的学校');
			return false;
		}

		var order_id = '<?php echo isset($this->order_info[order_id])?$this->order_info[order_id]:"";?>';
		var url = '/ucenter/order_confirm2/order_id/' + order_id + '/seller_id/' + seller_id;
		location.href = url;
	});
});
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


