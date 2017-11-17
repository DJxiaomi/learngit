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
		<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquerySlider/jquery.bxslider.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/jquerySlider/jquery.bxslider.css" />
<script language="javascript">
	//var _goods_list = <?php echo isset($goods_list_json)?$goods_list_json:"";?>;
	var _goods_id = 0;
	var _spec_id = 0;
	var SITE_URL = 'http://<?php echo get_host();?>';
	//var _seller_id = <?php echo isset($goods_list['0']['seller_id'])?$goods_list['0']['seller_id']:"";?>;
</script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jqueryZoom/jquery.imagezoom.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/jqueryZoom/imagezoom.css" />
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquerySlider/jquery.bxslider.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/jquerySlider/jquery.bxslider.css" />
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/layer/layer.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/products.js";?>"></script>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/products.css";?>">
<style>
.salebox img {max-width: 100%;}
.summary ul li .price i {font-size:14px;}
</style>

<?php $breadGuide = goods_class::catRecursion($category);?>
<div class="position"><span>您当前的位置：</span><a href="<?php echo IUrl::creatUrl("");?>">首页</a><?php foreach($breadGuide as $key => $item){?> » <a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$item['id']."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a><?php }?> » <?php echo isset($name)?$name:"";?></div>

<div class="wrapper clearfix">
	<div class="summary">
		<h2><?php echo isset($name)?$name:"";?></h2>
    <?php foreach($seller_info['goods_list'] as $key => $item){?>
			<div class="item w_27">
				<a href="javascript:void(0);" _id=<?php echo isset($item['id'])?$item['id']:"";?>>
					<?php echo isset($item['name'])?$item['name']:"";?>
				</a>
			</div>
		<?php }?>
		<!--基本信息区域-->

		<ul>
			<li>
				<span class="f_r light_gray">商品编号<?php echo isset($goods_list['seller_id'])?$goods_list['seller_id']:"";?>：<label id="data_goodsNo"><?php echo $goods_no?$goods_no:$id;?></label></span>
			</li>

			<!--抢购活动,引入 "_products_time"模板-->
			<?php if($promo == 'time' && isset($time)){?>
			<?php require(ITag::createRuntime("_products_time"));?>
			<?php }?>

			<!--团购活动,引入 "_products_groupon"模板-->
			<?php if($promo == 'groupon' && isset($groupon)){?>
			<?php require(ITag::createRuntime("_products_groupon"));?>
			<?php }?>

			<!--普通商品购买-->
			<?php if($promo == ''){?>
				<?php if($group_price){?>
				<!--当前用户有会员价-->

				<li>
					会员价：<b class="price red2">￥<span class="f30" id="data_groupPrice"></span></b>
				</li>
				<li>
					原售价：￥<s id="data_sellPrice"><?php echo isset($sell_price)?$sell_price:"";?></s>
				</li>
				<?php }else{?>
				<!--当前用户普通价格-->
				<li>
					销售价：<b class="price red2"><span class="f30" id="data_sellPrice"><?php if($sell_price != $this->hide_price){?><?php echo isset($sell_price)?$sell_price:"";?><?php }else{?><i><?php echo $this->hide_price_str;?></i><?php }?></span></b>
				</li>
				<?php }?>
			<?php }?>

			<li>
				市场价：￥<s id="data_marketPrice"><?php echo isset($market_price)?$market_price:"";?></s>
			</li>

			<li>
				库存：现货<span>(<label id="data_storeNums"><?php echo isset($store_nums)?$store_nums:"";?></label>)</span>
				<a class="favorite" onclick="favorite_add_ajax(<?php echo isset($id)?$id:"";?>,this);" href="javascript:void(0)">收藏此商品</a>
			</li>



			<?php if($point > 0){?>
			<li>送积分：单件送<?php echo isset($point)?$point:"";?>分</li>
			<?php }?>

			<!-- 商家信息 开始 -->
			<?php if(isset($seller)){?>
			<li>商家：<a class="orange" href="<?php echo IUrl::creatUrl("/site/home/id/".$seller_id."");?>"><?php echo isset($seller['true_name'])?$seller['true_name']:"";?></a></li>
			<?php if($seller['phone']){?><li>联系电话：<?php echo isset($seller['phone'])?$seller['phone']:"";?></li><?php }?>
			<li>所在地：<?php echo join(' ',area::name($seller['province'],$seller['city'],$seller['area']));?></li>
			<li><?php plugin::trigger("onServiceButton",$seller['id'])?></li>
			<?php }?>
			<!--商家信息 结束-->
		</ul>

		<!--购买区域-->
		<?php if($sell_price != $this->hide_price){?>
		<div class="current">
		<?php if($store_nums <= 0){?>
			该商品已售完，不能购买，您可以看看其它商品！(<a href="<?php echo IUrl::creatUrl("/simple/arrival/goods_id/".$id."");?>" class="orange">到货通知</a>)
		<?php }else{?>

			<!--商品规格选择 开始-->

				<?php if($goods_spec_array['value']){?>
				<dl class="m_10 clearfix" name="specCols">
					<dt>课程属性：</dt>
					<dd class="w_45">
						<?php foreach($goods_spec_array['value'] as $key => $spec_value){?>
						<div class="item w_27">
							<!-- <a href="javascript:void(0);" onclick="sele_goods(this);" _id=<?php echo isset($item['id'])?$item['id']:"";?>> -->
							<a href="javascript:void(0);" name="specColls" onclick="sele_spec(this);" id="<?php echo isset($spec_value['id'])?$spec_value['id']:"";?>" value='{"id":"<?php echo isset($spec_value['id'])?$spec_value['id']:"";?>","value":"<?php echo isset($spec_value['cusval'])?$spec_value['cusval']:"";?>","classnum":"<?php echo isset($spec_value['classnum'])?$spec_value['classnum']:"";?>","month":"<?php echo isset($spec_value['month'])?$spec_value['month']:"";?>","name":"<?php echo isset($goods_spec_array['name'])?$goods_spec_array['name']:"";?>"}'>
								<?php if($spec_value['cusval']){?>
									<?php echo isset($spec_value['cusval'])?$spec_value['cusval']:"";?><?php if($spec_value['classnum'] || $spec_value['month']){?>/<?php }?>
								<?php }?>
								<?php if($spec_value['classnum']){?>
									<?php echo isset($spec_value['classnum'])?$spec_value['classnum']:"";?>课时<?php if($spec_value['month']){?>/<?php }?>
								<?php }?>
								<?php if($spec_value['month']){?><?php echo isset($spec_value['month'])?$spec_value['month']:"";?>个月<?php }?>
							</a>
						</div>
						<?php }?>
					</dd>
				</dl>
				<?php }?>


			<!--商品规格选择 结束-->


			<div class="chit_info"></div>

			<dl class="m_10 clearfix">
					<dt>报名人数：</dt>
					<dd>

						<div class="resize">
							<a class="add" id="buyAddButton" href="javascript:void(0);">-</a>
							<input class="gray_t f_l" type="text" id="buyNums" onkeyup="setAmount.modify('#buyNums')" value="1" maxlength="5"  />
							<a class="reduce" id="buyReduceButton" href="javascript:void(0);">+</a>
						</div>
					</dd>
				</dl>

		    <input  type="button" id="buyNowButton" value="立即付款" />
				<input type="button" id="joinCarButton" value="加入课表" />

		<?php }?>
		</div>
		<?php }?>
	</div>


	<!--图片放大镜-->
	<div class="preview">
		<div class="pic_show">
			<img id="picShow" rel="" src="" />
		</div>

		<ul id="goodsPhotoList" class="pic_thumb">
			<?php foreach($photo as $key => $item){?>
			<li>
				<a href="javascript:void(0);" thumbimg="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/435/h/435");?>" sourceimg="<?php echo IUrl::creatUrl("")."".$item['img']."";?>">
					<img class="lazy" data-original='<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/60/h/60");?>'/>
				</a>
			</li>
			<?php }?>
		</ul>
	</div>
</div>



<div class="wrapper clearfix container_2">

	<!--左边栏-->
	<div class="sidebar f_l">

		<!--热卖商品-->
		<div class="box m_10">
			<div class="title">热卖商品</div>
			<div class="content">
				<ul  class="ranklist">
				<?php foreach(Api::run('getCommendHot') as $key => $item){?>
					<li class="current">
						<a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>"><img alt="<?php echo isset($item['name'])?$item['name']:"";?>" class="lazy" data-original="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."");?>" /></a>
						<a title="<?php echo isset($item['name'])?$item['name']:"";?>" class="p_name" href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a>
						<b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b>
					</li>
				<?php }?>
				</ul>
			</div>
		</div>
		<!--热卖商品-->
	</div>

	<!--滑动面tab标签-->
	<div class="main f_r">

		<div class="uc_title" name="showButton">
			<label class="current"><span>商品详情</span></label>
			<label><span>顾客评价(<?php echo isset($comments)?$comments:"";?>)</span></label>
			<label><span>购买记录(<?php echo isset($buy_num)?$buy_num:"";?>)</span></label>
			<label><span>购买前咨询(<?php echo isset($refer)?$refer:"";?>)</span></label>
			<label><span>网友讨论圈(<?php echo isset($discussion)?$discussion:"";?>)</span></label>
		</div>

		<div name="showBox">
			<!-- 商品详情 start -->
			<div>
				<ul class="saleinfos m_10 clearfix">
					<li>商品名称：<?php echo isset($name)?$name:"";?></li>

					<?php if(isset($brand) && $brand){?>
					<li>品牌：<?php echo $this->brandname;?></li>
					<?php }?>

					<?php if(isset($weight) && $weight){?>
					<li>商品毛重：<label id="data_weight"><?php echo isset($weight)?$weight:"";?></label></li>
					<?php }?>

					<?php if(isset($unit) && $unit){?>
					<li>单位：<?php echo isset($unit)?$unit:"";?></li>
					<?php }?>

					<?php if(isset($up_time) && $up_time){?>
					<li>上架时间：<?php echo isset($up_time)?$up_time:"";?></li>
					<?php }?>

					<?php if(($attribute)){?>
					<?php foreach($attribute as $key => $item){?>
					<li><?php echo isset($item['name'])?$item['name']:"";?>：<?php echo isset($item['attribute_value'])?$item['attribute_value']:"";?></li>
					<?php }?>
					<?php }?>
				</ul>
				<?php if(isset($content) && $content){?>
				<div class="salebox">
					<strong class="saletitle block">产品描述：</strong>
					<p class="saledesc"><?php echo isset($content)?$content:"";?></p>
				</div>
				<?php }?>
			</div>
			<!-- 商品详情 end -->

			<!-- 顾客评论 start -->
			<div class="hidden comment_list box">
				<div class="title3">
					<img class="lazy" data-original="<?php echo $this->getWebSkinPath()."images/front/comm.gif";?>" width="16px" height="16px" />
					商品评论<span class="f12 normal">（已有<b class="red2"><?php echo isset($comments)?$comments:"";?></b>条）</span>
				</div>

				<div id='commentBox'></div>

				<!--评论JS模板-->
				<script type='text/html' id='commentRowTemplate'>
				<div class="item">
					<div class="user">
						<div class="ico">
							<a href="javascript:void(0)">
								<img src="<?php echo IUrl::creatUrl("")."<%=head_ico%>";?>" onerror="this.src='<?php echo $this->getWebSkinPath()."images/front/user_ico.gif";?>'" />
							</a>
						</div>
						<span class="blue"><%=username%></span>
					</div>
					<dl class="desc">
						<p class="clearfix">
							<b>评分：</b>
							<span class="grade-star g-star<%=point%>"></span>
							<span class="light_gray"><%=comment_time%></span><label></label>
						</p>
						<hr />
						<p><b>评价：</b><span class="gray"><%=contents%></span></p>
						<%if(recontents){%>
						<p><b>回复：</b><span class="red"><%=recontents%></span></p>
						<%}%>
					</dl>
					<div class="corner b"></div>
				</div>
				<hr />
				</script>
			</div>
			<!-- 顾客评论 end -->

			<!-- 购买记录 start -->
			<div class="hidden box">
				<div class="title3">
					<img src="<?php echo $this->getWebSkinPath()."images/front/cart.gif";?>" alt="" />
					购买记录<span class="f12 normal">（已有<b class="red2"><?php echo isset($buy_num)?$buy_num:"";?></b>购买）</span>
				</div>

				<table width="100%" class="list_table m_10 mt_10">
					<colgroup>
						<col width="150" />
						<col width="120" />
						<col width="120" />
						<col width="150" />
						<col />
					</colgroup>

					<thead class="thead">
						<tr>
							<th>购买人</th>
							<th>出价</th>
							<th>数量</th>
							<th>购买时间</th>
							<th>状态</th>
						</tr>
					</thead>

					<tbody class="dashed" id="historyBox"></tbody>
				</table>

				<!--购买历史js模板-->
				<script type='text/html' id='historyRowTemplate'>
				<tr>
					<td><%=username?username:'游客'%></td>
					<td><%=goods_price%></td>
					<td class="bold orange"><%=goods_nums%></td>
					<td class="light_gray"><%=completion_time%></td>
					<td class="bold blue">成交</td>
				</tr>
				</script>
			</div>
			<!-- 购买记录 end -->

			<!-- 购买前咨询 start -->
			<div class="hidden comment_list box">
				<div class="title3">
					<span class="f_r f12 normal"><a class="comm_btn" href="<?php echo IUrl::creatUrl("/site/consult/id/".$id."");?>">我要咨询</a></span>
					<img src="<?php echo $this->getWebSkinPath()."images/front/cart.gif";?>" width="16" height="16" />购买前咨询<span class="f12 normal">（共<b class="red2"><?php echo isset($refer)?$refer:"";?></b>记录）</span>
				</div>

				<div id='referBox'></div>

				<!--购买咨询JS模板-->
				<script type='text/html' id='referRowTemplate'>
				<div class="item">
					<div class="user">
						<div class="ico"><img src="<?php echo IUrl::creatUrl("")."<%=head_ico%>";?>" width="70px" height="70px" onerror="this.src='<?php echo $this->getWebSkinPath()."images/front/user_ico.gif";?>'" /></div>
						<span class="blue"><%=username%></span>
					</div>
					<dl class="desc gray">
						<p>
							<img src="<?php echo $this->getWebSkinPath()."images/front/ask.gif";?>" width="16px" height="17px" />
							<b>咨询内容：</b><span class="f_r"><%=time%></span>
						</p>
						<p class="indent"><%=question%></p>
						<hr />
						<%if(answer){%>
						<p class="bg_gray"><img src="<?php echo $this->getWebSkinPath()."images/front/answer.gif";?>" width="16px" height="17px" />
						<b class="orange">商家回复：</b><span class="f_r"><%=reply_time%></span></p>
						<p class="indent bg_gray"><%=answer%></p>
						<%}%>
					</dl>
					<div class="corner b"></div>
					<div class="corner tl"></div>
				</div>
				<hr />
				</script>
			</div>
			<!-- 购买前咨询 end -->

			<!-- 网友讨论圈 start -->
			<div class="hidden box">
				<div class="title3">
					<span class="f_r f12 normal"><a class="comm_btn" name="discussButton">发表话题</a></span>
					<img src="<?php echo $this->getWebSkinPath()."images/front/discuss.gif";?>" width="18px" height="19px" />
					网友讨论圈<span class="f12 normal">（共<b class="red2"><?php echo isset($discussion)?$discussion:"";?></b>记录）</span>
				</div>
				<div class="wrap_box no_wrap">
					<!--讨论内容列表-->
					<table width="100%" class="list_table">
						<colgroup>
							<col />
							<col width="150">
						</colgroup>

						<tbody id='discussBox'></tbody>
					</table>

					<!--讨论JS模板-->
					<script type='text/html' id='discussRowTemplate'>
					<tr>
						<td class="t_l discussion_td" style="border:none;">
							<span class="blue"><%=username%></span>
						</td>
						<td style="border:none;" class="t_r gray discussion_td"><%=time%></td>
					</tr>
					<tr><td class="t_l" colspan="2"><%=contents%></td></tr>
					</script>

					<!--讨论内容输入框-->
					<table class="form_table" style="display:none;" id="discussTable">
						<colgroup>
							<col width="80px">
							<col />
						</colgroup>

						<tbody>
							<tr>
								<th>讨论内容：</th>
								<td valign="top"><textarea id="discussContent" pattern="required" alt="请填写内容"></textarea></td>
							</tr>
							<tr>
								<th>验证码：</th>
								<td><input type='text' class='gray_s' name='captcha' pattern='^\w{5}$' alt='填写下面图片所示的字符' /><label>填写下面图片所示的字符</label></td>
							</tr>
							<tr class="low">
								<th></th>
								<td><img src='<?php echo IUrl::creatUrl("/site/getCaptcha");?>' id='captchaImg' /><span class="light_gray">看不清？<a class="link" href="javascript:changeCaptcha();">换一张</a></span></td>
							</tr>
							<tr>
								<td></td>
								<td><label class="btn"><input type="submit" value="发表" name="sendDiscussButton" /></label></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- 网友讨论圈 end -->
		</div>
	</div>
</div>

<script type="text/javascript">
var _goods_id = <?php echo isset($id)?$id:"";?>;
var _promo = '<?php echo isset($promo)?$promo:"";?>';
var _spec_url = '<?php echo IUrl::creatUrl("/site/getProduct");?>';
var _join_url = '<?php echo IUrl::creatUrl("/simple/joinCart");?>';
var _show_cart_url = '<?php echo IUrl::creatUrl("/simple/showCart");?>';
var _store_nums = <?php echo isset($store_nums)?$store_nums:"";?>;

//DOM加载结束后
$(function(){
	//初始化商品详情对象
	var productInstance = new productClass("<?php echo isset($id)?$id:"";?>","<?php echo isset($this->user['user_id'])?$this->user['user_id']:"";?>","<?php echo isset($promo)?$promo:"";?>","<?php echo isset($active_id)?$active_id:"";?>");

	//初始化商品轮换图
	$('#goodsPhotoList').bxSlider({
		infiniteLoop:false,
		hideControlOnEnd:true,
		controls:true,
		pager:false,
		minSlides: 5,
		maxSlides: 5,
		slideWidth: 72,
		slideMargin: 15,
		onSliderLoad:function(currentIndex){
			//默认初始化显示第一张
			$('[thumbimg]:eq('+currentIndex+')').trigger('click');

			//放大镜
			//$("#picShow").imagezoom();
		}
	});

	//城市地域选择按钮事件
	$('.sel_area').hover(
		function(){
			$('.area_box').show();
		},function(){
			$('.area_box').hide();
		}
	);
	$('.area_box').hover(
		function(){
			$('.area_box').show();
		},function(){
			$('.area_box').hide();
		}
	);

	//详情滑动门按钮绑定
	$('[name="showButton"]>label').click(function()
	{
		//滑动按钮高亮
		$(this).siblings().removeClass('current');
		$(this).addClass('current');

		//滑动DIV显示
		$('[name="showBox"]>div').hide();
		$('[name="showBox"]>div:eq('+$(this).index()+')').show();

		//滑动按钮绑定事件
		switch($(this).index())
		{
			case 1:
			{
				productInstance.comment_ajax();
			}
			break;

			case 2:
			{
				productInstance.history_ajax();
			}
			break;

			case 3:
			{
				productInstance.refer_ajax();
			}
			break;

			case 4:
			{
				productInstance.discuss_ajax();
			}
			break;
		}
	});
});

/**
 * 规格的选择
 * @param _self 规格本身
 */
function sele_spec(_self)
{
	$('.tospec').removeClass('active');
	var _parent = $(_self).parent().parent().find('a').removeClass('current');
	$(_self).addClass('current');
	if ( _promo == '')
	{
		$('.pro-price i').html('');
	} else if ( _promo == 'time') {
		$('.pro-discount span').html('');
	} else if ( _promo == 'groupon') {
		$('.pro-discount span').html('');
	}

	//检查规格是否选择符合标准
	if(checkSpecSelected())
	{
		//整理规格值
		var specArray = [];
		$('[name="specColls"]').each(function(){
			specArray.push($(this).attr('value'));
		});
		var specJSON = '['+specArray.join(",")+']';
		var product_id = $(_self).attr('id');

		//获取货品数据并进行渲染
		$.getJSON(_spec_url,{"goods_id":_goods_id,"product_id":product_id,"specJSON":specJSON,"random":Math.random},function(json){
			if(json.flag == 'success')
			{
				if ( json.data.sell_price != <?php echo $this->hide_price;?>)
				{
					$('#buyNowButton').show();
					$('#joinCarButton').show();

					$('#data_goodsNo').text(json.data.products_no);
					$('#data_storeNums').text(json.data.store_nums);$('#data_storeNums').trigger('change');
					$('#data_groupPrice').text(json.data.group_price);
					$('#data_sellPrice').text(json.data.sell_price);
					$('#data_marketPrice').text(json.data.market_price);
					$('#data_weight').text(json.data.weight);
					$('#product_id').val(json.data.id);

					//库存监测
					checkStoreNums();
				} else {
					$('#data_sellPrice').html('<i><?php echo $this->hide_price_str;?></i>');
					$('#buyNowButton').hide();
					$('#joinCarButton').hide();
				}
			} else {
				layer.alert(json.message);
			}
		});
	}
}

/**
 * 检查规格选择是否符合标准
 * @return boolen
 */
function checkSpecSelected()
{
  var current_length = 0;
  $('[name="specColls"]').each(function(){
    if ($(this).hasClass('current'))
      current_length++;
  })
  if ($('[name="specColls"]').length === current_length || current_length > 0)
	{
		return true;
	}
	return false;
}

/**
 * 监测库存操作
 */
function checkStoreNums()
{
	var storeNums = parseInt(_store_nums);
	if(storeNums > 0)
	{
		//openBuy();
	} else {
		//closeBuy();
	}
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
				<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquerySlider/jquery.bxslider.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/jquerySlider/jquery.bxslider.css" />
<script language="javascript">
	//var _goods_list = <?php echo isset($goods_list_json)?$goods_list_json:"";?>;
	var _goods_id = 0;
	var _spec_id = 0;
	var SITE_URL = 'http://<?php echo get_host();?>';
	//var _seller_id = <?php echo isset($goods_list['0']['seller_id'])?$goods_list['0']['seller_id']:"";?>;
</script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jqueryZoom/jquery.imagezoom.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/jqueryZoom/imagezoom.css" />
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquerySlider/jquery.bxslider.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/jquerySlider/jquery.bxslider.css" />
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/layer/layer.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/products.js";?>"></script>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/products.css";?>">
<style>
.salebox img {max-width: 100%;}
.summary ul li .price i {font-size:14px;}
</style>

<?php $breadGuide = goods_class::catRecursion($category);?>
<div class="position"><span>您当前的位置：</span><a href="<?php echo IUrl::creatUrl("");?>">首页</a><?php foreach($breadGuide as $key => $item){?> » <a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$item['id']."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a><?php }?> » <?php echo isset($name)?$name:"";?></div>

<div class="wrapper clearfix">
	<div class="summary">
		<h2><?php echo isset($name)?$name:"";?></h2>
    <?php foreach($seller_info['goods_list'] as $key => $item){?>
			<div class="item w_27">
				<a href="javascript:void(0);" _id=<?php echo isset($item['id'])?$item['id']:"";?>>
					<?php echo isset($item['name'])?$item['name']:"";?>
				</a>
			</div>
		<?php }?>
		<!--基本信息区域-->

		<ul>
			<li>
				<span class="f_r light_gray">商品编号<?php echo isset($goods_list['seller_id'])?$goods_list['seller_id']:"";?>：<label id="data_goodsNo"><?php echo $goods_no?$goods_no:$id;?></label></span>
			</li>

			<!--抢购活动,引入 "_products_time"模板-->
			<?php if($promo == 'time' && isset($time)){?>
			<?php require(ITag::createRuntime("_products_time"));?>
			<?php }?>

			<!--团购活动,引入 "_products_groupon"模板-->
			<?php if($promo == 'groupon' && isset($groupon)){?>
			<?php require(ITag::createRuntime("_products_groupon"));?>
			<?php }?>

			<!--普通商品购买-->
			<?php if($promo == ''){?>
				<?php if($group_price){?>
				<!--当前用户有会员价-->

				<li>
					会员价：<b class="price red2">￥<span class="f30" id="data_groupPrice"></span></b>
				</li>
				<li>
					原售价：￥<s id="data_sellPrice"><?php echo isset($sell_price)?$sell_price:"";?></s>
				</li>
				<?php }else{?>
				<!--当前用户普通价格-->
				<li>
					销售价：<b class="price red2"><span class="f30" id="data_sellPrice"><?php if($sell_price != $this->hide_price){?><?php echo isset($sell_price)?$sell_price:"";?><?php }else{?><i><?php echo $this->hide_price_str;?></i><?php }?></span></b>
				</li>
				<?php }?>
			<?php }?>

			<li>
				市场价：￥<s id="data_marketPrice"><?php echo isset($market_price)?$market_price:"";?></s>
			</li>

			<li>
				库存：现货<span>(<label id="data_storeNums"><?php echo isset($store_nums)?$store_nums:"";?></label>)</span>
				<a class="favorite" onclick="favorite_add_ajax(<?php echo isset($id)?$id:"";?>,this);" href="javascript:void(0)">收藏此商品</a>
			</li>



			<?php if($point > 0){?>
			<li>送积分：单件送<?php echo isset($point)?$point:"";?>分</li>
			<?php }?>

			<!-- 商家信息 开始 -->
			<?php if(isset($seller)){?>
			<li>商家：<a class="orange" href="<?php echo IUrl::creatUrl("/site/home/id/".$seller_id."");?>"><?php echo isset($seller['true_name'])?$seller['true_name']:"";?></a></li>
			<?php if($seller['phone']){?><li>联系电话：<?php echo isset($seller['phone'])?$seller['phone']:"";?></li><?php }?>
			<li>所在地：<?php echo join(' ',area::name($seller['province'],$seller['city'],$seller['area']));?></li>
			<li><?php plugin::trigger("onServiceButton",$seller['id'])?></li>
			<?php }?>
			<!--商家信息 结束-->
		</ul>

		<!--购买区域-->
		<?php if($sell_price != $this->hide_price){?>
		<div class="current">
		<?php if($store_nums <= 0){?>
			该商品已售完，不能购买，您可以看看其它商品！(<a href="<?php echo IUrl::creatUrl("/simple/arrival/goods_id/".$id."");?>" class="orange">到货通知</a>)
		<?php }else{?>

			<!--商品规格选择 开始-->

				<?php if($goods_spec_array['value']){?>
				<dl class="m_10 clearfix" name="specCols">
					<dt>课程属性：</dt>
					<dd class="w_45">
						<?php foreach($goods_spec_array['value'] as $key => $spec_value){?>
						<div class="item w_27">
							<!-- <a href="javascript:void(0);" onclick="sele_goods(this);" _id=<?php echo isset($item['id'])?$item['id']:"";?>> -->
							<a href="javascript:void(0);" name="specColls" onclick="sele_spec(this);" id="<?php echo isset($spec_value['id'])?$spec_value['id']:"";?>" value='{"id":"<?php echo isset($spec_value['id'])?$spec_value['id']:"";?>","value":"<?php echo isset($spec_value['cusval'])?$spec_value['cusval']:"";?>","classnum":"<?php echo isset($spec_value['classnum'])?$spec_value['classnum']:"";?>","month":"<?php echo isset($spec_value['month'])?$spec_value['month']:"";?>","name":"<?php echo isset($goods_spec_array['name'])?$goods_spec_array['name']:"";?>"}'>
								<?php if($spec_value['cusval']){?>
									<?php echo isset($spec_value['cusval'])?$spec_value['cusval']:"";?><?php if($spec_value['classnum'] || $spec_value['month']){?>/<?php }?>
								<?php }?>
								<?php if($spec_value['classnum']){?>
									<?php echo isset($spec_value['classnum'])?$spec_value['classnum']:"";?>课时<?php if($spec_value['month']){?>/<?php }?>
								<?php }?>
								<?php if($spec_value['month']){?><?php echo isset($spec_value['month'])?$spec_value['month']:"";?>个月<?php }?>
							</a>
						</div>
						<?php }?>
					</dd>
				</dl>
				<?php }?>


			<!--商品规格选择 结束-->


			<div class="chit_info"></div>

			<dl class="m_10 clearfix">
					<dt>报名人数：</dt>
					<dd>

						<div class="resize">
							<a class="add" id="buyAddButton" href="javascript:void(0);">-</a>
							<input class="gray_t f_l" type="text" id="buyNums" onkeyup="setAmount.modify('#buyNums')" value="1" maxlength="5"  />
							<a class="reduce" id="buyReduceButton" href="javascript:void(0);">+</a>
						</div>
					</dd>
				</dl>

		    <input  type="button" id="buyNowButton" value="立即付款" />
				<input type="button" id="joinCarButton" value="加入课表" />

		<?php }?>
		</div>
		<?php }?>
	</div>


	<!--图片放大镜-->
	<div class="preview">
		<div class="pic_show">
			<img id="picShow" rel="" src="" />
		</div>

		<ul id="goodsPhotoList" class="pic_thumb">
			<?php foreach($photo as $key => $item){?>
			<li>
				<a href="javascript:void(0);" thumbimg="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/435/h/435");?>" sourceimg="<?php echo IUrl::creatUrl("")."".$item['img']."";?>">
					<img class="lazy" data-original='<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/60/h/60");?>'/>
				</a>
			</li>
			<?php }?>
		</ul>
	</div>
</div>



<div class="wrapper clearfix container_2">

	<!--左边栏-->
	<div class="sidebar f_l">

		<!--热卖商品-->
		<div class="box m_10">
			<div class="title">热卖商品</div>
			<div class="content">
				<ul  class="ranklist">
				<?php foreach(Api::run('getCommendHot') as $key => $item){?>
					<li class="current">
						<a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>"><img alt="<?php echo isset($item['name'])?$item['name']:"";?>" class="lazy" data-original="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."");?>" /></a>
						<a title="<?php echo isset($item['name'])?$item['name']:"";?>" class="p_name" href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a>
						<b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b>
					</li>
				<?php }?>
				</ul>
			</div>
		</div>
		<!--热卖商品-->
	</div>

	<!--滑动面tab标签-->
	<div class="main f_r">

		<div class="uc_title" name="showButton">
			<label class="current"><span>商品详情</span></label>
			<label><span>顾客评价(<?php echo isset($comments)?$comments:"";?>)</span></label>
			<label><span>购买记录(<?php echo isset($buy_num)?$buy_num:"";?>)</span></label>
			<label><span>购买前咨询(<?php echo isset($refer)?$refer:"";?>)</span></label>
			<label><span>网友讨论圈(<?php echo isset($discussion)?$discussion:"";?>)</span></label>
		</div>

		<div name="showBox">
			<!-- 商品详情 start -->
			<div>
				<ul class="saleinfos m_10 clearfix">
					<li>商品名称：<?php echo isset($name)?$name:"";?></li>

					<?php if(isset($brand) && $brand){?>
					<li>品牌：<?php echo $this->brandname;?></li>
					<?php }?>

					<?php if(isset($weight) && $weight){?>
					<li>商品毛重：<label id="data_weight"><?php echo isset($weight)?$weight:"";?></label></li>
					<?php }?>

					<?php if(isset($unit) && $unit){?>
					<li>单位：<?php echo isset($unit)?$unit:"";?></li>
					<?php }?>

					<?php if(isset($up_time) && $up_time){?>
					<li>上架时间：<?php echo isset($up_time)?$up_time:"";?></li>
					<?php }?>

					<?php if(($attribute)){?>
					<?php foreach($attribute as $key => $item){?>
					<li><?php echo isset($item['name'])?$item['name']:"";?>：<?php echo isset($item['attribute_value'])?$item['attribute_value']:"";?></li>
					<?php }?>
					<?php }?>
				</ul>
				<?php if(isset($content) && $content){?>
				<div class="salebox">
					<strong class="saletitle block">产品描述：</strong>
					<p class="saledesc"><?php echo isset($content)?$content:"";?></p>
				</div>
				<?php }?>
			</div>
			<!-- 商品详情 end -->

			<!-- 顾客评论 start -->
			<div class="hidden comment_list box">
				<div class="title3">
					<img class="lazy" data-original="<?php echo $this->getWebSkinPath()."images/front/comm.gif";?>" width="16px" height="16px" />
					商品评论<span class="f12 normal">（已有<b class="red2"><?php echo isset($comments)?$comments:"";?></b>条）</span>
				</div>

				<div id='commentBox'></div>

				<!--评论JS模板-->
				<script type='text/html' id='commentRowTemplate'>
				<div class="item">
					<div class="user">
						<div class="ico">
							<a href="javascript:void(0)">
								<img src="<?php echo IUrl::creatUrl("")."<%=head_ico%>";?>" onerror="this.src='<?php echo $this->getWebSkinPath()."images/front/user_ico.gif";?>'" />
							</a>
						</div>
						<span class="blue"><%=username%></span>
					</div>
					<dl class="desc">
						<p class="clearfix">
							<b>评分：</b>
							<span class="grade-star g-star<%=point%>"></span>
							<span class="light_gray"><%=comment_time%></span><label></label>
						</p>
						<hr />
						<p><b>评价：</b><span class="gray"><%=contents%></span></p>
						<%if(recontents){%>
						<p><b>回复：</b><span class="red"><%=recontents%></span></p>
						<%}%>
					</dl>
					<div class="corner b"></div>
				</div>
				<hr />
				</script>
			</div>
			<!-- 顾客评论 end -->

			<!-- 购买记录 start -->
			<div class="hidden box">
				<div class="title3">
					<img src="<?php echo $this->getWebSkinPath()."images/front/cart.gif";?>" alt="" />
					购买记录<span class="f12 normal">（已有<b class="red2"><?php echo isset($buy_num)?$buy_num:"";?></b>购买）</span>
				</div>

				<table width="100%" class="list_table m_10 mt_10">
					<colgroup>
						<col width="150" />
						<col width="120" />
						<col width="120" />
						<col width="150" />
						<col />
					</colgroup>

					<thead class="thead">
						<tr>
							<th>购买人</th>
							<th>出价</th>
							<th>数量</th>
							<th>购买时间</th>
							<th>状态</th>
						</tr>
					</thead>

					<tbody class="dashed" id="historyBox"></tbody>
				</table>

				<!--购买历史js模板-->
				<script type='text/html' id='historyRowTemplate'>
				<tr>
					<td><%=username?username:'游客'%></td>
					<td><%=goods_price%></td>
					<td class="bold orange"><%=goods_nums%></td>
					<td class="light_gray"><%=completion_time%></td>
					<td class="bold blue">成交</td>
				</tr>
				</script>
			</div>
			<!-- 购买记录 end -->

			<!-- 购买前咨询 start -->
			<div class="hidden comment_list box">
				<div class="title3">
					<span class="f_r f12 normal"><a class="comm_btn" href="<?php echo IUrl::creatUrl("/site/consult/id/".$id."");?>">我要咨询</a></span>
					<img src="<?php echo $this->getWebSkinPath()."images/front/cart.gif";?>" width="16" height="16" />购买前咨询<span class="f12 normal">（共<b class="red2"><?php echo isset($refer)?$refer:"";?></b>记录）</span>
				</div>

				<div id='referBox'></div>

				<!--购买咨询JS模板-->
				<script type='text/html' id='referRowTemplate'>
				<div class="item">
					<div class="user">
						<div class="ico"><img src="<?php echo IUrl::creatUrl("")."<%=head_ico%>";?>" width="70px" height="70px" onerror="this.src='<?php echo $this->getWebSkinPath()."images/front/user_ico.gif";?>'" /></div>
						<span class="blue"><%=username%></span>
					</div>
					<dl class="desc gray">
						<p>
							<img src="<?php echo $this->getWebSkinPath()."images/front/ask.gif";?>" width="16px" height="17px" />
							<b>咨询内容：</b><span class="f_r"><%=time%></span>
						</p>
						<p class="indent"><%=question%></p>
						<hr />
						<%if(answer){%>
						<p class="bg_gray"><img src="<?php echo $this->getWebSkinPath()."images/front/answer.gif";?>" width="16px" height="17px" />
						<b class="orange">商家回复：</b><span class="f_r"><%=reply_time%></span></p>
						<p class="indent bg_gray"><%=answer%></p>
						<%}%>
					</dl>
					<div class="corner b"></div>
					<div class="corner tl"></div>
				</div>
				<hr />
				</script>
			</div>
			<!-- 购买前咨询 end -->

			<!-- 网友讨论圈 start -->
			<div class="hidden box">
				<div class="title3">
					<span class="f_r f12 normal"><a class="comm_btn" name="discussButton">发表话题</a></span>
					<img src="<?php echo $this->getWebSkinPath()."images/front/discuss.gif";?>" width="18px" height="19px" />
					网友讨论圈<span class="f12 normal">（共<b class="red2"><?php echo isset($discussion)?$discussion:"";?></b>记录）</span>
				</div>
				<div class="wrap_box no_wrap">
					<!--讨论内容列表-->
					<table width="100%" class="list_table">
						<colgroup>
							<col />
							<col width="150">
						</colgroup>

						<tbody id='discussBox'></tbody>
					</table>

					<!--讨论JS模板-->
					<script type='text/html' id='discussRowTemplate'>
					<tr>
						<td class="t_l discussion_td" style="border:none;">
							<span class="blue"><%=username%></span>
						</td>
						<td style="border:none;" class="t_r gray discussion_td"><%=time%></td>
					</tr>
					<tr><td class="t_l" colspan="2"><%=contents%></td></tr>
					</script>

					<!--讨论内容输入框-->
					<table class="form_table" style="display:none;" id="discussTable">
						<colgroup>
							<col width="80px">
							<col />
						</colgroup>

						<tbody>
							<tr>
								<th>讨论内容：</th>
								<td valign="top"><textarea id="discussContent" pattern="required" alt="请填写内容"></textarea></td>
							</tr>
							<tr>
								<th>验证码：</th>
								<td><input type='text' class='gray_s' name='captcha' pattern='^\w{5}$' alt='填写下面图片所示的字符' /><label>填写下面图片所示的字符</label></td>
							</tr>
							<tr class="low">
								<th></th>
								<td><img src='<?php echo IUrl::creatUrl("/site/getCaptcha");?>' id='captchaImg' /><span class="light_gray">看不清？<a class="link" href="javascript:changeCaptcha();">换一张</a></span></td>
							</tr>
							<tr>
								<td></td>
								<td><label class="btn"><input type="submit" value="发表" name="sendDiscussButton" /></label></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- 网友讨论圈 end -->
		</div>
	</div>
</div>

<script type="text/javascript">
var _goods_id = <?php echo isset($id)?$id:"";?>;
var _promo = '<?php echo isset($promo)?$promo:"";?>';
var _spec_url = '<?php echo IUrl::creatUrl("/site/getProduct");?>';
var _join_url = '<?php echo IUrl::creatUrl("/simple/joinCart");?>';
var _show_cart_url = '<?php echo IUrl::creatUrl("/simple/showCart");?>';
var _store_nums = <?php echo isset($store_nums)?$store_nums:"";?>;

//DOM加载结束后
$(function(){
	//初始化商品详情对象
	var productInstance = new productClass("<?php echo isset($id)?$id:"";?>","<?php echo isset($this->user['user_id'])?$this->user['user_id']:"";?>","<?php echo isset($promo)?$promo:"";?>","<?php echo isset($active_id)?$active_id:"";?>");

	//初始化商品轮换图
	$('#goodsPhotoList').bxSlider({
		infiniteLoop:false,
		hideControlOnEnd:true,
		controls:true,
		pager:false,
		minSlides: 5,
		maxSlides: 5,
		slideWidth: 72,
		slideMargin: 15,
		onSliderLoad:function(currentIndex){
			//默认初始化显示第一张
			$('[thumbimg]:eq('+currentIndex+')').trigger('click');

			//放大镜
			//$("#picShow").imagezoom();
		}
	});

	//城市地域选择按钮事件
	$('.sel_area').hover(
		function(){
			$('.area_box').show();
		},function(){
			$('.area_box').hide();
		}
	);
	$('.area_box').hover(
		function(){
			$('.area_box').show();
		},function(){
			$('.area_box').hide();
		}
	);

	//详情滑动门按钮绑定
	$('[name="showButton"]>label').click(function()
	{
		//滑动按钮高亮
		$(this).siblings().removeClass('current');
		$(this).addClass('current');

		//滑动DIV显示
		$('[name="showBox"]>div').hide();
		$('[name="showBox"]>div:eq('+$(this).index()+')').show();

		//滑动按钮绑定事件
		switch($(this).index())
		{
			case 1:
			{
				productInstance.comment_ajax();
			}
			break;

			case 2:
			{
				productInstance.history_ajax();
			}
			break;

			case 3:
			{
				productInstance.refer_ajax();
			}
			break;

			case 4:
			{
				productInstance.discuss_ajax();
			}
			break;
		}
	});
});

/**
 * 规格的选择
 * @param _self 规格本身
 */
function sele_spec(_self)
{
	$('.tospec').removeClass('active');
	var _parent = $(_self).parent().parent().find('a').removeClass('current');
	$(_self).addClass('current');
	if ( _promo == '')
	{
		$('.pro-price i').html('');
	} else if ( _promo == 'time') {
		$('.pro-discount span').html('');
	} else if ( _promo == 'groupon') {
		$('.pro-discount span').html('');
	}

	//检查规格是否选择符合标准
	if(checkSpecSelected())
	{
		//整理规格值
		var specArray = [];
		$('[name="specColls"]').each(function(){
			specArray.push($(this).attr('value'));
		});
		var specJSON = '['+specArray.join(",")+']';
		var product_id = $(_self).attr('id');

		//获取货品数据并进行渲染
		$.getJSON(_spec_url,{"goods_id":_goods_id,"product_id":product_id,"specJSON":specJSON,"random":Math.random},function(json){
			if(json.flag == 'success')
			{
				if ( json.data.sell_price != <?php echo $this->hide_price;?>)
				{
					$('#buyNowButton').show();
					$('#joinCarButton').show();

					$('#data_goodsNo').text(json.data.products_no);
					$('#data_storeNums').text(json.data.store_nums);$('#data_storeNums').trigger('change');
					$('#data_groupPrice').text(json.data.group_price);
					$('#data_sellPrice').text(json.data.sell_price);
					$('#data_marketPrice').text(json.data.market_price);
					$('#data_weight').text(json.data.weight);
					$('#product_id').val(json.data.id);

					//库存监测
					checkStoreNums();
				} else {
					$('#data_sellPrice').html('<i><?php echo $this->hide_price_str;?></i>');
					$('#buyNowButton').hide();
					$('#joinCarButton').hide();
				}
			} else {
				layer.alert(json.message);
			}
		});
	}
}

/**
 * 检查规格选择是否符合标准
 * @return boolen
 */
function checkSpecSelected()
{
  var current_length = 0;
  $('[name="specColls"]').each(function(){
    if ($(this).hasClass('current'))
      current_length++;
  })
  if ($('[name="specColls"]').length === current_length || current_length > 0)
	{
		return true;
	}
	return false;
}

/**
 * 监测库存操作
 */
function checkStoreNums()
{
	var storeNums = parseInt(_store_nums);
	if(storeNums > 0)
	{
		//openBuy();
	} else {
		//closeBuy();
	}
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
