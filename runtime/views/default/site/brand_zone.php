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
		<?php
$site_config=new Config('site_config');
$dcommission = $site_config->dcommission;
$breadGuide = goods_class::catRecursion($category);
$brandId  = IFilter::act(IReq::get('id'),'int');
$brandRow = Api::run('getBrandInfo',$brandId);

if(!$brandRow)
{
	IError::show(403,'品牌信息不存在');
}
?>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquerySlider/jquery.bxslider.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/jquerySlider/jquery.bxslider.css" />
<script language="javascript">
	var _goods_list = <?php echo isset($seller_info['goods_list_json'])?$seller_info['goods_list_json']:"";?>;
	var _goods_id = 0;
	
	var _spec_id = 0;
	var SITE_URL = 'http://<?php echo get_host();?>';
	var _seller_id = <?php echo isset($seller_info['id'])?$seller_info['id']:"";?>;
	var _hide_price = <?php echo $this->hide_price;?>;
	var _hide_price_str = '<?php echo $this->hide_price_str;?>';
</script>
<style> .submit_buy{background:#f8f8f8;font-size:16px;color:#038bd0;border:1px solid #038bd0;border-radius:5px;text-indent: 0;line-height: 0;} .submit_join{background:#f8f8f8;font-size:16px;color:#038bd0;border:1px solid #038bd0;border-radius:5px;text-indent: 0;line-height: 0;}
.submit_buy:hover{background:#fff;color:#f90;border:1px solid #f90;}
.submit_join:hover{background:#fff;color:#f90;border:1px solid #f90;}
.add:hover{
 color:red;
}
.reduce:hover{
 color:red;
}
</style>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/home.js";?>"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QDA0aO9Dw8tVx22vuULQuGXOGFV5a5ZD"></script>
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/layer/layer.js";?>"></script>
<link href="<?php echo $this->getWebSkinPath()."/css/home.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebSkinPath()."/css/brand_zone.css";?>" rel="stylesheet" type="text/css" />
<div class="position"><span>您当前的位置：</span><a href="<?php echo IUrl::creatUrl("");?>">首页</a> » <a href="<?php echo IUrl::creatUrl("/site/brand");?>">培训机构</a> » <?php echo isset($seller_info['shortname'])?$seller_info['shortname']:"";?></div>
<div class="wrapper clearfix" >    
	<div class="main f_r" >		
		<?php $goodsObj = search_goods::find(array('brand_id' => $brandId));$resultData = $goodsObj->find();?>
		<!--商品条件筛选-->		 
		<?php if($resultData){?>
	
 
   <!--图片放大镜-->
   
	<div class="preview">
		<div class="pic_show">
			<img id="picShow" rel="" class="lazy" data-original="<?php echo IUrl::creatUrl("".$resultData['0'][img]."");?>" />
		</div>
		<ul id="goodsPhotoList" class="pic_thumb">
			<?php foreach($resultData as $key => $item){?>
				<li >
					<a href="javascript:void(0);" thumbimg="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."");?>" sourceimg="<?php echo IUrl::creatUrl("")."".$item['img']."";?>">
						<img class="lazy" data-original='<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."");?>' width="60px" height="60px" />
					</a>
				</li>
			<?php }?>
		</ul>
	</div>
	<!-- end -->
	<!--右侧信息栏 -->
	<div class="clearfix"></div>
	 <div class="summary">
	  
		<h2><?php echo isset($seller_info['shortname'])?$seller_info['shortname']:"";?></h2>
		<!--基本信息区域-->
		<div class="lesson_price">
            <div class="price">
                <p class="dis_price">参考价：<strong id="data_marketPrice">￥<?php echo isset($seller_info['price_level'])?$seller_info['price_level']:"";?></strong></p>
            </div>
            <div class="attach comment">
                <p><?php echo isset($seller_info['comments'])?$seller_info['comments']:"";?></p>
                <p>累计评价</p>
            </div>
            <div class="attach">
                <p><?php echo isset($seller_info['sale'])?$seller_info['sale']:"";?></p>
                <p>交易成功</p>
            </div>
        </div>

		<!--购买区域-->
		<div class="current">
			<?php if($seller_info['is_authentication'] == 1){?>
				<dl class="m_10 clearfix" name="specCols">
					<dt>课程分类：</dt>
					<dd class="w_45">
						<?php foreach($seller_info['goods_list'] as $key => $item){?>
						<div class="item w_27">
							<a href="javascript:void(0);" onclick="sele_goods(this);" _id=<?php echo isset($item['id'])?$item['id']:"";?>>
								<?php echo isset($item['name'])?$item['name']:"";?>
							</a>
						</div>
						<?php }?>
					</dd>
				</dl>
				<dl class="m10 clearfix spec_list_row">
					<dt>价格属性：</dt>
					<dd class="w_45 spec_list">

					</dd>
				</dl>
				<dl class="m_10 clearfix">
					<dt>报名人数：</dt>
					<dd>

						<div class="resize">
							<a class="add"   id="buyAddButton" onclick="setAmount.reduce('#buyNums')" href="javascript:void(0);">-</a>
							<input class="gray_t f_l" type="text" id="buyNums" onkeyup="setAmount.modify('#buyNums')" value="1" maxlength="5"  />
							<a class="reduce"  id="buyReduceButton" onclick="setAmount.add('#buyNums')" href="javascript:void(0);">+</a>
						</div>
					</dd>
				</dl>
				<input class="submit_buy" type="button" id="buyNowButton" onclick="buy_now();" value="立即报名" />
				<div class="shop_cart">
					<input class="submit_join" type="button" id="joinCarButton" onclick="joinCart();" value="加入课表" />
				</div>
			<?php }else{?>
			<dl class="m_10 clearfix">
				学校未认证
			</dl>
			<?php }?>
		</div>
	  </div> 
	
	<!--end-->       						
		<div name="showBox">
			<!-- 商品详情 start -->
			<div class="product_info">
				<a name="location"></a>
				<div class="module">
					<div class="module_hd"></div>
					<div class="module_bd">
						<?php if($seller_info['address']){?>
							<div class="shop_map">
								<div id="container"></div>
							</div>
						<?php }?>
						<div class="shop_info">
							<div class="shop_name"><?php echo isset($seller_info['shortname'])?$seller_info['shortname']:"";?></div>
							<div class="shop_info_list">
								<ul>
									<li>地址：<?php echo join(' ',area::name($seller_info['province'],$seller_info['city'],$seller_info['area']));?> <?php echo isset($seller_info['address'])?$seller_info['address']:"";?></li>
									<li class="shopinfo">客服：<a><img class="lazy" data-original="<?php echo IUrl::creatUrl("/upload/pic/tel.jpg");?>"/></a>
								<a href="tencent://message/?Menu=yes&amp;uin=2821518520&amp;Service=58&amp;SigT=A7F6FEA02730C9881B11E0AE7AF2E2413E3090997F5951E7CFC7F66A8EF4F5D7A3233F568A8EBC2B984019AC21FF99093F241FB5CD7A7DD4C39596B28D63C849FBCF4A5AED55184EFE696F36F9FF6428EEC729D42EF963C0FD5E9BAC2AD18620E7ADFC9387D83C4B46A7B0C2DC4B63341934EE44C822C196"><img class="lazy" data-original="<?php echo IUrl::creatUrl("/upload/pic/qq.jpg");?>"/></a></li>
								     <?php if($attrArr){?>
									<li class="times_list">上课时间：<br />
										<?php foreach($attrArr as $key => $item){?>
										<div><?php echo isset($item)?$item:"";?></div>
										<?php }?>

									</li>
									<?php }?>
									
								</ul>
							</div>
						</div>
					</div>
				</div>

				<a name="class_desc" ></a>
				<div class="module">
					<div class="module_hd module_hd2"></div>
					<div class="module_bd module_bd2">
						<?php if($seller_info['brand_info']['class_desc_img']){?>
						<div class="class_desc_img">
							
								<img class="lazy" data-original="<?php echo IUrl::creatUrl("")."".$seller_info['brand_info']['class_desc_img']['0']."";?>" />
						
						</div>
						<?php }?>
						<div class="class_list">
							<div class="class_list_hd">
								<img class="lazy" data-original="<?php echo $this->getWebSkinPath()."images/class_list_top_bg.png";?>" />
							</div>
							<div class="class_list_bd">
								<table cellspacing="0">
									<tr>
										<th width="20%">课程</th>
										<th>简介</th>
									</tr>
									  <?php foreach($seller_info['goods_list'] as $key => $item){?>
									<tr>
										<td><?php echo isset($item['name'])?$item['name']:"";?></td>
										<td><?php echo isset($item['goods_brief'])?$item['goods_brief']:"";?></td>
									</tr>
									<?php }?>
								</table>
							</div>
						</div>
				<?php if($seller_info['brand_info']['shop_desc_img'][0]){?>
		        <div class="shop_desc">
		            <img class="lazy" data-original="<?php echo IUrl::creatUrl("")."".$seller_info['brand_info']['shop_desc_img'][0]."";?>" />
		        </div>
		    
			
               <?php }elseif($seller_info['brand_info']['shop_desc_img'][1]){?>
		        <div class="shop_desc">
		            <img class="lazy" data-original="<?php echo IUrl::creatUrl("")."".$seller_info['brand_info']['shop_desc_img'][1]."";?>" />
		        </div>
				<?php }elseif($seller_info['content']){?>
				   <div class="content">
				     <?php echo isset($seller_info['content'])?$seller_info['content']:"";?>
				   </div>
				
                  <?php }?>
						<div class="class_list_desc">
							<div class="class_list_desc_hd">
								<img class="lazy" data-original="<?php echo $this->getWebSkinPath()."images/class_list_desc.jpg";?>" />
							</div>
							<?php if($seller_info['goods_list']){?>
								<?php $index = 1?>
								<?php foreach($seller_info['goods_list'] as $key => $item){?>
								
									<div class="class_list_desc_bd class_list_style_<?php echo isset($index)?$index:"";?>">
										<div class="class_title">
											<div class="title_name"><?php echo isset($item['name'])?$item['name']:"";?></div>
											<div><?php echo isset($item['class_target'])?$item['class_target']:"";?></div>
										</div>
										<div class="clear"></div>
										
										<?php if($item['content']){?>
										<div class="class_description" >
										<?php $item['content']=str_replace(
										'\r','<br />', $item['content']);?>
									  	<?php echo str_replace(
										'\n','<br />', $item['content']);?>
											
										</div>
                                       <?php }else{?>
                                        <br />
										<?php }?>

										<?php if($item['class_details']){?>
										<div class="class_description_list">
											<ul>
												<?php foreach($item['class_details'] as $key => $it){?>
												<li><div class="desc_str"><?php echo isset($it)?$it:"";?></div></li>
												<?php }?>
											</ul>
										</div>
										<?php }?>
									</div>
									<?php if($index == 9){?>
										<?php $index = 1?>
									<?php }else{?>
										<?php $index++?>
									<?php }?>
								<?php }?>
							<?php }?>
						</div>
					</div>
				</div>

				<a name="teacher_desc"></a>
				<?php if($seller_info['teacher_list']){?>
				<div class="module">
					<div class="module_hd module_hd3"></div>
					<div class="module_bd">
						<div class="teacher_list">
							<ul>
								<?php foreach($seller_info['teacher_list'] as $key => $item){?>
								<li>
									<div class="teacher_logo">
										<img class="lazy" data-original="<?php echo IUrl::creatUrl("")."".$item['icon']."";?>" onerror="javascript:this.src='../skin/default/images/avatar.jpg';"/>
									</div>
									<div class="teacher_desc">
										<div><?php echo isset($item['name'])?$item['name']:"";?></div>
										<p>
										<?php $item['description']=str_replace(
										'\r','<br />', $item['description']);?>
									  	<?php echo str_replace(
										'\n','<br />', $item['description']);?>
										</p>
									</div>
								</li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>
				<?php }?>

				<a name="shop_desc"></a>
				<?php if($seller_info['album']){?>
				<div class="module">
					<div class="module_hd module_hd4"></div>
					<div class="module_bd">
						<div class="shop_image_list">
							<ul>
								<?php foreach($seller_info['album'] as $key => $item){?>
									<li><img src="<?php echo IUrl::creatUrl("")."".$item."";?>" /></li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>
				<?php }?>

			</div>
			<!-- 商品详情 end -->
		</div>
<!-- 			<div class="product_right">
		
			<div class="product_r">
			<ul>
			<li>
			<a class="name"><img src="/upload/pic/xue.png"/></a>
			<span>课程名称</span>
			<a class="pic" href=""><img src="/upload/pic/shiting.jpg"/></a>
			<div class="font"><a>课程的一句话简介了解艺术的多元化与丰富性，学习不同门,强化学员对线、形、色的好奇，。</a>
			<p>试听课学校简称</p>
			</div>
			</li>
			</ul>
			<ul>
			<li>
			<a class="name"><img src="/upload/pic/xue.png"/></a>
			<span>精品试听课</span>
			<a class="pic" href=""><img src="/upload/pic/jiqi.jpg"/></a>
			<div class="font"><a>课程的一句话简介，第一行艺术拓展学习旨在拓展学生艺术视野，了解艺术的多元化与丰富性，学习不同门,强化学员对线、形、色的好奇，。</a>
			<p>试听课学校简称</p>
			</div>
			</li>
			</ul>
			</div>

			</div> -->
</div>
			<!-- 商品详情 end -->
		</div>
		
		
	
		<?php }?>
	

<script type='text/html' id='spec_list_template'>
	<div class="item w_28">
		<a href="javascript:void(0);" onclick="sele_spec(this)" _spec="<%=id%>">
			<%if(cusval != ''){%><%=cusval%><%}%> <%if(classnum){%><%=classnum%>课时<%}%> <%if(month){%><%=month%>个月<%}%>
		</a>
	</div>
</script>

<?php if($seller_info['address']){?>
<script type="text/javascript">
var _shop_address = "<?php echo join('',area::name($seller_info['province'],$seller_info['city'],$seller_info['area']));?><?php echo isset($seller_info['address'])?$seller_info['address']:"";?>";
</script>
<script src="http://webapi.amap.com/maps?v=1.3&key=2cd83299402829a3177894489a4cf556" type="text/javascript"></script>
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."/javascript/school_show_map.js";?>"></script>
<?php }?>


	

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
				<?php
$site_config=new Config('site_config');
$dcommission = $site_config->dcommission;
$breadGuide = goods_class::catRecursion($category);
$brandId  = IFilter::act(IReq::get('id'),'int');
$brandRow = Api::run('getBrandInfo',$brandId);

if(!$brandRow)
{
	IError::show(403,'品牌信息不存在');
}
?>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquerySlider/jquery.bxslider.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/jquerySlider/jquery.bxslider.css" />
<script language="javascript">
	var _goods_list = <?php echo isset($seller_info['goods_list_json'])?$seller_info['goods_list_json']:"";?>;
	var _goods_id = 0;
	
	var _spec_id = 0;
	var SITE_URL = 'http://<?php echo get_host();?>';
	var _seller_id = <?php echo isset($seller_info['id'])?$seller_info['id']:"";?>;
	var _hide_price = <?php echo $this->hide_price;?>;
	var _hide_price_str = '<?php echo $this->hide_price_str;?>';
</script>
<style> .submit_buy{background:#f8f8f8;font-size:16px;color:#038bd0;border:1px solid #038bd0;border-radius:5px;text-indent: 0;line-height: 0;} .submit_join{background:#f8f8f8;font-size:16px;color:#038bd0;border:1px solid #038bd0;border-radius:5px;text-indent: 0;line-height: 0;}
.submit_buy:hover{background:#fff;color:#f90;border:1px solid #f90;}
.submit_join:hover{background:#fff;color:#f90;border:1px solid #f90;}
.add:hover{
 color:red;
}
.reduce:hover{
 color:red;
}
</style>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/home.js";?>"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QDA0aO9Dw8tVx22vuULQuGXOGFV5a5ZD"></script>
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/layer/layer.js";?>"></script>
<link href="<?php echo $this->getWebSkinPath()."/css/home.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebSkinPath()."/css/brand_zone.css";?>" rel="stylesheet" type="text/css" />
<div class="position"><span>您当前的位置：</span><a href="<?php echo IUrl::creatUrl("");?>">首页</a> » <a href="<?php echo IUrl::creatUrl("/site/brand");?>">培训机构</a> » <?php echo isset($seller_info['shortname'])?$seller_info['shortname']:"";?></div>
<div class="wrapper clearfix" >    
	<div class="main f_r" >		
		<?php $goodsObj = search_goods::find(array('brand_id' => $brandId));$resultData = $goodsObj->find();?>
		<!--商品条件筛选-->		 
		<?php if($resultData){?>
	
 
   <!--图片放大镜-->
   
	<div class="preview">
		<div class="pic_show">
			<img id="picShow" rel="" class="lazy" data-original="<?php echo IUrl::creatUrl("".$resultData['0'][img]."");?>" />
		</div>
		<ul id="goodsPhotoList" class="pic_thumb">
			<?php foreach($resultData as $key => $item){?>
				<li >
					<a href="javascript:void(0);" thumbimg="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."");?>" sourceimg="<?php echo IUrl::creatUrl("")."".$item['img']."";?>">
						<img class="lazy" data-original='<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."");?>' width="60px" height="60px" />
					</a>
				</li>
			<?php }?>
		</ul>
	</div>
	<!-- end -->
	<!--右侧信息栏 -->
	<div class="clearfix"></div>
	 <div class="summary">
	  
		<h2><?php echo isset($seller_info['shortname'])?$seller_info['shortname']:"";?></h2>
		<!--基本信息区域-->
		<div class="lesson_price">
            <div class="price">
                <p class="dis_price">参考价：<strong id="data_marketPrice">￥<?php echo isset($seller_info['price_level'])?$seller_info['price_level']:"";?></strong></p>
            </div>
            <div class="attach comment">
                <p><?php echo isset($seller_info['comments'])?$seller_info['comments']:"";?></p>
                <p>累计评价</p>
            </div>
            <div class="attach">
                <p><?php echo isset($seller_info['sale'])?$seller_info['sale']:"";?></p>
                <p>交易成功</p>
            </div>
        </div>

		<!--购买区域-->
		<div class="current">
			<?php if($seller_info['is_authentication'] == 1){?>
				<dl class="m_10 clearfix" name="specCols">
					<dt>课程分类：</dt>
					<dd class="w_45">
						<?php foreach($seller_info['goods_list'] as $key => $item){?>
						<div class="item w_27">
							<a href="javascript:void(0);" onclick="sele_goods(this);" _id=<?php echo isset($item['id'])?$item['id']:"";?>>
								<?php echo isset($item['name'])?$item['name']:"";?>
							</a>
						</div>
						<?php }?>
					</dd>
				</dl>
				<dl class="m10 clearfix spec_list_row">
					<dt>价格属性：</dt>
					<dd class="w_45 spec_list">

					</dd>
				</dl>
				<dl class="m_10 clearfix">
					<dt>报名人数：</dt>
					<dd>

						<div class="resize">
							<a class="add"   id="buyAddButton" onclick="setAmount.reduce('#buyNums')" href="javascript:void(0);">-</a>
							<input class="gray_t f_l" type="text" id="buyNums" onkeyup="setAmount.modify('#buyNums')" value="1" maxlength="5"  />
							<a class="reduce"  id="buyReduceButton" onclick="setAmount.add('#buyNums')" href="javascript:void(0);">+</a>
						</div>
					</dd>
				</dl>
				<input class="submit_buy" type="button" id="buyNowButton" onclick="buy_now();" value="立即报名" />
				<div class="shop_cart">
					<input class="submit_join" type="button" id="joinCarButton" onclick="joinCart();" value="加入课表" />
				</div>
			<?php }else{?>
			<dl class="m_10 clearfix">
				学校未认证
			</dl>
			<?php }?>
		</div>
	  </div> 
	
	<!--end-->       						
		<div name="showBox">
			<!-- 商品详情 start -->
			<div class="product_info">
				<a name="location"></a>
				<div class="module">
					<div class="module_hd"></div>
					<div class="module_bd">
						<?php if($seller_info['address']){?>
							<div class="shop_map">
								<div id="container"></div>
							</div>
						<?php }?>
						<div class="shop_info">
							<div class="shop_name"><?php echo isset($seller_info['shortname'])?$seller_info['shortname']:"";?></div>
							<div class="shop_info_list">
								<ul>
									<li>地址：<?php echo join(' ',area::name($seller_info['province'],$seller_info['city'],$seller_info['area']));?> <?php echo isset($seller_info['address'])?$seller_info['address']:"";?></li>
									<li class="shopinfo">客服：<a><img class="lazy" data-original="<?php echo IUrl::creatUrl("/upload/pic/tel.jpg");?>"/></a>
								<a href="tencent://message/?Menu=yes&amp;uin=2821518520&amp;Service=58&amp;SigT=A7F6FEA02730C9881B11E0AE7AF2E2413E3090997F5951E7CFC7F66A8EF4F5D7A3233F568A8EBC2B984019AC21FF99093F241FB5CD7A7DD4C39596B28D63C849FBCF4A5AED55184EFE696F36F9FF6428EEC729D42EF963C0FD5E9BAC2AD18620E7ADFC9387D83C4B46A7B0C2DC4B63341934EE44C822C196"><img class="lazy" data-original="<?php echo IUrl::creatUrl("/upload/pic/qq.jpg");?>"/></a></li>
								     <?php if($attrArr){?>
									<li class="times_list">上课时间：<br />
										<?php foreach($attrArr as $key => $item){?>
										<div><?php echo isset($item)?$item:"";?></div>
										<?php }?>

									</li>
									<?php }?>
									
								</ul>
							</div>
						</div>
					</div>
				</div>

				<a name="class_desc" ></a>
				<div class="module">
					<div class="module_hd module_hd2"></div>
					<div class="module_bd module_bd2">
						<?php if($seller_info['brand_info']['class_desc_img']){?>
						<div class="class_desc_img">
							
								<img class="lazy" data-original="<?php echo IUrl::creatUrl("")."".$seller_info['brand_info']['class_desc_img']['0']."";?>" />
						
						</div>
						<?php }?>
						<div class="class_list">
							<div class="class_list_hd">
								<img class="lazy" data-original="<?php echo $this->getWebSkinPath()."images/class_list_top_bg.png";?>" />
							</div>
							<div class="class_list_bd">
								<table cellspacing="0">
									<tr>
										<th width="20%">课程</th>
										<th>简介</th>
									</tr>
									  <?php foreach($seller_info['goods_list'] as $key => $item){?>
									<tr>
										<td><?php echo isset($item['name'])?$item['name']:"";?></td>
										<td><?php echo isset($item['goods_brief'])?$item['goods_brief']:"";?></td>
									</tr>
									<?php }?>
								</table>
							</div>
						</div>
				<?php if($seller_info['brand_info']['shop_desc_img'][0]){?>
		        <div class="shop_desc">
		            <img class="lazy" data-original="<?php echo IUrl::creatUrl("")."".$seller_info['brand_info']['shop_desc_img'][0]."";?>" />
		        </div>
		    
			
               <?php }elseif($seller_info['brand_info']['shop_desc_img'][1]){?>
		        <div class="shop_desc">
		            <img class="lazy" data-original="<?php echo IUrl::creatUrl("")."".$seller_info['brand_info']['shop_desc_img'][1]."";?>" />
		        </div>
				<?php }elseif($seller_info['content']){?>
				   <div class="content">
				     <?php echo isset($seller_info['content'])?$seller_info['content']:"";?>
				   </div>
				
                  <?php }?>
						<div class="class_list_desc">
							<div class="class_list_desc_hd">
								<img class="lazy" data-original="<?php echo $this->getWebSkinPath()."images/class_list_desc.jpg";?>" />
							</div>
							<?php if($seller_info['goods_list']){?>
								<?php $index = 1?>
								<?php foreach($seller_info['goods_list'] as $key => $item){?>
								
									<div class="class_list_desc_bd class_list_style_<?php echo isset($index)?$index:"";?>">
										<div class="class_title">
											<div class="title_name"><?php echo isset($item['name'])?$item['name']:"";?></div>
											<div><?php echo isset($item['class_target'])?$item['class_target']:"";?></div>
										</div>
										<div class="clear"></div>
										
										<?php if($item['content']){?>
										<div class="class_description" >
										<?php $item['content']=str_replace(
										'\r','<br />', $item['content']);?>
									  	<?php echo str_replace(
										'\n','<br />', $item['content']);?>
											
										</div>
                                       <?php }else{?>
                                        <br />
										<?php }?>

										<?php if($item['class_details']){?>
										<div class="class_description_list">
											<ul>
												<?php foreach($item['class_details'] as $key => $it){?>
												<li><div class="desc_str"><?php echo isset($it)?$it:"";?></div></li>
												<?php }?>
											</ul>
										</div>
										<?php }?>
									</div>
									<?php if($index == 9){?>
										<?php $index = 1?>
									<?php }else{?>
										<?php $index++?>
									<?php }?>
								<?php }?>
							<?php }?>
						</div>
					</div>
				</div>

				<a name="teacher_desc"></a>
				<?php if($seller_info['teacher_list']){?>
				<div class="module">
					<div class="module_hd module_hd3"></div>
					<div class="module_bd">
						<div class="teacher_list">
							<ul>
								<?php foreach($seller_info['teacher_list'] as $key => $item){?>
								<li>
									<div class="teacher_logo">
										<img class="lazy" data-original="<?php echo IUrl::creatUrl("")."".$item['icon']."";?>" onerror="javascript:this.src='../skin/default/images/avatar.jpg';"/>
									</div>
									<div class="teacher_desc">
										<div><?php echo isset($item['name'])?$item['name']:"";?></div>
										<p>
										<?php $item['description']=str_replace(
										'\r','<br />', $item['description']);?>
									  	<?php echo str_replace(
										'\n','<br />', $item['description']);?>
										</p>
									</div>
								</li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>
				<?php }?>

				<a name="shop_desc"></a>
				<?php if($seller_info['album']){?>
				<div class="module">
					<div class="module_hd module_hd4"></div>
					<div class="module_bd">
						<div class="shop_image_list">
							<ul>
								<?php foreach($seller_info['album'] as $key => $item){?>
									<li><img src="<?php echo IUrl::creatUrl("")."".$item."";?>" /></li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>
				<?php }?>

			</div>
			<!-- 商品详情 end -->
		</div>
<!-- 			<div class="product_right">
		
			<div class="product_r">
			<ul>
			<li>
			<a class="name"><img src="/upload/pic/xue.png"/></a>
			<span>课程名称</span>
			<a class="pic" href=""><img src="/upload/pic/shiting.jpg"/></a>
			<div class="font"><a>课程的一句话简介了解艺术的多元化与丰富性，学习不同门,强化学员对线、形、色的好奇，。</a>
			<p>试听课学校简称</p>
			</div>
			</li>
			</ul>
			<ul>
			<li>
			<a class="name"><img src="/upload/pic/xue.png"/></a>
			<span>精品试听课</span>
			<a class="pic" href=""><img src="/upload/pic/jiqi.jpg"/></a>
			<div class="font"><a>课程的一句话简介，第一行艺术拓展学习旨在拓展学生艺术视野，了解艺术的多元化与丰富性，学习不同门,强化学员对线、形、色的好奇，。</a>
			<p>试听课学校简称</p>
			</div>
			</li>
			</ul>
			</div>

			</div> -->
</div>
			<!-- 商品详情 end -->
		</div>
		
		
	
		<?php }?>
	

<script type='text/html' id='spec_list_template'>
	<div class="item w_28">
		<a href="javascript:void(0);" onclick="sele_spec(this)" _spec="<%=id%>">
			<%if(cusval != ''){%><%=cusval%><%}%> <%if(classnum){%><%=classnum%>课时<%}%> <%if(month){%><%=month%>个月<%}%>
		</a>
	</div>
</script>

<?php if($seller_info['address']){?>
<script type="text/javascript">
var _shop_address = "<?php echo join('',area::name($seller_info['province'],$seller_info['city'],$seller_info['area']));?><?php echo isset($seller_info['address'])?$seller_info['address']:"";?>";
</script>
<script src="http://webapi.amap.com/maps?v=1.3&key=2cd83299402829a3177894489a4cf556" type="text/javascript"></script>
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."/javascript/school_show_map.js";?>"></script>
<?php }?>


	

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


