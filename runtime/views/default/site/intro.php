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
		<script type='text/javascript' src='/resource/public/assets/js/amazeui.min.js'></script>
<link href="/resource/public/assets/css/amazeui.min.css" rel="stylesheet" type="text/css" />
<link href="/resource/public/css/style.css" rel="stylesheet" type="text/css" />

<div id="intro" style="background-color:#fff;">
    <div class="intro_top"></div>
    <div class="intro_content">
        <div class="part part_info">
            <div class="part_tit">
                <div class="t_con">
                    <h3>企业<em>简介</em></h3>
                    <p>COMPANY PROFILE</p>
                </div>
            </div>
            <div class="company">
                <div class="company_left"></div>
                <div class="company_right">
                    <p>“第三课”是教育培训资源聚集的”互联网+教育培训”网络平台，具有教育资讯发布、信息交流、教育培训课程展示和文化产品交易的功能，以创新和多元的线上线下活动，为教育培训机构和家长、学生的互动交流创造积极的互动环境，协助合作教育培训机构宣传和招生，帮助家长和学生找到满意的教育培训机构与课程并参与学习。我们的目标是让做教育的人专心做教育，让受教育的人能更方便的受到良好的教育，形成一个教育培训机构、受教育者、教育网络平台三赢的局面。</p>
                    <p>“第一课”来自家庭，古有孟母育子，今有家庭教育，家庭给了孩子在这个世界的第一次学习机会，家庭教育对孩子未来的成长和今后的性格养成起到重要影响。</p>
                    <p>“第二课”来自校园，古有家学私塾，今有菁菁校园，学校教育可以让教育变得具有目的性，计划性，组织性和系统性。确保孩子的教育发展行在主路子上。</p>
                    <p>“第三课”来自社会，三生万物，社会教育提供比家和学校更加多元化的教学理念，更细分的课程设置，更精准的课堂训练，可以让学生学到家庭和课堂中学不到知识和技能，是家庭和课堂之外不可替代的必要补充。</p>
                    <p>“第三课”伴随每个人的成长。幼儿阶段，“第三课”是智慧启蒙，让你茁壮成长！学生年代，“第三课”是升学助力，让你升学无忧！成年时期，“第三课”是素质培养，让你卓尔不群！</p>
                    <p>“第三课”让你的人生与众不同！</p>
                </div>
            </div>
        </div>
        <div class="part part_train">
            <div class="part_tit">
                <div class="t_con">
                    <h3>培训<em>课程</em></h3>
                    <p>TRAINING COURSE</p>
                </div>
            </div>
            <div class="train">
            </div>
        </div>
        <div class="part part_advantage">
            <div class="part_tit">
                <div class="t_con">
                    <h3>平台<em>优势</em></h3>
                    <p>PLATFORM ADVANTAGE</p>
                </div>
            </div>
            <div class="advantage">
                <p>教育信息交流、和教育产品交易</p>
                <p>学校广告宣传和招生平台</p>
                <p>帮助家长和学生找到最合适的学校学习</p>
                <div class="img_advantage"></div>
            </div>
        </div>
        <div class="part part_partner">
            <div class="part_tit">
                <div class="t_con">
                    <h3>合作<em>伙伴</em></h3>
                    <p>COOPERATIVE PARTNER</p>
                </div>
            </div>
            <div class="partner">
                <div data-am-widget="slider" class="am-slider am-slider-default" data-am-slider='{"animation":"slide","animationLoop":true,"itemWidth":167,"itemMargin":34,"slideshow": true,"move":1,"directionNav":false,"controlNav":false,"slideshowSpeed":3000,"pauseOnHover":true}' >
                    <ul class="am-slides">
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/303");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_ctl.jpg">
                                <p>春天里艺术学校</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/282");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_mt.jpg">
                                <p>梦田艺术教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/241");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_ql.jpg">
                                <p>启乐棒球</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/249");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_qcjy.jpg">
                                <p>奇创乐高</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/253");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jdjy.jpg">
                                <p>君道教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/338");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_yzs.jpg">
                                <p>艺至善</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/317");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_aswd.jpg">
                                <p>艾尚舞蹈艺术工作室</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/279");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_byjz.jpg">
                                <p>百艺艺术家政</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/222");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_cgtqd.jpg">
                                <p>承贵跆拳道</p>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_dfyx.jpg">
                                <p>东方艺校</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/290");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_dwjy.jpg">
                                <p>大卫美术教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/226");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_ffxn.jpg">
                                <p>非凡新娘</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/233");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_hc.jpg">
                                <p>汉成教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/219");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_hyptz.jpg">
                                <p>弘宇葡萄籽教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/196");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jht.jpg">
                                <p>金话筒</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/301");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jjg.jpg">
                                <p>杰杰高教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/308");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jjyj.jpg">
                                <p>伽镜瑜伽</p>
                            </a>
                        </li>
                        <li>
                            <a href="{url/site/brand_zone/id/323}" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jsyl.jpg">
                                <p>金色雨林</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/230");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jtyzy.jpg">
                                <p>京田幼稚园</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/235");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jypx.jpg">
                                <p>建业培训</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/227");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jytqd.jpg">
                                <p>技艺跆拳道</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/262");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_khjy.jpg">
                                <p>科汉教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/314");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_klnm.jpg">
                                <p>柠檬c快乐成长教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/229");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_klry.jpg">
                                <p>快乐日语</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/252");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_ldwd.jpg">
                                <p>灵动舞蹈</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/238");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_lmsx.jpg">
                                <p>龙门尚学</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/310");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_mjys.jpg">
                                <p>美匠艺术</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/294");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_mxjy.jpg">
                                <p>明呈教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/295");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_myyy.jpg">
                                <p>魔音现代音乐俱乐部</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/234");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_ppys.jpg">
                                <p>蓬皮儿国际创想艺术馆</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/296");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_qyss.jpg">
                                <p>青云私塾</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/221");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_rb.jpg">
                                <p>润贝成长探索中心</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/309");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_sks.jpg">
                                <p>萨克斯之家</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/292");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_vv.jpg">
                                <p>薇薇流行舞蹈</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/86");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_wt.jpg">
                                <p>湾堂</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/291");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_wxsy.jpg">
                                <p>文心书院</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/287");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_xwg.jpg">
                                <p>小王国</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/69");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_xwl.jpg">
                                <p>新未来（国际）教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/330");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_xxlys.jpg">
                                <p>西西里艺术中心</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/85");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_xxx.jpg">
                                <p>小新星国际教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/68");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_yhys.jpg">
                                <p>炎黄艺术培训学校</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/280");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_zl.jpg">
                                <p>众乐学堂</p>
                            </a>
                        </li>

                    </ul>
                </div>

            </div>
        </div>

        <a name="contact_us"></a>
        <div class="part part_contact">
            <div class="part_tit">
                <div class="t_con">
                    <h3>联系<em>我们</em></h3>
                    <p>CONTACT US</p>
                </div>
            </div>
            <div class="contact">
                <div class="map">
                    <div data-am-widget="map" class="am-map am-map-default" data-name="第三课" data-address="湖南省株洲市中心广场大汉希尔顿1栋2601号" data-longitude="" data-latitude="" data-scaleControl="" data-zoomControl="true" data-setZoom="17" data-icon="">
                        <div id="bd-map"></div>
                    </div>

                </div>
                <div class="contact_us">
                    <p class="position"><i class="am-icon-map-marker"></i> 地址：湖南省株洲市中心广场大汉希尔顿1栋2601号</p>
                    <p><i class="am-icon-qq"></i> QQ：2821518520</p>
                    <p><i class="am-icon-envelope "></i> 邮箱：disanke@dsanke.com</p>
                    <p><i class="am-icon-volume-control-phone"></i> 0731-28308258</p>
                    <p><i class="am-icon-weixin"></i> 微信：hnlxsh2017</p>
                    <p><i class="am-icon-bus"></i> 乘车线路：T2路、T18路、T21路、T17路、T48路、T68路、T42路、T28路、T35路、D168路、T40路、67路、T60路到中心广场下车，或乘公交T1路/T5路/T9路到口腔医院下车</p>
                </div>
            </div>
        </div>
    </div>
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
				<script type='text/javascript' src='/resource/public/assets/js/amazeui.min.js'></script>
<link href="/resource/public/assets/css/amazeui.min.css" rel="stylesheet" type="text/css" />
<link href="/resource/public/css/style.css" rel="stylesheet" type="text/css" />

<div id="intro" style="background-color:#fff;">
    <div class="intro_top"></div>
    <div class="intro_content">
        <div class="part part_info">
            <div class="part_tit">
                <div class="t_con">
                    <h3>企业<em>简介</em></h3>
                    <p>COMPANY PROFILE</p>
                </div>
            </div>
            <div class="company">
                <div class="company_left"></div>
                <div class="company_right">
                    <p>“第三课”是教育培训资源聚集的”互联网+教育培训”网络平台，具有教育资讯发布、信息交流、教育培训课程展示和文化产品交易的功能，以创新和多元的线上线下活动，为教育培训机构和家长、学生的互动交流创造积极的互动环境，协助合作教育培训机构宣传和招生，帮助家长和学生找到满意的教育培训机构与课程并参与学习。我们的目标是让做教育的人专心做教育，让受教育的人能更方便的受到良好的教育，形成一个教育培训机构、受教育者、教育网络平台三赢的局面。</p>
                    <p>“第一课”来自家庭，古有孟母育子，今有家庭教育，家庭给了孩子在这个世界的第一次学习机会，家庭教育对孩子未来的成长和今后的性格养成起到重要影响。</p>
                    <p>“第二课”来自校园，古有家学私塾，今有菁菁校园，学校教育可以让教育变得具有目的性，计划性，组织性和系统性。确保孩子的教育发展行在主路子上。</p>
                    <p>“第三课”来自社会，三生万物，社会教育提供比家和学校更加多元化的教学理念，更细分的课程设置，更精准的课堂训练，可以让学生学到家庭和课堂中学不到知识和技能，是家庭和课堂之外不可替代的必要补充。</p>
                    <p>“第三课”伴随每个人的成长。幼儿阶段，“第三课”是智慧启蒙，让你茁壮成长！学生年代，“第三课”是升学助力，让你升学无忧！成年时期，“第三课”是素质培养，让你卓尔不群！</p>
                    <p>“第三课”让你的人生与众不同！</p>
                </div>
            </div>
        </div>
        <div class="part part_train">
            <div class="part_tit">
                <div class="t_con">
                    <h3>培训<em>课程</em></h3>
                    <p>TRAINING COURSE</p>
                </div>
            </div>
            <div class="train">
            </div>
        </div>
        <div class="part part_advantage">
            <div class="part_tit">
                <div class="t_con">
                    <h3>平台<em>优势</em></h3>
                    <p>PLATFORM ADVANTAGE</p>
                </div>
            </div>
            <div class="advantage">
                <p>教育信息交流、和教育产品交易</p>
                <p>学校广告宣传和招生平台</p>
                <p>帮助家长和学生找到最合适的学校学习</p>
                <div class="img_advantage"></div>
            </div>
        </div>
        <div class="part part_partner">
            <div class="part_tit">
                <div class="t_con">
                    <h3>合作<em>伙伴</em></h3>
                    <p>COOPERATIVE PARTNER</p>
                </div>
            </div>
            <div class="partner">
                <div data-am-widget="slider" class="am-slider am-slider-default" data-am-slider='{"animation":"slide","animationLoop":true,"itemWidth":167,"itemMargin":34,"slideshow": true,"move":1,"directionNav":false,"controlNav":false,"slideshowSpeed":3000,"pauseOnHover":true}' >
                    <ul class="am-slides">
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/303");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_ctl.jpg">
                                <p>春天里艺术学校</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/282");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_mt.jpg">
                                <p>梦田艺术教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/241");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_ql.jpg">
                                <p>启乐棒球</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/249");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_qcjy.jpg">
                                <p>奇创乐高</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/253");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jdjy.jpg">
                                <p>君道教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/338");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_yzs.jpg">
                                <p>艺至善</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/317");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_aswd.jpg">
                                <p>艾尚舞蹈艺术工作室</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/279");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_byjz.jpg">
                                <p>百艺艺术家政</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/222");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_cgtqd.jpg">
                                <p>承贵跆拳道</p>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_dfyx.jpg">
                                <p>东方艺校</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/290");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_dwjy.jpg">
                                <p>大卫美术教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/226");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_ffxn.jpg">
                                <p>非凡新娘</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/233");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_hc.jpg">
                                <p>汉成教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/219");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_hyptz.jpg">
                                <p>弘宇葡萄籽教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/196");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jht.jpg">
                                <p>金话筒</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/301");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jjg.jpg">
                                <p>杰杰高教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/308");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jjyj.jpg">
                                <p>伽镜瑜伽</p>
                            </a>
                        </li>
                        <li>
                            <a href="{url/site/brand_zone/id/323}" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jsyl.jpg">
                                <p>金色雨林</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/230");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jtyzy.jpg">
                                <p>京田幼稚园</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/235");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jypx.jpg">
                                <p>建业培训</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/227");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_jytqd.jpg">
                                <p>技艺跆拳道</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/262");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_khjy.jpg">
                                <p>科汉教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/314");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_klnm.jpg">
                                <p>柠檬c快乐成长教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/229");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_klry.jpg">
                                <p>快乐日语</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/252");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_ldwd.jpg">
                                <p>灵动舞蹈</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/238");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_lmsx.jpg">
                                <p>龙门尚学</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/310");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_mjys.jpg">
                                <p>美匠艺术</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/294");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_mxjy.jpg">
                                <p>明呈教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/295");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_myyy.jpg">
                                <p>魔音现代音乐俱乐部</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/234");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_ppys.jpg">
                                <p>蓬皮儿国际创想艺术馆</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/296");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_qyss.jpg">
                                <p>青云私塾</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/221");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_rb.jpg">
                                <p>润贝成长探索中心</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/309");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_sks.jpg">
                                <p>萨克斯之家</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/292");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_vv.jpg">
                                <p>薇薇流行舞蹈</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/86");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_wt.jpg">
                                <p>湾堂</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/291");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_wxsy.jpg">
                                <p>文心书院</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/287");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_xwg.jpg">
                                <p>小王国</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/69");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_xwl.jpg">
                                <p>新未来（国际）教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/330");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_xxlys.jpg">
                                <p>西西里艺术中心</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/85");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_xxx.jpg">
                                <p>小新星国际教育</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/68");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_yhys.jpg">
                                <p>炎黄艺术培训学校</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/280");?>" target="_blank">
                                <img src="<?php echo IUrl::creatUrl("")."resource";?>/public/logo/pic_zl.jpg">
                                <p>众乐学堂</p>
                            </a>
                        </li>

                    </ul>
                </div>

            </div>
        </div>

        <a name="contact_us"></a>
        <div class="part part_contact">
            <div class="part_tit">
                <div class="t_con">
                    <h3>联系<em>我们</em></h3>
                    <p>CONTACT US</p>
                </div>
            </div>
            <div class="contact">
                <div class="map">
                    <div data-am-widget="map" class="am-map am-map-default" data-name="第三课" data-address="湖南省株洲市中心广场大汉希尔顿1栋2601号" data-longitude="" data-latitude="" data-scaleControl="" data-zoomControl="true" data-setZoom="17" data-icon="">
                        <div id="bd-map"></div>
                    </div>

                </div>
                <div class="contact_us">
                    <p class="position"><i class="am-icon-map-marker"></i> 地址：湖南省株洲市中心广场大汉希尔顿1栋2601号</p>
                    <p><i class="am-icon-qq"></i> QQ：2821518520</p>
                    <p><i class="am-icon-envelope "></i> 邮箱：disanke@dsanke.com</p>
                    <p><i class="am-icon-volume-control-phone"></i> 0731-28308258</p>
                    <p><i class="am-icon-weixin"></i> 微信：hnlxsh2017</p>
                    <p><i class="am-icon-bus"></i> 乘车线路：T2路、T18路、T21路、T17路、T48路、T68路、T42路、T28路、T35路、D168路、T40路、67路、T60路到中心广场下车，或乘公交T1路/T5路/T9路到口腔医院下车</p>
                </div>
            </div>
        </div>
    </div>
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


