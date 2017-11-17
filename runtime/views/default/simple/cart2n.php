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
<script type='text/javascript' src='<?php echo $this->getWebViewPath()."javascript/orderFormClass.js";?>'></script>
<script type='text/javascript'>
//创建订单表单实例
orderFormInstance = new orderFormClass();

//DOM加载完毕
jQuery(function(){
	//商家信息
	orderFormInstance.seller = <?php echo JSON::encode($this->seller);?>;

	//商品价格
	orderFormInstance.goodsSum = "<?php echo $this->final_sum;?>";

	//配送方式初始化
	orderFormInstance.deliveryInit("<?php echo isset($this->custom['delivery'])?$this->custom['delivery']:"";?>");

	//收货地址数据
	orderFormInstance.addressInit();

	//支付方式
	orderFormInstance.paymentInit("<?php echo isset($this->custom['payment'])?$this->custom['payment']:"";?>");

	//免运费
	orderFormInstance.freeFreight = <?php echo JSON::encode($this->freeFreight);?>;
});
</script>

<div class="wrapper clearfix">
	<div class="position mt_10"><span>您当前的位置：</span> <a href="<?php echo IUrl::creatUrl("");?>"> 首页</a> » 填写核对订单信息</div>
	<div class="myshopping m_10">
		<ul class="order_step">
			<li class="current_prev"><span class="first"><a href='<?php if(IReq::get('id')){?>javascript:window.history.go(-1);<?php }else{?><?php echo IUrl::creatUrl("/simple/cart");?><?php }?>'>1、查看购物车</a></span></li>
			<li class="current"><span>2、填写核对订单信息</span></li>
			<li class="last"><span>3、成功提交订单</span></li>
		</ul>
	</div>

	<form action='<?php echo IUrl::creatUrl("/simple/cart3n");?>' method='post' name='order_form' onsubmit='return orderFormInstance.isSubmit()'>

		<input type='hidden' name='direct_gid' value='<?php echo $this->gid;?>' />
		<input type='hidden' name='direct_type' value='<?php echo $this->type;?>' />
		<input type='hidden' name='direct_num' value='<?php echo $this->num;?>' />
		<input type='hidden' name='direct_promo' value='<?php echo $this->promo;?>' />
		<input type='hidden' name='direct_active_id' value='<?php echo $this->active_id;?>' />

		<div class="cart_box m_10">
			<div class="title">填写核对订单信息</div>
			<div class="cont">

				<!--地址管理 开始-->
				<div class="wrap_box">
					<h3>
						<span class="orange">收货人信息</span>
					</h3>

					<div class="prompt_4 m_10">
						<strong>常用收货地址</strong>
						<ul class="addr_list">
							<?php foreach($this->addressList as $key => $item){?>
							<li id="addressItem<?php echo isset($item['id'])?$item['id']:"";?>">
								<label><input class="radio" name="radio_address" type="radio" value="<?php echo isset($item['id'])?$item['id']:"";?>" onclick="orderFormInstance.getDelivery(<?php echo isset($item['province'])?$item['province']:"";?>);" /><?php echo isset($item['accept_name'])?$item['accept_name']:"";?>&nbsp;&nbsp;&nbsp;<?php echo isset($item['province_val'])?$item['province_val']:"";?> <?php echo isset($item['city_val'])?$item['city_val']:"";?> <?php echo isset($item['area_val'])?$item['area_val']:"";?> <?php echo isset($item['address'])?$item['address']:"";?></label> [<a href="javascript:orderFormInstance.addressEdit(<?php echo isset($item['id'])?$item['id']:"";?>);" style="color:#005ea7;">修改地址</a>] [<a href="javascript:orderFormInstance.addressDel(<?php echo isset($item['id'])?$item['id']:"";?>);" style="color:#005ea7">删除</a>]
							</li>
							<?php }?>
							<li>
								<label><a href="javascript:orderFormInstance.addressAdd();" style="color:#005ea7;">添加新地址</a></label>
							</li>
						</ul>

						<!--收货地址项模板-->
						<script type='text/html' id='addressLiTemplate'>
						<li id="addressItem<%=item['id']%>">
							<label><input class="radio" name="radio_address" type="radio" value="<%=item['id']%>" onclick="orderFormInstance.getDelivery(<%=item['province']%>);" /><%=item['accept_name']%>&nbsp;&nbsp;&nbsp;<%=item['province_val']%> <%=item['city_val']%> <%=item['area_val']%> <%=item['address']%></label> [<a href="javascript:orderFormInstance.addressEdit(<%=item['id']%>);" style="color:#005ea7;">修改地址</a>] [<a href="javascript:orderFormInstance.addressDel(<%=item['id']%>);" style="color:#005ea7">删除</a>]
						</li>
						</script>
					</div>
				</div>
				<!--地址管理 结束-->

				<!--配送方式 开始-->
				<div class="wrap_box">
					<h3>
						<span class="orange">配送方式</span>
					</h3>

					<table width="100%" class="border_table m_10">
						<colgroup>
							<col width="180px" />
							<col />
						</colgroup>

						<tbody>
							<?php foreach(Api::run('getDeliveryList') as $key => $item){?>
							<tr>
								<th><label><input type="radio" name="delivery_id" value="<?php echo isset($item['id'])?$item['id']:"";?>" paytype="<?php echo isset($item['type'])?$item['type']:"";?>" onclick='orderFormInstance.deliverySelected(<?php echo isset($item['id'])?$item['id']:"";?>);' /><?php echo isset($item['name'])?$item['name']:"";?></label></th>
								<td>
									<span id="deliveryShow<?php echo isset($item['id'])?$item['id']:"";?>"></span>
									<?php echo isset($item['description'])?$item['description']:"";?>
									<?php if($item['type'] == 2){?>
									<a href="javascript:orderFormInstance.selectTakeself(<?php echo isset($item['id'])?$item['id']:"";?>);"><span class="red">选择自提点</span></a>
									<span id="takeself<?php echo isset($item['id'])?$item['id']:"";?>"></span>
									<?php }?>
								</td>
							</tr>
							<?php }?>
						</tbody>

						<!--配送信息-->
						<script type='text/html' id='deliveryTemplate'>
							<span style="color:#e4393c">运费：￥<%=item['price']%></span>
							<%if(item['protect_price'] > 0){%>
							<span style="color:#e4393c">保价：￥<%=item['protect_price']%></span>
							<%}%>
						</script>

						<!--物流自提点-->
						<script type='text/html' id='takeselfTemplate'>
							[<%=item['address']%> <%=item['name']%> <%=item['phone']%> <%=item['mobile']%>]
						</script>

						<tfoot>
							<th>指定送货时间：</th>
							<td>
								<label class='attr'><input type='radio' name='accept_time' checked="checked" value='任意' />任意</label>
								<label class='attr'><input type='radio' name='accept_time' value='周一到周五' />周一到周五</label>
								<label class='attr'><input type='radio' name='accept_time' value='周末' />周末</label>
							</td>
						</tfoot>
					</table>
				</div>
				<!--配送方式 结束-->

				<!--支付方式 开始-->
				<div class="wrap_box" id="paymentBox">
					<h3>
						<span class="orange">支付方式</span>
					</h3>

					<table width="100%" class="border_table">
						<colgroup>
							<col width="200px" />
							<col />
						</colgroup>
						<?php foreach(Api::run('getPaymentList') as $key => $item){?>
						<?php $paymentPrice = CountSum::getGoodsPaymentPrice($item['id'],$this->sum);?>
						<tr>
							<th><label><input class="radio" name="payment" alt="<?php echo isset($paymentPrice)?$paymentPrice:"";?>" onclick='orderFormInstance.paymentSelected(<?php echo isset($item['id'])?$item['id']:"";?>);' title="<?php echo isset($item['name'])?$item['name']:"";?>" type="radio" value="<?php echo isset($item['id'])?$item['id']:"";?>" /><?php echo isset($item['name'])?$item['name']:"";?></label></th>
							<td><?php echo isset($item['note'])?$item['note']:"";?> <?php if($paymentPrice){?>支付手续费：￥<?php echo isset($paymentPrice)?$paymentPrice:"";?><?php }?></td>
						</tr>
						<?php }?>
					</table>
				</div>
				<!--支付方式 结束-->

				<!--订单留言 开始-->
				<div class="wrap_box">
					<h3>
						<span class="orange">订单附言</span>
					</h3>

					<table width="100%" class="form_table">
						<colgroup>
							<col width="120px" />
							<col />
						</colgroup>
						<tr>
							<th>订单附言：</th>
							<td><input class="normal" type="text" name='message' /></td>
						</tr>
					</table>
				</div>
				<!--订单留言 结束-->

				<!--购买清单 开始-->
				<div class="wrap_box">

					<h3><span class="orange">购买的商品</span></h3>

					<div class="cart_prompt f14 t_l m_10" <?php if(empty($this->promotion)){?>style="display:none"<?php }?>>
						<p class="m_10 gray"><b class="orange">恭喜，</b>您的订单已经满足了以下优惠活动！</p>
						<?php foreach($this->promotion as $key => $item){?>
						<p class="indent blue"><?php echo isset($item['plan'])?$item['plan']:"";?>，<?php echo isset($item['info'])?$item['info']:"";?></p>
						<?php }?>
					</div>

					<table width="100%" class="cart_table t_c">
						<colgroup>
							<col width="115px" />
							<col />
							<col width="80px" />
							<col width="80px" />
							<col width="80px" />
							<col width="80px" />
							<col width="80px" />
						</colgroup>

						<thead>
							<tr>
								<th>图片</th>
								<th>商品名称</th>
								<th>赠送积分</th>
								<th>单价</th>
								<th>优惠</th>
								<th>代金券</th>
								<th>数量</th>
								<th class="last">小计</th>
							</tr>
						</thead>

						<tbody>
							<!-- 商品展示 开始-->
							<?php foreach($this->goodsList as $key => $item){?>
							<tr>
								<td><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/66/h/66");?>" width="66px" height="66px" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></td>
								<td class="t_l">
									<a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['goods_id']."");?>" class="blue"><?php echo isset($item['name'])?$item['name']:"";?></a>
									<?php if(isset($item['spec_array'])){?>
									<p>
									<?php $spec_array=Block::show_spec($item['spec_array']);?>
									<?php foreach($spec_array as $specName => $specValue){?>
										<?php echo isset($specName)?$specName:"";?>：<?php echo isset($specValue)?$specValue:"";?> &nbsp&nbsp
									<?php }?>
									</p>
									<?php }?>
								</td>
								<td><?php echo isset($item['point'])?$item['point']:"";?></td>
								<td><b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b></td>
								<td>减￥<?php echo isset($item['reduce'])?$item['reduce']:"";?></td>
								<td><?php if($item['prop_info']['value'] > 0){?><input type="checkbox" name="use_chit_list[]" value="1" />使用<?php echo isset($item['prop_info']['value'])?$item['prop_info']['value']:"";?>元<?php }else{?>0<?php }?></td>
								<td><?php echo isset($item['count'])?$item['count']:"";?></td>
								<td id="deliveryFeeBox_<?php echo isset($item['goods_id'])?$item['goods_id']:"";?>_<?php echo isset($item['product_id'])?$item['product_id']:"";?>_<?php echo isset($item['count'])?$item['count']:"";?>"><b class="red2">￥<?php echo isset($item['sum'])?$item['sum']:"";?></b></td>
							</tr>
							<?php }?>
							<!-- 商品展示 结束-->
						</tbody>
					</table>
				</div>
				<!--购买清单 结束-->

			</div>
		</div>

		<!--金额结算-->
		<div class="cart_box">
			<div class="cont_2">
				<strong>结算信息</strong>
				<div class="pink_box">
					<p class="f14 t_l"><?php if($this->final_sum != $this->sum){?>优惠后总金额<?php }else{?>商品总金额<?php }?>：<b><?php echo $this->final_sum;?></b> - 代金券：<b name='ticket_value'>0</b> + 税金：<b id='tax_fee'>0</b> + 运费总计：<b id='delivery_fee_show'>0</b> + 保价：<b id='protect_price_value'>0</b> + 支付手续费：<b id='payment_value'>0</b></p>

					<a class="fold" href='javascript:orderFormInstance.ticketShow();'>
						<b class="orange">使用代金券</b>
					</a>
				</div>

				<hr class="dashed" />
				<div class="pink_box gray m_10">
					<table width="100%" class="form_table t_l">
						<colgroup>
							<col width="220px" />
							<col />
							<col width="250px" />
						</colgroup>

						<tr>
							<td>是否需要发票？(税金:￥<?php echo $this->goodsTax;?>) <input class="radio" onclick="orderFormInstance.doAccount();$('#tax_title').toggle();" name="taxes" type="checkbox" value="<?php echo $this->goodsTax;?>" /></td>
							<td><label id="tax_title" class='attr' style='display:none'>发票抬头：<input type='text' class='normal' name='tax_title' /></label></td>
							<td class="t_r"><b class="price f14">应付总额：<span class="red2">￥<b id='final_sum'><?php echo $this->final_sum;?></b></span>元</b></td>
						</tr>
					</table>
				</div>
				<p class="m_10 t_r"><input type="submit" class="submit_order" /></p>
			</div>
		</div>
	</form>
</div>
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
<script type='text/javascript' src='<?php echo $this->getWebViewPath()."javascript/orderFormClass.js";?>'></script>
<script type='text/javascript'>
//创建订单表单实例
orderFormInstance = new orderFormClass();

//DOM加载完毕
jQuery(function(){
	//商家信息
	orderFormInstance.seller = <?php echo JSON::encode($this->seller);?>;

	//商品价格
	orderFormInstance.goodsSum = "<?php echo $this->final_sum;?>";

	//配送方式初始化
	orderFormInstance.deliveryInit("<?php echo isset($this->custom['delivery'])?$this->custom['delivery']:"";?>");

	//收货地址数据
	orderFormInstance.addressInit();

	//支付方式
	orderFormInstance.paymentInit("<?php echo isset($this->custom['payment'])?$this->custom['payment']:"";?>");

	//免运费
	orderFormInstance.freeFreight = <?php echo JSON::encode($this->freeFreight);?>;
});
</script>

<div class="wrapper clearfix">
	<div class="position mt_10"><span>您当前的位置：</span> <a href="<?php echo IUrl::creatUrl("");?>"> 首页</a> » 填写核对订单信息</div>
	<div class="myshopping m_10">
		<ul class="order_step">
			<li class="current_prev"><span class="first"><a href='<?php if(IReq::get('id')){?>javascript:window.history.go(-1);<?php }else{?><?php echo IUrl::creatUrl("/simple/cart");?><?php }?>'>1、查看购物车</a></span></li>
			<li class="current"><span>2、填写核对订单信息</span></li>
			<li class="last"><span>3、成功提交订单</span></li>
		</ul>
	</div>

	<form action='<?php echo IUrl::creatUrl("/simple/cart3n");?>' method='post' name='order_form' onsubmit='return orderFormInstance.isSubmit()'>

		<input type='hidden' name='direct_gid' value='<?php echo $this->gid;?>' />
		<input type='hidden' name='direct_type' value='<?php echo $this->type;?>' />
		<input type='hidden' name='direct_num' value='<?php echo $this->num;?>' />
		<input type='hidden' name='direct_promo' value='<?php echo $this->promo;?>' />
		<input type='hidden' name='direct_active_id' value='<?php echo $this->active_id;?>' />

		<div class="cart_box m_10">
			<div class="title">填写核对订单信息</div>
			<div class="cont">

				<!--地址管理 开始-->
				<div class="wrap_box">
					<h3>
						<span class="orange">收货人信息</span>
					</h3>

					<div class="prompt_4 m_10">
						<strong>常用收货地址</strong>
						<ul class="addr_list">
							<?php foreach($this->addressList as $key => $item){?>
							<li id="addressItem<?php echo isset($item['id'])?$item['id']:"";?>">
								<label><input class="radio" name="radio_address" type="radio" value="<?php echo isset($item['id'])?$item['id']:"";?>" onclick="orderFormInstance.getDelivery(<?php echo isset($item['province'])?$item['province']:"";?>);" /><?php echo isset($item['accept_name'])?$item['accept_name']:"";?>&nbsp;&nbsp;&nbsp;<?php echo isset($item['province_val'])?$item['province_val']:"";?> <?php echo isset($item['city_val'])?$item['city_val']:"";?> <?php echo isset($item['area_val'])?$item['area_val']:"";?> <?php echo isset($item['address'])?$item['address']:"";?></label> [<a href="javascript:orderFormInstance.addressEdit(<?php echo isset($item['id'])?$item['id']:"";?>);" style="color:#005ea7;">修改地址</a>] [<a href="javascript:orderFormInstance.addressDel(<?php echo isset($item['id'])?$item['id']:"";?>);" style="color:#005ea7">删除</a>]
							</li>
							<?php }?>
							<li>
								<label><a href="javascript:orderFormInstance.addressAdd();" style="color:#005ea7;">添加新地址</a></label>
							</li>
						</ul>

						<!--收货地址项模板-->
						<script type='text/html' id='addressLiTemplate'>
						<li id="addressItem<%=item['id']%>">
							<label><input class="radio" name="radio_address" type="radio" value="<%=item['id']%>" onclick="orderFormInstance.getDelivery(<%=item['province']%>);" /><%=item['accept_name']%>&nbsp;&nbsp;&nbsp;<%=item['province_val']%> <%=item['city_val']%> <%=item['area_val']%> <%=item['address']%></label> [<a href="javascript:orderFormInstance.addressEdit(<%=item['id']%>);" style="color:#005ea7;">修改地址</a>] [<a href="javascript:orderFormInstance.addressDel(<%=item['id']%>);" style="color:#005ea7">删除</a>]
						</li>
						</script>
					</div>
				</div>
				<!--地址管理 结束-->

				<!--配送方式 开始-->
				<div class="wrap_box">
					<h3>
						<span class="orange">配送方式</span>
					</h3>

					<table width="100%" class="border_table m_10">
						<colgroup>
							<col width="180px" />
							<col />
						</colgroup>

						<tbody>
							<?php foreach(Api::run('getDeliveryList') as $key => $item){?>
							<tr>
								<th><label><input type="radio" name="delivery_id" value="<?php echo isset($item['id'])?$item['id']:"";?>" paytype="<?php echo isset($item['type'])?$item['type']:"";?>" onclick='orderFormInstance.deliverySelected(<?php echo isset($item['id'])?$item['id']:"";?>);' /><?php echo isset($item['name'])?$item['name']:"";?></label></th>
								<td>
									<span id="deliveryShow<?php echo isset($item['id'])?$item['id']:"";?>"></span>
									<?php echo isset($item['description'])?$item['description']:"";?>
									<?php if($item['type'] == 2){?>
									<a href="javascript:orderFormInstance.selectTakeself(<?php echo isset($item['id'])?$item['id']:"";?>);"><span class="red">选择自提点</span></a>
									<span id="takeself<?php echo isset($item['id'])?$item['id']:"";?>"></span>
									<?php }?>
								</td>
							</tr>
							<?php }?>
						</tbody>

						<!--配送信息-->
						<script type='text/html' id='deliveryTemplate'>
							<span style="color:#e4393c">运费：￥<%=item['price']%></span>
							<%if(item['protect_price'] > 0){%>
							<span style="color:#e4393c">保价：￥<%=item['protect_price']%></span>
							<%}%>
						</script>

						<!--物流自提点-->
						<script type='text/html' id='takeselfTemplate'>
							[<%=item['address']%> <%=item['name']%> <%=item['phone']%> <%=item['mobile']%>]
						</script>

						<tfoot>
							<th>指定送货时间：</th>
							<td>
								<label class='attr'><input type='radio' name='accept_time' checked="checked" value='任意' />任意</label>
								<label class='attr'><input type='radio' name='accept_time' value='周一到周五' />周一到周五</label>
								<label class='attr'><input type='radio' name='accept_time' value='周末' />周末</label>
							</td>
						</tfoot>
					</table>
				</div>
				<!--配送方式 结束-->

				<!--支付方式 开始-->
				<div class="wrap_box" id="paymentBox">
					<h3>
						<span class="orange">支付方式</span>
					</h3>

					<table width="100%" class="border_table">
						<colgroup>
							<col width="200px" />
							<col />
						</colgroup>
						<?php foreach(Api::run('getPaymentList') as $key => $item){?>
						<?php $paymentPrice = CountSum::getGoodsPaymentPrice($item['id'],$this->sum);?>
						<tr>
							<th><label><input class="radio" name="payment" alt="<?php echo isset($paymentPrice)?$paymentPrice:"";?>" onclick='orderFormInstance.paymentSelected(<?php echo isset($item['id'])?$item['id']:"";?>);' title="<?php echo isset($item['name'])?$item['name']:"";?>" type="radio" value="<?php echo isset($item['id'])?$item['id']:"";?>" /><?php echo isset($item['name'])?$item['name']:"";?></label></th>
							<td><?php echo isset($item['note'])?$item['note']:"";?> <?php if($paymentPrice){?>支付手续费：￥<?php echo isset($paymentPrice)?$paymentPrice:"";?><?php }?></td>
						</tr>
						<?php }?>
					</table>
				</div>
				<!--支付方式 结束-->

				<!--订单留言 开始-->
				<div class="wrap_box">
					<h3>
						<span class="orange">订单附言</span>
					</h3>

					<table width="100%" class="form_table">
						<colgroup>
							<col width="120px" />
							<col />
						</colgroup>
						<tr>
							<th>订单附言：</th>
							<td><input class="normal" type="text" name='message' /></td>
						</tr>
					</table>
				</div>
				<!--订单留言 结束-->

				<!--购买清单 开始-->
				<div class="wrap_box">

					<h3><span class="orange">购买的商品</span></h3>

					<div class="cart_prompt f14 t_l m_10" <?php if(empty($this->promotion)){?>style="display:none"<?php }?>>
						<p class="m_10 gray"><b class="orange">恭喜，</b>您的订单已经满足了以下优惠活动！</p>
						<?php foreach($this->promotion as $key => $item){?>
						<p class="indent blue"><?php echo isset($item['plan'])?$item['plan']:"";?>，<?php echo isset($item['info'])?$item['info']:"";?></p>
						<?php }?>
					</div>

					<table width="100%" class="cart_table t_c">
						<colgroup>
							<col width="115px" />
							<col />
							<col width="80px" />
							<col width="80px" />
							<col width="80px" />
							<col width="80px" />
							<col width="80px" />
						</colgroup>

						<thead>
							<tr>
								<th>图片</th>
								<th>商品名称</th>
								<th>赠送积分</th>
								<th>单价</th>
								<th>优惠</th>
								<th>代金券</th>
								<th>数量</th>
								<th class="last">小计</th>
							</tr>
						</thead>

						<tbody>
							<!-- 商品展示 开始-->
							<?php foreach($this->goodsList as $key => $item){?>
							<tr>
								<td><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/66/h/66");?>" width="66px" height="66px" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></td>
								<td class="t_l">
									<a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['goods_id']."");?>" class="blue"><?php echo isset($item['name'])?$item['name']:"";?></a>
									<?php if(isset($item['spec_array'])){?>
									<p>
									<?php $spec_array=Block::show_spec($item['spec_array']);?>
									<?php foreach($spec_array as $specName => $specValue){?>
										<?php echo isset($specName)?$specName:"";?>：<?php echo isset($specValue)?$specValue:"";?> &nbsp&nbsp
									<?php }?>
									</p>
									<?php }?>
								</td>
								<td><?php echo isset($item['point'])?$item['point']:"";?></td>
								<td><b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b></td>
								<td>减￥<?php echo isset($item['reduce'])?$item['reduce']:"";?></td>
								<td><?php if($item['prop_info']['value'] > 0){?><input type="checkbox" name="use_chit_list[]" value="1" />使用<?php echo isset($item['prop_info']['value'])?$item['prop_info']['value']:"";?>元<?php }else{?>0<?php }?></td>
								<td><?php echo isset($item['count'])?$item['count']:"";?></td>
								<td id="deliveryFeeBox_<?php echo isset($item['goods_id'])?$item['goods_id']:"";?>_<?php echo isset($item['product_id'])?$item['product_id']:"";?>_<?php echo isset($item['count'])?$item['count']:"";?>"><b class="red2">￥<?php echo isset($item['sum'])?$item['sum']:"";?></b></td>
							</tr>
							<?php }?>
							<!-- 商品展示 结束-->
						</tbody>
					</table>
				</div>
				<!--购买清单 结束-->

			</div>
		</div>

		<!--金额结算-->
		<div class="cart_box">
			<div class="cont_2">
				<strong>结算信息</strong>
				<div class="pink_box">
					<p class="f14 t_l"><?php if($this->final_sum != $this->sum){?>优惠后总金额<?php }else{?>商品总金额<?php }?>：<b><?php echo $this->final_sum;?></b> - 代金券：<b name='ticket_value'>0</b> + 税金：<b id='tax_fee'>0</b> + 运费总计：<b id='delivery_fee_show'>0</b> + 保价：<b id='protect_price_value'>0</b> + 支付手续费：<b id='payment_value'>0</b></p>

					<a class="fold" href='javascript:orderFormInstance.ticketShow();'>
						<b class="orange">使用代金券</b>
					</a>
				</div>

				<hr class="dashed" />
				<div class="pink_box gray m_10">
					<table width="100%" class="form_table t_l">
						<colgroup>
							<col width="220px" />
							<col />
							<col width="250px" />
						</colgroup>

						<tr>
							<td>是否需要发票？(税金:￥<?php echo $this->goodsTax;?>) <input class="radio" onclick="orderFormInstance.doAccount();$('#tax_title').toggle();" name="taxes" type="checkbox" value="<?php echo $this->goodsTax;?>" /></td>
							<td><label id="tax_title" class='attr' style='display:none'>发票抬头：<input type='text' class='normal' name='tax_title' /></label></td>
							<td class="t_r"><b class="price f14">应付总额：<span class="red2">￥<b id='final_sum'><?php echo $this->final_sum;?></b></span>元</b></td>
						</tr>
					</table>
				</div>
				<p class="m_10 t_r"><input type="submit" class="submit_order" /></p>
			</div>
		</div>
	</form>
</div>
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


