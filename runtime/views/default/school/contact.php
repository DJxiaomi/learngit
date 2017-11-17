<?php 
	$myCartObj  = new Cart();
	$myCartInfo = $myCartObj->getMyCart();
	$siteConfig = new Config("site_config");
	$callback   = IReq::get('callback') ? urlencode(IFilter::act(IReq::get('callback'),'url')) : '';
	$navigation_list = navigation_class::get_navigation_list(1,0);
	$navigation_list2 = navigation_class::get_navigation_list(2,0);
	$user_id = $this->user['user_id'];
	$member_info = member_class::get_member_info($user_id);
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
	<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."resource/min/?f=". rtrim(IUrl::creatUrl(""), "/")."/resource/scripts/jquery.min.js";?>'></script>
	<script src="<?php echo IUrl::creatUrl("")."resource/scripts/layer/layer.js";?>"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."resource/min/?f=". rtrim(IUrl::creatUrl(""), "/")."/resource/scripts/common.js,". rtrim($this->getWebViewPath(), "/")."/javascript/site.js";?>'></script>
	<link href="<?php echo IUrl::creatUrl("")."resource/min/?f=". rtrim(IUrl::creatUrl(""), "/")."/resource/css/font-awesome.min.css,". rtrim($this->getWebSkinPath() , "/")."/css/common.css";?>" rel="stylesheet" type="text/css" />

	<?php if($_GET['action'] == 'show'){?>
	<!--flexslider-css-->
	<!--bootstrap-->
	<link href="<?php echo $this->getWebSkinPath()."school/css/bootstrap.min.css";?>" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."school/css/lightbox.css";?>" type="text/css" media="all" />
	<!--coustom css-->
	<link href="<?php echo $this->getWebSkinPath()."school/css/style.css";?>" rel="stylesheet" type="text/css"/>
	<!--fonts-->
	<!--<link href='http://fonts.useso.com/css?family=Open+Sans:400,300,300italic,400italic,800italic,800,700italic,700,600,600italic' rel='stylesheet' type='text/css'>-->
	<!--/fonts-->
	<!--script-->
	<script src="<?php echo $this->getWebSkinPath()."school/js/bootstrap.js";?>"></script>
	<!--/script-->
	<!--move-top-->
	<script type="text/javascript" src="<?php echo $this->getWebSkinPath()."school/js/easing.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebSkinPath()."school/js/responsiveslides.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebSkinPath()."school/js/jquery.SuperSlide.2.1.1.js";?>"></script>
	<!--/script-->

	<style>
		.TopBar a {text-decoration: none; font-family:"微软雅黑"}
		i.phone-erweima { margin-top: -125px; }
	</style>
	<?php }?>

</head>
<body class="index">

<!-- 工具条 S -->
 <div class="toolbar">
	<a href="#"><div class="top-btn"><i></i></div></a>
	<ul>
		<a href="tencent://message/?Menu=yes&amp;uin=2821518520&amp;Service=58&amp;SigT=A7F6FEA02730C9881B11E0AE7AF2E2413E3090997F5951E7CFC7F66A8EF4F5D7A3233F568A8EBC2B984019AC21FF99093F241FB5CD7A7DD4C39596B28D63C849FBCF4A5AED55184EFE696F36F9FF6428EEC729D42EF963C0FD5E9BAC2AD18620E7ADFC9387D83C4B46A7B0C2DC4B63341934EE44C822C196"><li><div class="qq"><i></i></div></li></a>
		<li><div class="wechat-icon"><i></i></div><span class="phone-box"><i class="wechat-erweima"></i><p>微信公众号</p></span></li>
		<a href="<?php echo IUrl::creatUrl("/ucenter/index");?>"><li><div class="tel"><i></i></div><span class="normal tel_span"><p>400-1155-477</p></span></li></a>
		<a href="<?php echo IUrl::creatUrl("/ucenter/index");?>"><li><div class="yonghu"><i></i></div><span class="normal user_span"><p class="user">个人信息</p></span></li></a>
		<a href="<?php echo IUrl::creatUrl("/simple/cart");?>" style="display:none;"><li><div class="shopcar"><i></i></div><span class="normal"><p>课程表</p></span></li></a>
		<li><div class="phone-icon"><i></i></div><span class="phone-box"><i class="phone-erweima"></i><p class="phone">手机APP</p></span></li>
	</ul>
 </div>
 <!-- 工具条 E -->

 <!-- fixed topbar start -->
 <div class="TopBar fixtopbar">
	 <div class="Wrap">
			 <div class="fl">城市：<a class=" " href="<?php echo IUrl::creatUrl("/site/pro_list");?>" style="border-left:0;">株洲<i class="arrow-icon" style="display:none;"></i></a></div>
			 <div class="fr head-right">
					<?php if($this->user){?>
						您好<a href="<?php echo IUrl::creatUrl("/ucenter/index");?>"><?php echo $this->user['username'];?></a>，欢迎来到<?php echo $siteConfig->name;?>！[<a href="<?php echo IUrl::creatUrl("/simple/logout");?>" class="reg red">退出</a>]
					<?php }else{?>
						<a href="<?php echo IUrl::creatUrl("/ucenter/index");?>" style="border-left:0;">你好，请登录</a>
						<a href="<?php echo IUrl::creatUrl("/simple/reg?callback=".$callback."");?>" style="color:#090970;">免费注册</a>
					<?php }?>

			<?php if($navigation_list){?>
				<?php foreach($navigation_list as $key => $item){?>
					<?php if($item['type'] == 1){?>
						<a href="<?php echo isset($item['link'])?$item['link']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a>
					<?php }elseif($item['type'] == 2){?>
						<a class="place-on navigation_menu" href="javascript:void(0);"><?php echo isset($item['name'])?$item['name']:"";?><i class="arrow-icon"></i></a>
						<?php if($item['child']){?>
							<ul class="navigation_child nav_module_<?php echo isset($key)?$key:"";?>">
								<?php foreach($item['child'] as $key => $val){?>
									<li><a class=" " href="<?php echo isset($val['link'])?$val['link']:"";?>"><?php echo isset($val['name'])?$val['name']:"";?></a></li>
								<?php }?>
							</ul>
						<?php }?>
					<?php }else{?>
						<a class="navigation_menu sjlx-on" href="javascript:void(0);"><i class="phone-icon"></i><?php echo isset($item['name'])?$item['name']:"";?><i class="arrow-icon"></i></a>
						<ul class="navigation_child sjlx">
							<li>
								<div class="erweima">
									<a href="javascript:void(0);">
										<img src="/views/default/skin/default/erweima.png" data="http://www.dsanke.com/views/default/skin/default/erweima.png" />
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

	<?php if($_GET['action'] != 'show'){?>
	<!-- Header S -->
	<div class="Header ">
		 <!-- TopBar -->
		 <div class="TopBar">

		 </div>
		 <!-- TopBox -->
		 <div class="TopBox Wrap">
				 <!-- logo -->
				 <a class="logo fl" href="http://<?php echo get_host();?>" title="第三课"></a>
				 <!-- search -->
				 <div class="search fl">
						<div class="searchTool">
								<form method='get' action='<?php echo IUrl::creatUrl("/");?>' id="form_keyword">
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
						 		 <li class="nav_menu-item first-child"><span>全部分类</span><div style="text-align:left;">ALL CATEGORIES</div></li>
								 <?php }else{?>
								 <li class="nav_menu-item first-child"><a href="javascript:void(0);" style="margin-left:23px;">全部分类<div>ALL CATEGORIES</div></a></li>
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
		 <script type="text/javascript">
		 	//$(function(){
		 		$('.nav_menu').find('li').each(function(){
					var host = '<?php echo IUrl::getHost();?>',
						href = $(this).find('a').attr('href'),
						local = window.location.href;
					if(local == (host + href) && href != '/index.php'){
						$(this).addClass('cur');
					}
				});
				function set_navigation()
				{
					var left = ($(window).width() - 1200) / 2;
					$('.Nav_left').css('width', left);
					$('.Nav_right').css('width', left);
				}
				window.onresize = set_navigation;
				$(document).ready(function(){
					set_navigation();
				});
		 	//});
		 </script>
	</div>
	<!-- Header E -->
	<?php }?>

	<!-- 内容 S -->
	<div class="<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '') || ($this->getId() == 'site' && $_GET['action'] == 'intro')){?>module_content_index<?php }else{?>module_content<?php }?>">
		<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QDA0aO9Dw8tVx22vuULQuGXOGFV5a5ZD"></script>
<section class="Contact">
	<div class="page-header">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>联系我们</h1>
					<p style="text-align:center;">地址：<?php echo join(' ',area::name($this->seller['province'],$this->seller['city'],$this->seller['area']));?> <?php echo isset($this->seller['address'])?$this->seller['address']:"";?></p>
					<p style="text-align:center;">电话：<?php echo isset($this->seller['phone'])?$this->seller['phone']:"";?></p>
				</div>
			</div>	
		</div>	
	</div>	
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="hotlink well">
					<img class="img-responsive" src="<?php echo $this->getWebSkinPath()."school/images/contact.png";?>" alt="" />
					<div class="well well-sm">
						<div class="list-line">
							<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo isset($this->seller['qq'])?$this->seller['qq']:"";?>&amp;site=qq&amp;menu=yes" target="_blank"><i class="fa fa-phone"></i> 在线客服</a> 
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="contact-form">
					
					<p>学校地图</p>
					<div class="map-group">
						<?php if($this->seller['address']){?>
						<style type="text/css">#allmap{ height: 400px; }</style>
						<div id="allmap"></div>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php if($this->seller['address']){?>
<script type="text/javascript">
	// 百度地图API功能
	var map = new BMap.Map("allmap");
	var point = new BMap.Point(116.331398,39.897445);
	map.centerAndZoom(point,12);
	map.enableScrollWheelZoom(true);
	// 创建地址解析器实例
	var myGeo = new BMap.Geocoder();
	// 将地址解析结果显示在地图上,并调整地图视野
	myGeo.getPoint("<?php echo join('',area::name($this->seller['province'],$this->seller['city'],$this->seller['area']));?><?php echo isset($this->seller['address'])?$this->seller['address']:"";?>", function(point){
		if (point) {
			map.centerAndZoom(point, 16);
			map.addOverlay(new BMap.Marker(point));
		}else{
			alert("您选择地址没有解析到结果!");
		}
	}, "湖南省");
</script>
<?php }?>
	</div>
	<!-- 内容 E -->

	<!-- float_ad start -->
	<div class="float_ad">
		<a href="<?php echo IUrl::creatUrl("/school/home/id/365");?>" target="_blank"><img src="/views/default/skin/default/images/shiting.png"></a>
	</div>
	<!-- float_ad end -->

	<?php if($_GET['action'] != 'show'){?>
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
									<li><a href="<?php echo isset($item['link'])?$item['link']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a></li>
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
							第三课APP<br /><img src="/views/default/skin/default/images/qrcode_1.png" />
						</li>
						<li>
							第三课微信公众号<br /><img src="/views/default/skin/default/images/qrcode_2.png" />
						</li>
					</ul>
				</div>
		    <div class="clear"></div>
		    <!-- copyright -->
		    <div class="copyright">
		        <div class="Wrap">
					<div class="tubbiao">
	<!-- <a href="http://webscan.360.cn/index/checkwebsite/url/www.dsanke.com"><img border="0" src="http://img.webscan.360.cn/status/pai/hash/a1f20bc445d31538899515dd5b5ff053"/></a> -->
  <a href="http://webscan.360.cn/index/checkwebsite/url/www.dsanke.com"><img src="/views/default/skin/default/images/t013365a715435676e8.jpg"/></a>
		 </div>
		            <p clas="footP1">Powered by 第三课</p>
		            <p class="footP1">Copyright©2014-2016&nbsp;<a class="copyys" target="_blank" href="http://www.miibeian.gov.cn/">湘ICP备15005945号-1</a> &nbsp;版权所有</p>
		        </div>
		    </div>
	    </div>
	</div>
	<!-- Footer E -->
	<?php }?>

</body>
</html>
