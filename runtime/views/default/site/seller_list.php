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
		<?php $seo_data=array(); $site_config=new Config('site_config');?>

<?php $seo_data['title'] = '商家列表';?>

<?php $seo_data['title'].="_".$site_config->name?>

<?php $seo_data['keywords']=$this->catRow['keywords']?>

<?php $seo_data['description']=$this->catRow['descript']?>

<?php seo::set($seo_data);?>


<style>
.searchbox{position:relative;z-index:14;display:inline;float:left;width:295px;height:29px;margin-left:28px;margin-left:0px;border:1px solid #038bd0;background:#fff;border-radius: 3px;}

	.searchbox input{border:none;background:none;vertical-align:top}

		.searchbox input.text{width:210px;height:15px;margin-top:4px;padding:3px 5px 0 11px;color:#828282}

		.searchbox input.btn{width:65px;height:29px;padding:7px 0 9px;padding:8px 0\9;cursor:pointer;text-align:center;color:#fff;background:#038bd0;border:1px solid #038bd0;border-radius:0 3px 3px 0; }
.display_title{border: 1px solid #ccc;background:#f2f2f2;}
		.display_title ul li{position:relative;float:left;height:31px;line-height:31px;margin:0 0 0 6px;background:#dedede;border-radius:3px 3px 0 0;}

		.display_title ul li.current{background:#038bd0;border-radius:3px 3px 0 0;}

			.display_title ul li a{padding:0 15px 0 15px;font-size:14px;font-weight:bold;text-decoration:none;color:#666;}

			.display_title a.hover{text-decoration:none}

			.display_title ul li.current a{color:##038bd0;line-height:31px;}

				.display_title ul li a span{margin:0 4px;padding:0 7px 0 0;padding:0 4px 0 0\9;background:url(../images/front/sprites_2.gif) -25px -180px no-repeat;}

				.display_title ul li.current a span{background-position:-36px -180px;}

				.display_title ul li.current a span.desc{background-position:-41px -198px}
dl.sorting{position:relative;width:auto;border-bottom:1px solid #dedede;padding:5px 60px 3px 0;text-align:left;overflow:hidden;}
				dl.sorting dd{padding-left:145px;    line-height: 24px;}

				dl.sorting dd a{display:inline-block;margin:2px 5px 0;padding:0 3px;_padding-top:2px}

				dl.sorting dd a:link,dl.sorting dd a:visited{color:#666;}

				dl.sorting dd a.nolimit{position:absolute;top:6px;left:100px;line-height:22px;}

				dl.sorting dd a.current{margin-bottom:-2px;line-height:11px;padding: 5px 8px 3px;border-radius: 2px;font-weight:bold;background:#038bd0;text-decoration:none;_padding-top:3px;}

				dl.sorting dd a.current:link,dl.sorting dd a.current:visited,dl.sorting dd a.current:hover,dl.sorting dd a.current:active{color:#fff;}
.display_title{position:relative;z-index:10;height:35px;border-bottom:2px solid #038bd0;padding-left:5px;_width:745px;overflow:hidden}
input.mini {line-height: 21px;}

/*列表 */
.display_list2 ul { padding-left: 8px; }
.display_list2 li { float: left; width: 22%; border: 1px solid #ccc; margin-left: 2%; margin-top: 15px; }
.display_list2 li .pic { width: 90%; margin: 0px auto; height: 160px; overflow: hidden; margin-top: 8px; overflow: hidden; }
.display_list2 li .pic img { max-width: 100%; }
.display_list2 li .t_left { float: left; margin-left: 10px; }
.display_list2 li h3.title a{font-size:14px;font-weight:normal;color:#f90;line-height: 30px;}
.display_list2 li .t_right { float: right; margin-right: 13px; }
.display_list2 li .seller_info { height: 25px; line-height: 25px;color:#666; }

		/* pages */

		.pages_bar{text-align:right;color:#444;padding-top: 8px; padding-bottom: 6px;}

			.pages_bar a,.pages_bar span{display:inline-block;height:17px;border:1px solid #d5d5d5;margin-right:6px;padding:3px 10px 3px;text-align:center;color:#1a66b3;font-weight:bold;-moz-border-radius:3px;-khtml-border-radius:3px;-webkit-border-radius:3px;border-radius:3px}

			.pages_bar a.current_page{border:1px solid #038bd0;background-color:#038bd0;color:#fff}

			.pages_bar span{color:#878787}

		.box .pages_bar{margin:5px 20px 25px}
		.display_list2 li .title { border-bottim: 0px;}
</style>



<div class="position">

	<span>您当前的位置：</span>

	<a href="<?php echo IUrl::creatUrl("");?>">首页</a> >> 教学机构

</div>



<div class="wrapper clearfix container_2">

		<div class="cont">
				<!--分类-->
                <?php if($category_list){?>
                <dl class="sorting">
					<dt>类别：</dt>
					<dd id='price_dd'>
						<a class="nolimit <?php if(!$category_id){?>current<?php }?>" href="<?php echo search_goods::searchUrl('category_id','');?>">不限</a>
						<?php foreach($category_list as $key => $item){?>
							<a href="<?php echo search_goods::searchUrl('category_id',$item['id']);?>" <?php if($category_id == $item['id']){?>class='current'<?php }?> id="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a>
						<?php }?>
					</dd>
                </dl>
				<?php }?>
                <!--分类-->
				<!--课程区域-->
                <?php if($area_list){?>
                <dl class="sorting">
					<dt>区域：</dt>
					<dd id='price_dd'>
						<a class="nolimit <?php if(!$area_id){?>current<?php }?>" href="<?php echo search_goods::searchUrl('area','');?>">不限</a>
						<?php foreach($area_list as $key => $item){?>
							<a href="<?php echo search_goods::searchUrl('area',$item['area_id']);?>" <?php if($area_id == $item['area_id']){?>class='current'<?php }?> id="<?php echo isset($item['area_id'])?$item['area_id']:"";?>"><?php echo isset($item['area_name'])?$item['area_name']:"";?></a>
						<?php }?>
					</dd>
                </dl>
				<?php }?>
                <!--课程区域-->

				<!--课程属性-->
				<?php if($attr_list['value']){?>
				<dl class="sorting" style="border-bottom:0;">
					<dt>内容：</dt>
					<dd id='attr_dd'>
						<a class="nolimit <?php if($attr ==''){?>current<?php }?>" href="<?php echo search_goods::searchUrl('attr','');?>">不限</a>
						<?php foreach($attr_list['value'] as $key => $item){?>
							<a href="<?php echo search_goods::searchUrl('attr',$item);?>" <?php if($attr_id==$key && $attr != ''){?>class="current"<?php }?>><?php echo isset($item)?$item:"";?></a>
						<?php }?>
					</dd>
				</dl>
				<?php }?>
				<!--课程属性-->
			</div>
		</div>
		<!--条件检索-->



		<!--排序方式-->
		<div class="display_title">
			<span class="f_l">排序：</span>
			<ul>
				<?php foreach($order_info as $key => $item){?>
				<li class="<?php if($order == $key || $order == $key . '_toggle'){?>current<?php }?>">
					<a href="<?php if($order == $key){?><?php echo search_goods::searchUrl('order',$key.'_toggle');?><?php }else{?><?php echo search_goods::searchUrl('order',$key);?><?php }?>"><?php echo isset($item)?$item:"";?></a>
				</li>
				<?php }?>
			</ul>
		</div>
        <!--排序方式-->

		<!--商家展示-->
		<?php if($list){?>
		<ul class="display_list2 clearfix m_10">
			<?php foreach($list as $key => $item){?>
			<li class="clearfix <?php echo search_goods::getListShow(IFilter::act(IReq::get('show_type')));?>">
				<div class="pic">
					<a title="<?php echo isset($item['true_name'])?$item['true_name']:"";?>" href="<?php echo IUrl::creatUrl("/site/seller/id/".$item['id']."");?>" target="_blank">
						<img src="<?php echo IUrl::creatUrl("")."".$item['logo']."";?>" width="237" height="160" alt="<?php echo isset($item['true_name'])?$item['true_name']:"";?>" title="<?php echo isset($item['true_name'])?$item['true_name']:"";?>" />
					</a>
				</div>
				<h3 class="title" style="border-bottom: 0px;"><a title="<?php echo isset($item['true_name'])?$item['true_name']:"";?>" href="<?php echo IUrl::creatUrl("/site/seller/id/".$item['id']."");?>" target="_blank"><?php echo isset($item['true_name'])?$item['true_name']:"";?></a></h3>
                <div class="seller_info" style="height: 20px;line-height: 20px; padding: 6px 0">
                	<div class="t_left" style="width: 64%;overflow: hidden;height: 20px;text-align: left;">
                    	主要课程：<?php if($item['category']){?><?php echo isset($item['category'])?$item['category']:"";?><?php }else{?>暂无<?php }?>
                    </div>
                    <div class="t_right" style="width: 27%;overflow: hidden;height: 20px;">
                    	总销量：<?php echo isset($item['sale'])?$item['sale']:"";?>
                    </div>
                </div>
			</li>
			<?php }?>
		</ul>
		<?php echo isset($page_bar)?$page_bar:"";?>

		<?php }else{?>
		<p class="display_list mt_10" style='margin-top:50px;margin-bottom:50px'>
			<strong class="gray f14">对不起，没有找到相关商家</strong>
		</p>
		<?php }?>
		<!--商家展示-->

	</div>

</div>



<script type='text/javascript'>

$(document).ready(function(){
	$('.display_list li .pic').hover(function(){
		$(this).addClass('active');
	}, function(){
		$(this).removeClass('active');
	});
});

//价格跳转




//筛选条件按钮高亮

jQuery(function(){

	<?php 

		$brand = IFilter::act(IReq::get('brand'),'int');

	?>



	<?php if($brand){?>

	$('#brand_dd>a').removeClass('current');

	$('#brand_<?php echo isset($brand)?$brand:"";?>').addClass('current');

	<?php }?>



	<?php $tempArray = IFilter::act(IReq::get('attr'),'url')?>

	<?php if($tempArray){?>

		<?php $json = JSON::encode(array_map('md5',$tempArray))?>

		var attrArray = <?php echo isset($json)?$json:"";?>;

		for(val in attrArray)

		{

			if(attrArray[val])

			{

				$('#attr_dd_'+val+'>a').removeClass('current');

				document.getElementById('attr_'+val+'_'+attrArray[val]).className = 'current';

			}

		}

	<?php }?>

});

</script>

	</div>
	<?php }else{?>
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
				<?php $seo_data=array(); $site_config=new Config('site_config');?>

<?php $seo_data['title'] = '商家列表';?>

<?php $seo_data['title'].="_".$site_config->name?>

<?php $seo_data['keywords']=$this->catRow['keywords']?>

<?php $seo_data['description']=$this->catRow['descript']?>

<?php seo::set($seo_data);?>


<style>
.searchbox{position:relative;z-index:14;display:inline;float:left;width:295px;height:29px;margin-left:28px;margin-left:0px;border:1px solid #038bd0;background:#fff;border-radius: 3px;}

	.searchbox input{border:none;background:none;vertical-align:top}

		.searchbox input.text{width:210px;height:15px;margin-top:4px;padding:3px 5px 0 11px;color:#828282}

		.searchbox input.btn{width:65px;height:29px;padding:7px 0 9px;padding:8px 0\9;cursor:pointer;text-align:center;color:#fff;background:#038bd0;border:1px solid #038bd0;border-radius:0 3px 3px 0; }
.display_title{border: 1px solid #ccc;background:#f2f2f2;}
		.display_title ul li{position:relative;float:left;height:31px;line-height:31px;margin:0 0 0 6px;background:#dedede;border-radius:3px 3px 0 0;}

		.display_title ul li.current{background:#038bd0;border-radius:3px 3px 0 0;}

			.display_title ul li a{padding:0 15px 0 15px;font-size:14px;font-weight:bold;text-decoration:none;color:#666;}

			.display_title a.hover{text-decoration:none}

			.display_title ul li.current a{color:##038bd0;line-height:31px;}

				.display_title ul li a span{margin:0 4px;padding:0 7px 0 0;padding:0 4px 0 0\9;background:url(../images/front/sprites_2.gif) -25px -180px no-repeat;}

				.display_title ul li.current a span{background-position:-36px -180px;}

				.display_title ul li.current a span.desc{background-position:-41px -198px}
dl.sorting{position:relative;width:auto;border-bottom:1px solid #dedede;padding:5px 60px 3px 0;text-align:left;overflow:hidden;}
				dl.sorting dd{padding-left:145px;    line-height: 24px;}

				dl.sorting dd a{display:inline-block;margin:2px 5px 0;padding:0 3px;_padding-top:2px}

				dl.sorting dd a:link,dl.sorting dd a:visited{color:#666;}

				dl.sorting dd a.nolimit{position:absolute;top:6px;left:100px;line-height:22px;}

				dl.sorting dd a.current{margin-bottom:-2px;line-height:11px;padding: 5px 8px 3px;border-radius: 2px;font-weight:bold;background:#038bd0;text-decoration:none;_padding-top:3px;}

				dl.sorting dd a.current:link,dl.sorting dd a.current:visited,dl.sorting dd a.current:hover,dl.sorting dd a.current:active{color:#fff;}
.display_title{position:relative;z-index:10;height:35px;border-bottom:2px solid #038bd0;padding-left:5px;_width:745px;overflow:hidden}
input.mini {line-height: 21px;}

/*列表 */
.display_list2 ul { padding-left: 8px; }
.display_list2 li { float: left; width: 22%; border: 1px solid #ccc; margin-left: 2%; margin-top: 15px; }
.display_list2 li .pic { width: 90%; margin: 0px auto; height: 160px; overflow: hidden; margin-top: 8px; overflow: hidden; }
.display_list2 li .pic img { max-width: 100%; }
.display_list2 li .t_left { float: left; margin-left: 10px; }
.display_list2 li h3.title a{font-size:14px;font-weight:normal;color:#f90;line-height: 30px;}
.display_list2 li .t_right { float: right; margin-right: 13px; }
.display_list2 li .seller_info { height: 25px; line-height: 25px;color:#666; }

		/* pages */

		.pages_bar{text-align:right;color:#444;padding-top: 8px; padding-bottom: 6px;}

			.pages_bar a,.pages_bar span{display:inline-block;height:17px;border:1px solid #d5d5d5;margin-right:6px;padding:3px 10px 3px;text-align:center;color:#1a66b3;font-weight:bold;-moz-border-radius:3px;-khtml-border-radius:3px;-webkit-border-radius:3px;border-radius:3px}

			.pages_bar a.current_page{border:1px solid #038bd0;background-color:#038bd0;color:#fff}

			.pages_bar span{color:#878787}

		.box .pages_bar{margin:5px 20px 25px}
		.display_list2 li .title { border-bottim: 0px;}
</style>



<div class="position">

	<span>您当前的位置：</span>

	<a href="<?php echo IUrl::creatUrl("");?>">首页</a> >> 教学机构

</div>



<div class="wrapper clearfix container_2">

		<div class="cont">
				<!--分类-->
                <?php if($category_list){?>
                <dl class="sorting">
					<dt>类别：</dt>
					<dd id='price_dd'>
						<a class="nolimit <?php if(!$category_id){?>current<?php }?>" href="<?php echo search_goods::searchUrl('category_id','');?>">不限</a>
						<?php foreach($category_list as $key => $item){?>
							<a href="<?php echo search_goods::searchUrl('category_id',$item['id']);?>" <?php if($category_id == $item['id']){?>class='current'<?php }?> id="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a>
						<?php }?>
					</dd>
                </dl>
				<?php }?>
                <!--分类-->
				<!--课程区域-->
                <?php if($area_list){?>
                <dl class="sorting">
					<dt>区域：</dt>
					<dd id='price_dd'>
						<a class="nolimit <?php if(!$area_id){?>current<?php }?>" href="<?php echo search_goods::searchUrl('area','');?>">不限</a>
						<?php foreach($area_list as $key => $item){?>
							<a href="<?php echo search_goods::searchUrl('area',$item['area_id']);?>" <?php if($area_id == $item['area_id']){?>class='current'<?php }?> id="<?php echo isset($item['area_id'])?$item['area_id']:"";?>"><?php echo isset($item['area_name'])?$item['area_name']:"";?></a>
						<?php }?>
					</dd>
                </dl>
				<?php }?>
                <!--课程区域-->

				<!--课程属性-->
				<?php if($attr_list['value']){?>
				<dl class="sorting" style="border-bottom:0;">
					<dt>内容：</dt>
					<dd id='attr_dd'>
						<a class="nolimit <?php if($attr ==''){?>current<?php }?>" href="<?php echo search_goods::searchUrl('attr','');?>">不限</a>
						<?php foreach($attr_list['value'] as $key => $item){?>
							<a href="<?php echo search_goods::searchUrl('attr',$item);?>" <?php if($attr_id==$key && $attr != ''){?>class="current"<?php }?>><?php echo isset($item)?$item:"";?></a>
						<?php }?>
					</dd>
				</dl>
				<?php }?>
				<!--课程属性-->
			</div>
		</div>
		<!--条件检索-->



		<!--排序方式-->
		<div class="display_title">
			<span class="f_l">排序：</span>
			<ul>
				<?php foreach($order_info as $key => $item){?>
				<li class="<?php if($order == $key || $order == $key . '_toggle'){?>current<?php }?>">
					<a href="<?php if($order == $key){?><?php echo search_goods::searchUrl('order',$key.'_toggle');?><?php }else{?><?php echo search_goods::searchUrl('order',$key);?><?php }?>"><?php echo isset($item)?$item:"";?></a>
				</li>
				<?php }?>
			</ul>
		</div>
        <!--排序方式-->

		<!--商家展示-->
		<?php if($list){?>
		<ul class="display_list2 clearfix m_10">
			<?php foreach($list as $key => $item){?>
			<li class="clearfix <?php echo search_goods::getListShow(IFilter::act(IReq::get('show_type')));?>">
				<div class="pic">
					<a title="<?php echo isset($item['true_name'])?$item['true_name']:"";?>" href="<?php echo IUrl::creatUrl("/site/seller/id/".$item['id']."");?>" target="_blank">
						<img src="<?php echo IUrl::creatUrl("")."".$item['logo']."";?>" width="237" height="160" alt="<?php echo isset($item['true_name'])?$item['true_name']:"";?>" title="<?php echo isset($item['true_name'])?$item['true_name']:"";?>" />
					</a>
				</div>
				<h3 class="title" style="border-bottom: 0px;"><a title="<?php echo isset($item['true_name'])?$item['true_name']:"";?>" href="<?php echo IUrl::creatUrl("/site/seller/id/".$item['id']."");?>" target="_blank"><?php echo isset($item['true_name'])?$item['true_name']:"";?></a></h3>
                <div class="seller_info" style="height: 20px;line-height: 20px; padding: 6px 0">
                	<div class="t_left" style="width: 64%;overflow: hidden;height: 20px;text-align: left;">
                    	主要课程：<?php if($item['category']){?><?php echo isset($item['category'])?$item['category']:"";?><?php }else{?>暂无<?php }?>
                    </div>
                    <div class="t_right" style="width: 27%;overflow: hidden;height: 20px;">
                    	总销量：<?php echo isset($item['sale'])?$item['sale']:"";?>
                    </div>
                </div>
			</li>
			<?php }?>
		</ul>
		<?php echo isset($page_bar)?$page_bar:"";?>

		<?php }else{?>
		<p class="display_list mt_10" style='margin-top:50px;margin-bottom:50px'>
			<strong class="gray f14">对不起，没有找到相关商家</strong>
		</p>
		<?php }?>
		<!--商家展示-->

	</div>

</div>



<script type='text/javascript'>

$(document).ready(function(){
	$('.display_list li .pic').hover(function(){
		$(this).addClass('active');
	}, function(){
		$(this).removeClass('active');
	});
});

//价格跳转




//筛选条件按钮高亮

jQuery(function(){

	<?php 

		$brand = IFilter::act(IReq::get('brand'),'int');

	?>



	<?php if($brand){?>

	$('#brand_dd>a').removeClass('current');

	$('#brand_<?php echo isset($brand)?$brand:"";?>').addClass('current');

	<?php }?>



	<?php $tempArray = IFilter::act(IReq::get('attr'),'url')?>

	<?php if($tempArray){?>

		<?php $json = JSON::encode(array_map('md5',$tempArray))?>

		var attrArray = <?php echo isset($json)?$json:"";?>;

		for(val in attrArray)

		{

			if(attrArray[val])

			{

				$('#attr_dd_'+val+'>a').removeClass('current');

				document.getElementById('attr_'+val+'_'+attrArray[val]).className = 'current';

			}

		}

	<?php }?>

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


