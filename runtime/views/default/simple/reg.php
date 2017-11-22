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
		<?php $seo_data=array(); $site_config=new Config('site_config');$site_config=$site_config->getInfo();?>

<?php $seo_data['title']="用户注册_".$site_config['name']?>

<?php $callback = IReq::get('callback') ? IFilter::clearUrl(IReq::get('callback')) : IUrl::getRefRoute()?>

<link href="<?php echo $this->getWebSkinPath()."css/register.css";?>" rel="stylesheet" type="text/css" />

<style>
body{
background:url(<?php echo $this->getWebSkinPath()."/images/reg_bg.jpg";?>);
 }
</style>


<script language="javascript">

var _callback = '<?php if($callback){?><?php echo isset($callback)?$callback:"";?><?php }?>';

var _reg_ajax_url = '<?php echo IUrl::creatUrl("/simple/reg_pc_ajax");?>';

var _ucenter_url = '<?php echo IUrl::creatUrl("/ucenter/index");?>';

var _send_sms_url = '<?php echo IUrl::creatUrl("/simple/send_reg_sms");?>';

var _username = '<?php echo $this->username;?>';

</script>



<div class="wrapper clearfix"  style="margin-top:20px;"  >

	<div class="wrap_box" >


		<h3 class="notice"><a href="http://www.lelele999.com"></a></h3>

		<p class="tips"><span class="gray f_r">已有<?php echo $siteConfig->name;?>帐号？请点<a class="orange bold" href="<?php echo IUrl::creatUrl("/simple/login");?>">这里</a>登录</span><!-- 欢迎来到我们的网站，如果您是新用户，请填写下面的表单进行注册 --></p>

		<div class="box clearfix" >

			<form action='<?php echo IUrl::creatUrl("/simple/reg_act");?>' method='post' id="mobileWay" >

				<input type="hidden" name='callback' />
				<div class="form_list">
					<h2>用户注册</h2>
					<ul class="form_table" >
						<li class="sanzi">
							<em  style="font-style:normal;font-size:14px;">用户名：</em>
							<input class="gray" name='username' id="username" pattern="required" type="text"  />
							<label>填写用户名</label>
						</li>
						<li>
							<em style="font-style:normal;font-size:14px;">设置密码：</em>
							<input class="gray" type="password" name='password' id="password" pattern="^\S{6,32}$" bind='repassword' alt='填写6-32个字符' />
							<label>填写登录密码，6-32个字符</label>
						</li>
						<!-- <li> -->
							<!-- <em style="font-style:normal;font-size:14px;">确认密码：</em> -->
							<!-- <input class="gray" type="password" name='repassword' id="repassword" pattern="^\S{6,32}$" bind='password' alt='重复上面所填写的密码' /> -->
							<!-- <label>重复上面所填写的密码</label> -->
						<!-- </li> -->
						<li class="sanzi">
							<em style="font-style:normal;font-size:14px;">手机号：</em>
							<input class="gray" type="text" name='mobile' id="mobile" pattern="mobi" alt="请输入正确的手机号码" />
							<input type="button" class="send_sms" value="获取验证码" onclick="sendMessage();"/><br /><div class="send_sms_notice">验证码已发送到您的手机，请查收</div>
						</li>
						<li class="wuzi">
							<em style="font-style:normal;font-size:14px;">手机验证码：</em>
							<input name="mobile_code" id="mobile_code" class="gray_s" type="text" pattern="required" alt="请输入短信息中验证码" />
						</li>
						<!-- <li class="sanzi">
							<em style="font-style:normal;font-size:14px;">验证码：</em>
							<input type='text' class='gray_s' name='captcha' id="captcha" pattern='^\w{5,10}$' alt='填写下面图片所示的字符' />
							<img src='<?php echo IUrl::creatUrl("/simple/getCaptcha");?>' id='captchaImg' />
							<span class="light_gray">看不清？<a class="link" href="javascript:changeCaptcha('<?php echo IUrl::creatUrl("/simple/getCaptcha");?>'); ">换一张</a></span>
						</li> -->
						<li class="sanzi">
							<em style="font-style:normal;font-size:14px;">推广码：</em>
							<input name="promo_code" id="promo_code" class="gray_s" type="text" />
						</li>
					</ul>

					<div class="agree"><input type="checkbox" name="agree" checked="checked"> 阅读并同意<a href="javascript:void(0);">《第三课用户注册协议》</a></div>

					<div class="reg_sub">
						<input onclick="onReg();" class="submit_reg" type="button" value="提交" />
					</div>
				</div>



			</form>

			<div class="agreement gray">
                  <span class="layui-layer-setwin">
                   </span>






<p>第一条	协议内容及生效：

    1.1 本协议内容包括协议正文及所有乐享网已经发布的或将来可能发布的各类规则。所有规则为协议不可分割的一部分，与协议正文具有同等法律效力。

1.2 您在注册乐享网账户时点击 “同意以下条款，提交”即视为您接受本协议及各类规则，并同意受其约束。您应当在使用乐享网服务之前认真阅读全部协议内容并确保完全理解协议内容，如您对协议有任何疑问的，应向乐享网咨询。但无论您事实上是否在使用乐享网服务之前认真阅读了本协议内容，只要您注册、正在或者继续使用乐享网服务，则视为接受本协议。

1.3 商户签署或在线接受本协议并不导致本协议立即生效，经过乙方审核通过后，本协议即在商户和乙方之间产生法律效力。

1.4 您承诺接受并遵守本协议的约定。如果您不同意本协议的约定，您应立即停止注册程序或停止使用乐享网服务。

1.5 乐享网有权根据需要不时地制订、修改本协议及/或各类规则，并以网站公示的方式进行公告。变更后的协议和规则一经在网站公布后，立即自动生效。乐享网的最新的协议和规则以及网站公告可供您随时登陆查阅，您也应当经常性的登陆查阅最新的协议和规则以及网站公告以了解乐享网最新动态。如您不同意相关变更，应当立即停止使用乐享网服务。您继续使用服务的，即表示您接受经修订的协议和规则。本协议和规则（及其各自的不时修订）条款具有可分割性，任一条款被视为违法、无效、被撤销、变更或因任何理由不可执行，并不影响其他条款的合法性、有效性和可执行性。

1.6 本协议在您注册乐享网账户时点击 “同意以下条款，提交”即生效。</p>

<p>第二条  定义

2.1 “lelele999.com（乐享网）”：指由湖南乐享生活租赁服务有限公司提供技术支持和服务的电子商务平台网站，网址为www.lelele999.com（或依湖南乐享生活租赁服务有限公司根据业务需要不时修改的URL）。

2.2 “乐享生活电子商务交易平台”：指湖南乐享生活租赁服务有限公司供用户发布或查询商品信息，进行信息交流，达成交易意向及向用户提供其他与交易有关的辅助信息服务的空间。

2.3 “用户及用户注册”：接受并同意本协议全部条款及乐享网发布的其他全部服务条款和操作规则、通过乐享网进行交易的乐享网注册用户。用户注册是指用户登录乐享网（www.lelele999.com），按要求填写相关信息，且在线阅读并确认接收或书面签署本协议以最终激活其乐享服务账户的过程。

2.4 “乐享服务账户”：即用户完成用户注册流程而获得的其将在使用服务的过程中必须与自设的账户密码共同使用的用户名，又称“乐享用户名”。用户应妥善保管其乐享服务账户及密码信息，用户不得以任何形式擅自转让或授权他人使用自己的乐享服务账户。

2.5 “商家”：通过乐享网发布商品/服务信息、向用户提供商品/服务的自然人、法人和其他组织。</p>

<p>第三条  用户注册

3.1 注册资格

您应当是具备完全民事权利能力和完全民事行为能力的自然人、法人或其他组织。若您不具备前述主体资格，则您及您的监护人应承担因此而导致的一切后果，且乐享网有权注销（永久冻结）您的乐享网账户，并向您及您的监护人索偿或者追偿。若您不具备前述主体资格，则需要监护人同意您方可注册成为乐享网用户，否则您和您的监护人应承担因此而导致的一切后果，且乐享网有权注销（永久冻结）您的乐享网账户，并向您及您的监护人索偿或者追偿。

3.2 注册流程

3.2.1 用户同意根据乐享网用户注册页面的要求提供有效电子邮箱、所在城市等信息，设置乐享网账号及密码，用户应确保所提供全部信息的真实性、完整性和准确性。

3.2.2 用户在注册时有权选择是否订阅乐享网发送的关于商品信息的电子邮件和/或短信息。

3.2.3 用户合法、完整并有效提供注册所需信息的，有权获得乐享网账号和密码，乐享网账号和密码用于用户在乐享网进行用户登录。

3.2.4 用户获得美乐享网账号及密码时视为用户注册成功，用户同意接收乐享网发送的与乐享网网站管理、运营相关的电子邮件和短消息。

3.3 账户

3.3.1 在您签署本协议，完成用户注册程序或以其他乐享网允许的方式实际使用乐享网服务时，乐享网会向您提供唯一编号的乐享服务账户（以下亦称账户）。

3.3.2 您可以对账户设置用户名和密码，通过该用户名密码登陆乐享网平台。您设置的用户名不得侵犯或涉嫌侵犯他人合法权益。

    3.3.3 您应对您的账户和密码的安全，以及对通过您的账户和密码实施的行为负责。除非经过正当法律程序，且征得乐享网的同意，否则，账户和密码不得以任何方式转让、赠与或继承。如果发现任何人不当使用您的账户或有任何其他可能危及您的账户安全的情形时，您应当立即以有效方式通知乐享网，要求乐享网暂停相关服务。您理解乐享网对您的请求采取行动需要合理时间，乐享网对在采取行动前已经产生的后果（包括但不限于您的任何损失）不承担任何责任，但乐享网未能在合理时间内采取行动的情况除外。您认可您在注册、使用乐享网服务过程中提供、形成的数据等相关信息的所有权及其他相关权利属于乐享网，乐享网有权使用上述信息。</p>

<p>第四条  用户服务

乐享网为用户通过乐享网进行网络交易活动提供网络交易平台服务，目前乐享网对用户提供的乐享网网络交易平台服务为免费服务，但乐享网保留未来对乐享网网络交易平台服务收取服务费用的权利。

4.1 服务内容

4.1.1 用户有权在乐享网浏览商品/服务的信息、有权通过乐享网与商家达成订单、支付价款、获得电子消费凭证（如有）等。

4.1.2 用户有权在乐享网查看其乐享网账号下的信息，有权应用乐享网提供的功能进行操作。

4.1.3 用户有权按照乐享网发布的活动规则参与乐享网组织的网站活动。

4.1.4 乐享网承诺为用户提供的其他服务。

4.2 服务规则

用户承诺遵守下列乐享网服务规则：

4.2.1 用户应当遵守法律法规、规章、规范性文件及政策要求的规定，不得在乐享网或利用乐享网服务从事非法或其他损害乐享网或第三方权益的活动，如发送或接收任何违法、违规、违反公序良俗、侵犯他人权益的信息，发送或接收传销材料或存在其他危害的信息或言论，未经乐享网授权使用或伪造乐享网电子邮件题头信息等。

4.2.2用户通过乐享网与商家进行交易时，应当遵守本协议约定及乐享网发布的其他关于交易的服务条款和操作规则的全部规定。

4.2.3用户在乐享网对商品/服务进行评价时应当根据实际情况如实进行评价。

4.2.4 用户应当按照乐享网发布的规则参加乐享网抽奖等活动，遵守活动秩序。

4.2.5 如果用户提供给乐享网的资料有变更，请及时通知乐享网做出相应的修改。

4.2.6用户不得出现恶意注册恶意点击等行为。

4.2.7用户应及时使用自己的乐享网账户中的返利金额。返利金额有使用期限，从用户在消费或各类活动中获得的返利金额进入用户的乐享网帐户开始起算。超过有效期仍未及时使用的，则此部分过期返利金额将逾期失效并作归零处理。返利金额有效期到期之日一个月前，乐享网将会通过用户登记注册的联系方式提前一个月通知用户尽快消费即将到期的返利金额。返利金额有效期到期后，乐享网仍然给予用户1个月的宽限期，在此宽限期内用户可申请消费已经到期的返利金额。宽限期届满仍未消费的，此部分过期返利金额将正式逾期失效并作归零处理。

    4.2.8 乐享网用户帐户如果两年内无登陆记录，将被视为休眠账户作冻结处理。用户账户自冻结第二个月开始，乐享网保留在每月1日自动扣除已经超出有效期的返利金额部分的权利。用户可向乐享网申请账号解冻，收到解冻申请后乐享网可以为用户解冻账号，但是已经扣除的返利金额不能恢复。

    4.2.9 超过三年无登陆记录，乐享网保留注销该帐户的权利。注销后该账户内所有返利金额自动清零且不予恢复。此时乐享网不接受用户申请解冻或找回账户，相应的用户名将开放给任意用户注册登记使用。

    4.2.10 在使用乐享网服务过程中实施的所有行为均遵守国家法律、法规等规范性文件及乐享网各项规则的规定和要求，不违背社会公共利益或公共道德，不损害他人的合法权益，不违反本协议及相关规则。您如果违反前述承诺，产生任何法律后果的，您应以自己独自承担所有的法律责任，并确保乐享网免于因此产生任何损失。如乐享网因此承担相应责任或者赔偿相关损失，则您承诺乐享网可以向您追偿，相关责任或损失由您最终承担。

    4.2.11 在与其他用户交易过程中，遵守诚实信用原则，不采取不正当竞争行为，不扰乱网上交易的正常秩序，不从事与网上交易无关的行为。

    4.2.12 不以虚构或歪曲事实的方式不当评价其他用户，不采取不正当方式制造或提高自身的信用度，不采取不正当方式制造或提高（降低）其他用户的信用度。

    4.2.13 不对乐享网平台上的任何数据作商业性利用，包括但不限于在未经乐享网事先书面同意的情况下，以复制、传播等任何方式使用乐享网站上展示的资料。

    4.2.14 乐享网严禁用户通过以下行为获得利益，一经发现，乐享网有权追回已经给予的相关返利金额和已经消费的返利金额，并视情节严重可中止用户账号直至注销用户账号，同时该用户必须承担由此给乐享网带来的所有损失：

a)购买产品后恶意取消订单；

b)劫持流量；

c)自买自卖；

d)劫持其他用户的正常访问链接使其变成推广链接；

e)骗取其他用户点击其设置的非乐享网设置的链接；

f)违反购物所在网站用户协议及其规则；

g)其他违反法律法规或者违反诚实信用、公平原则的行为。

    4.2.15 乐享网严禁各种针对乐享网活动的作弊行为。对于查实的作弊行为，我们将收回该账号全部的邀请奖励、取消邀请资格，扣除一定的返利金额，并列入乐享网黑名单账户。作弊行为包括但不限于：使用相同的电脑、相同的IP地址在同一天内注册多个账号，以骗取邀请奖励的行为；以注册送钱或注册送返利等利益诱导用户来注册乐享网获取奖励的行为等。

   4.2.16 乐享网禁止用户在乐享网的合作商城内进行任何形式的推广。

   4.2.17 您不得使用任何装置、软件或例行程序干预或试图干预乐享网平台的正常运作或正在乐享网上进行的任何交易、活动。您不得采取任何将导致不合理的庞大数据负载加诸乐享网网络设备的行动，否则乐享网将追究您的相关责任，包括但不限于取消相关返利金额、收回相关邀请奖励、取消邀请资格、列入乐享网黑名单账户、冻结账户或者注销账户等。如造成乐享网损失或者承担相应法律责任的，乐享网有权要求您赔偿并最终承担相应的责任。

4.2.18 乐享网发布的其他服务条款和操作规则。

第五条  交易规则

用户承诺在其进入乐享网消费，通过乐享网与商家进行交易的过程中良好遵守如下交易规则：

5.1浏览商品服务信息

用户在乐享网浏览商品/服务的信息时，应当仔细阅读商品/服务信息中包含的全部内容，包括但不限于商品/服务的名称、种类、数量、质量、价格、有效期、预约时间、商家地址、营业时间、退款条件、售后服务等内容，其中用户应特别注意商品/服务的有效期、预约时间及退款条件等内容，用户完全接受信息中包含的全部内容后方可点击购买。

5.2 提交及确认订单

5.2.1 用户应当仔细阅读订单页面中所包含的全部内容，包括但不限于商品/服务信息中的全部内容、为再次提示用户注意而标明的本单商品/服务的有效期、退款条件等内容（如有），选择及确认购买数量、价格、应付总额、用户接收电子消费凭证的联系方式或接收货物的收货地址和送货时间等内容。

    前述订单页面中所包含的全部内容，构成了用户与商家之间达成的购买合同的合同内容，用户完全同意订单的全部内容后方可提交订单。

5.2.2 用户再次阅读并确认订单的全部内容后方可点击确认订单并付款，用户确认订单即视为用户已知晓、同意并接受订单中的全部内容，与商家成立了买卖合同。订单中所包含的全部内容即为购买合同的内容，具体包括但不限于商品/服务的名称、种类、数量、质量、价格、有效期、预约时间、商家地址、营业时间、退款条件、售后服务等，用户与商家均应当按照前述合同的约定履行各自的权利义务。

5.3 支付价款

在订单成立之后用户应根据付款页面的提示通过网上支付平台完成价款的支付。因乐享网接受商家委托代商家向用户收取商品/服务价款，故用户将价款支付给乐享网且支付成功即视为用户已向商家履行了合同项下的商品/服务价款支付义务。用户在支付价款之前不得要求商家向用户提供商品/服务。

5.4 团购电子消费凭证

5.4.1 用户支付订单价款成功后，乐享网向用户发送订单电子消费凭证，用户可按照合同的约定凭电子消费凭证向商家主张获得商品/服务。

5.4.2 用户应当妥善保管电子消费凭证，因用户保管不善导致电子消费凭证被他人使用的，用户要求乐享网重新发送电子消费凭证的, 乐享有权拒绝提供。

5.4.3 对于需要通过电子消费凭证验证进行消费的商品/服务，用户进行消费时，应向商家出示电子消费凭证，商家对电子消费凭证验证成功后按照订单内容的约定向用户提供商品/服务。

5.4.4 电子消费凭证于发生以下情形之一时即失效：

5.4.4.1 凭电子消费凭证已获得商品/服务；

5.4.4.2 订单内容中约定的有效期届满。

5.5退款规则

5.5.1用户付款成功后，因不可抗力或商家原因，导致商家无法向用户提供商品/服务，经乐享网核实后属实的；

5.5.2如用户已实际消费商品/服务，又要求商家退款或要求乐享网代商家进行退款的，商家或乐享网有权拒绝提供。

5.5.3合同约定的有效期届满但用户未在有效期内进行消费的，是否及如何退款应根据订单合同的约定确定。根据订单合同的约定用户有权要求退款的，用户应按照约定要求乐享网代商家进行退款，在此种情况下如用户未向乐享网要求退款的，即视为用户放弃了主张退款的权利，乐享网有权保留及处理此等款项。

5.5.4如用户申请将款项退回至用户的支付账户的，即用户申请提现的，则乐享网将于3-10个工作日内将款项按照用户的支付路径原路退回至用户的支付账户。但如下商品或服务除外：

5.5.4.1已消费且无充分证据证明商户提供的商品或服务存在瑕疵或与页面信息承诺不符的；

5.5.4.2在乐享网中明确标明“不支持未消费随时退款”的产品或服务。

5.6 在退款进行过程中，用户应当遵守乐享网关于退款的服务条款和操作规则的规定。

5.7 如用户与商家在履行过程中发生任何争议，包括但不限于对商品/服务的数量、质量、价格、有效期、预约时间、商家地址、退款条件、售后服务等问题发生争议的，用户应与商家根据订单合同内容的约定确定用户与商家各自的权利义务，承担各自的责任，解决争议。乐享网可协助用户与商家之间争议的协商调解。</p>

<p>第六条  用户的权利和义务

6.1 用户有权按照本协议约定接受乐享网提供的乐享网网络交易平台服务。

6.2 用户有权在注册时选择是否订阅乐享网发送的关于商品/服务信息的电子邮件或短消息，并在注册成功后有权随时订阅或退订乐享网该等信息。

6.3 如用户要求获得商品/服务的发票、其他付款凭证、购货凭证或服务单据，有权且应当在对商品/服务进行消费时向商家提出，发票金额以实际支付的订单价款为准。

6.4 用户在消费商品/服务的过程中，如发现商品/服务与订单内容不符或存在质量、服务态度等其他问题的，应与商家采取协商或其他方式予以解决，乐享网可向用户提供商家的真实网站登记信息并积极协助用户与商家解决争议。

6.5 用户有权随时终止使用乐享网服务。

6.6 用户应保证其在注册时和提交订单时所提供的姓名、联系方式、联系地址等全部信息真实、完整、准确，并当上述信息发生变更时及时进行更新提供给乐享网的信息。

6.7 用户在乐享网进行交易时不得恶意干扰交易的正常进行、破坏乐享网交易秩序。

6.8 用户不得以任何技术手段或其他方式干扰乐享网的正常运行或干扰其他用户对乐享网服务的使用。

6.9 用户不得以虚构事实等方式恶意诋毁乐享网或商家的商誉。

6.10 用户通过乐享网进行交易应出于真实消费目的，不得以转售等商业目的进行交易。

6.11 用户在付款成功后应配合接收货物或电子消费凭证。

6.12 用户不得对商品/服务进行虚假评价或虚假投诉。</p>

<p>第七条  乐享网的权利和义务

7.1 如用户不具备本协议约定的注册资格，则乐享网有权拒绝用户进行注册，对已注册的用户有权注销其乐享网会员账号，乐享网因此而遭受损失的有权向前述用户或其法定代理人主张赔偿。同时，乐享网保留其他任何情况下决定是否接受用户注册的权利。

7.2 乐享网发现账户使用者并非账户初始注册人时，有权中止该账户的使用。

7.3 乐享网通过技术检测、人工抽检等检测方式合理怀疑用户提供的信息错误、不实、失效或不完整时，有权通知用户更正、更新信息或中止、终止为其提供乐享网服务。

7.4 乐享网有权在发现乐享网上显示的任何信息存在明显错误时，对信息予以更正。

    7.5用户付款成功后，如确因情况变化导致商家需对订单内容作出变更的，乐享网有权接受商家委托单方对订单内容作出变更，如用户接受变更则按变更后的订单内容进行消费，如用户不接受变更则用户有权取消订单并要求乐享网代商家全额退款。

    7.6 乐享网保留修改、中止或终止乐享网服务的权利，乐享网行使前述权利将按照法律规定的程序及方式告知用户。

    7.7 乐享网应当采取必要的技术手段和管理措施保障乐享网的正常运行，并提供必要、可靠的交易环境和交易服务，维护团购交易秩序。

    7.8 乐享网有权在本协议履行期间及本协议终止后保留用户的注册信息及用户应用乐享网服务期间的全部交易信息，但不得非法使用该等信息。

    7.9 乐享网有权随时删除乐享网网站内各类不符合国家法律法规、规范性文件或乐享网网站规定的用户评价等内容信息，乐享网行使该等权利不需提前通知用户。</p>

<p>第八条  用户信息

8.1 在遵守法律的前提下，为向用户提供优质、便捷的服务，当用户注册乐享网账户时，或访问乐享网站及其相关网站、乐享网移动设备客户端时，或使用乐享网提供的服务时，乐享网可能会记录用户操作的相关信息或采集用户的以下信息：

8.1.1 在用注册乐享网账户及使用乐享网提供的各项服务时，为识别用户的身份，可能要向乐享网提供一些个人信息（包括但不限于姓名、身份证明、地址、电话号码、电子邮件地址等信息及相关附加信息（如您所在的省份和城市、邮政编码等））。

8.1.2 如用户使用的乐享网服务需与用户的银行账户或其他支付工具的账户关联方能实现时，用户需要向乐享网提供用户的银行账户信息或其他支付工具的账户信息。

8.1.3 为便于用户查询自己的交易状态或历史记录，乐享网会保存用户使用乐享网服务产生的交易信息。

8.1.4 为更好地识别用户的身份以充分保护用户的账户安全，当用户访问乐享网站及其相关网站、乐享网移动设备客户端时，或使用乐享网提供的服务时，乐享网可能会记录用户操作的相关信息，包括但不限于用户的计算机IP地址、设备标识符、硬件型号、操作系统版本、用户的位置以及与乐享网服务相关的日志信息。

8.1.5 除上述信息外，乐享网还可能为了提供服务及改进服务质量的合理需要而收集用户的其他信息，包括用户与乐享网的客户服务团队联系时用户提供的相关信息，用户参与问卷调查时向乐享网发送的问卷答复信息，以及用户与乐享网及乐享网关联公司互动时乐享网收集的相关信息。与此同时，为提高用户使用乐享网提供的服务的安全性，更准确地预防钓鱼网站欺诈和木马病毒，乐享网可能会通过了解一些用户的网络使用习惯、用户常用的软件信息等手段来判断用户账户的风险，并可能会记录一些乐享网认为有风险的URL。

8.2 为保障用户的信息安全，乐享网一直并将继续努力采取各种合理的物理、电子和管理方面的安全措施来保护用户信息，使用户的信息不会被泄漏、毁损或者丢失，包括但不限于信息加密存储、数据中心的访问控制。乐享网对可能接触到用户的信息的员工或外包人员也采取了严格管理，包括但不限于根据岗位的不同设置不同的权限，与员工签署保密协议等措施。

8.3 在遵守法律的前提下，为向用户提供服务及提升服务质量，乐享网会把用户的信息用于下列用途：

8.3.1 向用户提供乐享网的各项服务及客户服务，并维护、改进这些服务。

8.3.2 比较信息的准确性，并与第三方进行验证。例如，将用户向乐享网提交的身份信息与身份验证的服务机构进行验证。

8.3.3 为使用户知晓自己使用乐享网服务的情况或了解乐享网的服务，向用户发送服务状态的通知、营销活动及其他商业性电子信息。

8.3.4 对乐享网用户的身份数据、交易信息等进行综合统计、分析或加工，并出于奖励或为了让用户拥有更广泛的社交圈的需要而使用、共享或披露；例如乐享网可能会统计某个时间段注册乐享网账户的新用户，对这些新用户提供专享的优惠活动。

8.3.5 预防或禁止非法的活动。

8.3.6 经用户许可的其他用途。

8.4 Cookie的使用

8.4.1 为使用户获得更轻松的访问体验，用户访问乐享网网站或使用乐享网提供的服务时，乐享网可能会通过小型数据文件识别用户的身份，帮用户省去重复输入注册信息的步骤，或者帮助判断用户的账户安全。这些数据文件可能是Cookie，Flash Cookie，或用户的浏览器或关联应用程序提供的其他本地存储（统称“Cookie”）。

8.4.2 请用户理解，乐享网的某些服务只能通过使用“Cookie”才可得到实现。如果用户的浏览器或浏览器附加服务允许，用户可以修改对Cookie的接受程度或者拒绝乐享网的Cookie，但这一举动在某些情况下可能会影响用户安全访问乐享网网站和使用乐享网提供的服务。</p>

<p>第九条  特别声明

9.1 用户未通过乐享网与商家之间进行的交易不属于乐享网订单交易，乐享网对不属于乐享网的交易事项不承担任何责任，用户不得因其与商家之间因此类交易发生的任何争议投诉乐享网或要求乐享承担任何责任。不属于乐享网交易的情况具体包括：用户未在乐享网与商家成立订单；用户虽在乐享网与商家成立订单，但未通过乐享网而直接向商家支付价款。

9.2 不论在何种情况下，乐享网对由于信息网络设备维护、信息网络连接故障、电脑、通讯或其他系统的故障、电力故障、罢工、劳动争议、暴乱、起义、骚乱、生产力或生产资料不足、火灾、洪水、风暴、爆炸、战争、政府行为、司法行政机关的命令、其他不可抗力或第三方的不作为而造成的不能服务或延迟服务不承担责任。

9.3 作弊、扰乱交易秩序的情况

9.3.1 除活动规则另有规定外，每次活动中，每个用户只限参加一次活动（活动包括并不限于促销优惠、秒杀、抽奖等等），每个用户只能中奖一次。同一手机、同一联系方式、同一IP地址、同一乐享网账户、同一身份证件、同一银行卡号、同一收货地址、同一终端设备号或其他可以合理显示为同一用户的情形，均视为同一用户。

9.3.2 活动期间，如发现有用户通过不正当手段（包括但不限于侵犯第三人合法权益、作弊、扰乱系统、实施网络攻击、恶意套现、刷信誉、批量注册、用机器注册乐享网账户、用机器模拟客户端）参加活动而有碍其他用户公平参加本次活动或有违反活动目的之行为，活动举办方有权取消其获奖资格或其因参加活动所获赠品或权益。如该作弊行为给活动举办方造成损失的，活动举办方保留追究赔偿的权利。

9.3.3 对于恶意进行注册，反复交易退款，侵害乐享实际经营交易的情况，乐享会停止服务、封停账号并追究责任。</p>

<p>第十条  知识产权

10.1 乐享网所包含的全部智力成果包括但不限于数据库、网站设计、文字和图表、软件、照片、录像、音乐、声音及其前述组合，软件编译、相关源代码和软件 (包括小应用程序和脚本) 的知识产权权利均归乐享网所有。用户不得为商业目的复制、更改、拷贝、发送或使用前述任何材料或内容。

10.2 乐享网名称中包含的所有权利 (包括商誉和商标) 均归乐享网所有。

10.3 用户接受本协议即视为用户主动将其在乐享网发表的任何形式的信息的著作权，包括但不限于：复制权、发行权、出租权、展览权、表演权、放映权、广播权、信息网络传播权、摄制权、改编权、翻译权、汇编权以及应当由著作权人享有的其他可转让权利无偿独家转让给乐享网所有，乐享网有权利就任何主体侵权单独提起诉讼并获得全部赔偿。本协议属于《中华人民共和国著作权法》第二十五条规定的书面协议，其效力及于用户在乐享网发布的任何受著作权法保护的作品内容，无论该内容形成于本协议签订前还是本协议签订后。

10.4 用户在使用乐享网服务过程中不得非法使用或处分乐享网或他人的知识产权权利。用户不得将已发表于乐享网的信息以任何形式发布或授权其它网站（及媒体）使用。</p>

<p>第十一条  客户服务

乐享网建立专业的客服团队，并建立完善的客户服务制度，从技术、人员和制度上保障用户提问及投诉渠道的畅通，为用户提供及时的疑难解答与投诉反馈。</p>

<p>第十二条  协议的变更和终止

12.1 协议的变更

乐享网有权对本协议内容或乐享网发布的其他服务条款及操作规则的内容进行变更，乐享网将按照法律规定的程序及方式发布公告。如用户继续使用乐享网提供的服务即视为用户同意该等内容变更，如用户不同意变更后的内容则用户有权注销乐享网账户、停止使用乐享网服务。

12.2 协议的终止

12.2.1 乐享网有权依据本协议约定注销用户的乐享网账号，本协议于账号注销之日终止。

12.2.2 乐享网有权终止全部乐享网服务，本协议于乐享网全部服务依法定程序及方式终止之日终止。

12.2.3 本协议终止后，用户不得要求乐享网继续向其提供任何服务或履行任何其他义务，包括但不限于要求乐享网为用户保留或向用户披露其原乐享网账号中的任何信息，向用户或第三方转发任何其未曾阅读或发送过的信息等。

12.2.4 本协议的终止不影响守约方向违约方追究违约责任。</p>

<p>第十三条  违约责任

13.1 乐享网或用户违反本协议的约定即构成违约，违约方应当向守约方承担违约责任。

13.2 如用户违反本协议约定，以转售等商业目的进行交易，则乐享网有权代商家取消相关交易，并有权注销其乐享网账号，终止为其提供乐享网服务，如乐享网因此而遭受损失的，有权要求用户赔偿损失。

13.3 如因用户提供的信息不真实、不完整或不准确给乐享网或商家造成损失的，乐享网有权要求用户对乐享网或对商家进行损失的赔偿。

13.4 如因用户违反法律法规规定或本协议约定，在乐享网或利用乐享网服务从事非法活动的，乐享网有权立即终止继续对其提供乐享网服务，注销其账号，并要求其赔偿由此给乐享网造成的损失。

13.5 如用户以技术手段干扰乐享网的运行或干扰其他用户对乐享网使用的，乐享网有权立即注销其乐享网账号，并有权要求其赔偿由此给乐享网造成的损失。

13.6 如用户以虚构事实等方式恶意诋毁乐享网或商家的商誉，乐享网有权要求用户向乐享网或商家公开道歉，赔偿其给乐享网或商家造成的损失，并有权终止对其提供乐享网服务。

第十四条  争议解决

用户与乐享网因本协议的履行发生争议的应通过友好协商解决，协商解决不成的，任一方有权向株洲市天元区人民提起诉讼。

第十五条  协议生效

本协议于用户点击乐享网注册页面的同意注册并完成注册程序、获得乐享网账号和密码时生效，对乐享网和用户均具有约束力。

本协议于2016年3月1日发布。

</p>





			</div>

		</div>

	</div>

</div>



<script type='text/javascript' src="<?php echo $this->getWebViewPath()."/javascript/reg.js";?>"></script>

<script>
	$(function(){
		$('.agree a').click(function(){
			layer.open({
			  type: 1,
			  title:'《第三课用户注册协议》',
			  skin: 'layui-layer-rim', //加上边框
			  area: ['700px', '80%'], //宽高
			  content: $('.agreement'),
			});
		})
	})
</script>
<script>
 	$('#close').click(function(){
     $('.agreement gray').css('display','none');
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
				<?php $seo_data=array(); $site_config=new Config('site_config');$site_config=$site_config->getInfo();?>

<?php $seo_data['title']="用户注册_".$site_config['name']?>

<?php $callback = IReq::get('callback') ? IFilter::clearUrl(IReq::get('callback')) : IUrl::getRefRoute()?>

<link href="<?php echo $this->getWebSkinPath()."css/register.css";?>" rel="stylesheet" type="text/css" />

<style>
body{
background:url(<?php echo $this->getWebSkinPath()."/images/reg_bg.jpg";?>);
 }
</style>


<script language="javascript">

var _callback = '<?php if($callback){?><?php echo isset($callback)?$callback:"";?><?php }?>';

var _reg_ajax_url = '<?php echo IUrl::creatUrl("/simple/reg_pc_ajax");?>';

var _ucenter_url = '<?php echo IUrl::creatUrl("/ucenter/index");?>';

var _send_sms_url = '<?php echo IUrl::creatUrl("/simple/send_reg_sms");?>';

var _username = '<?php echo $this->username;?>';

</script>



<div class="wrapper clearfix"  style="margin-top:20px;"  >

	<div class="wrap_box" >


		<h3 class="notice"><a href="http://www.lelele999.com"></a></h3>

		<p class="tips"><span class="gray f_r">已有<?php echo $siteConfig->name;?>帐号？请点<a class="orange bold" href="<?php echo IUrl::creatUrl("/simple/login");?>">这里</a>登录</span><!-- 欢迎来到我们的网站，如果您是新用户，请填写下面的表单进行注册 --></p>

		<div class="box clearfix" >

			<form action='<?php echo IUrl::creatUrl("/simple/reg_act");?>' method='post' id="mobileWay" >

				<input type="hidden" name='callback' />
				<div class="form_list">
					<h2>用户注册</h2>
					<ul class="form_table" >
						<li class="sanzi">
							<em  style="font-style:normal;font-size:14px;">用户名：</em>
							<input class="gray" name='username' id="username" pattern="required" type="text"  />
							<label>填写用户名</label>
						</li>
						<li>
							<em style="font-style:normal;font-size:14px;">设置密码：</em>
							<input class="gray" type="password" name='password' id="password" pattern="^\S{6,32}$" bind='repassword' alt='填写6-32个字符' />
							<label>填写登录密码，6-32个字符</label>
						</li>
						<!-- <li> -->
							<!-- <em style="font-style:normal;font-size:14px;">确认密码：</em> -->
							<!-- <input class="gray" type="password" name='repassword' id="repassword" pattern="^\S{6,32}$" bind='password' alt='重复上面所填写的密码' /> -->
							<!-- <label>重复上面所填写的密码</label> -->
						<!-- </li> -->
						<li class="sanzi">
							<em style="font-style:normal;font-size:14px;">手机号：</em>
							<input class="gray" type="text" name='mobile' id="mobile" pattern="mobi" alt="请输入正确的手机号码" />
							<input type="button" class="send_sms" value="获取验证码" onclick="sendMessage();"/><br /><div class="send_sms_notice">验证码已发送到您的手机，请查收</div>
						</li>
						<li class="wuzi">
							<em style="font-style:normal;font-size:14px;">手机验证码：</em>
							<input name="mobile_code" id="mobile_code" class="gray_s" type="text" pattern="required" alt="请输入短信息中验证码" />
						</li>
						<!-- <li class="sanzi">
							<em style="font-style:normal;font-size:14px;">验证码：</em>
							<input type='text' class='gray_s' name='captcha' id="captcha" pattern='^\w{5,10}$' alt='填写下面图片所示的字符' />
							<img src='<?php echo IUrl::creatUrl("/simple/getCaptcha");?>' id='captchaImg' />
							<span class="light_gray">看不清？<a class="link" href="javascript:changeCaptcha('<?php echo IUrl::creatUrl("/simple/getCaptcha");?>'); ">换一张</a></span>
						</li> -->
						<li class="sanzi">
							<em style="font-style:normal;font-size:14px;">推广码：</em>
							<input name="promo_code" id="promo_code" class="gray_s" type="text" />
						</li>
					</ul>

					<div class="agree"><input type="checkbox" name="agree" checked="checked"> 阅读并同意<a href="javascript:void(0);">《第三课用户注册协议》</a></div>

					<div class="reg_sub">
						<input onclick="onReg();" class="submit_reg" type="button" value="提交" />
					</div>
				</div>



			</form>

			<div class="agreement gray">
                  <span class="layui-layer-setwin">
                   </span>






<p>第一条	协议内容及生效：

    1.1 本协议内容包括协议正文及所有乐享网已经发布的或将来可能发布的各类规则。所有规则为协议不可分割的一部分，与协议正文具有同等法律效力。

1.2 您在注册乐享网账户时点击 “同意以下条款，提交”即视为您接受本协议及各类规则，并同意受其约束。您应当在使用乐享网服务之前认真阅读全部协议内容并确保完全理解协议内容，如您对协议有任何疑问的，应向乐享网咨询。但无论您事实上是否在使用乐享网服务之前认真阅读了本协议内容，只要您注册、正在或者继续使用乐享网服务，则视为接受本协议。

1.3 商户签署或在线接受本协议并不导致本协议立即生效，经过乙方审核通过后，本协议即在商户和乙方之间产生法律效力。

1.4 您承诺接受并遵守本协议的约定。如果您不同意本协议的约定，您应立即停止注册程序或停止使用乐享网服务。

1.5 乐享网有权根据需要不时地制订、修改本协议及/或各类规则，并以网站公示的方式进行公告。变更后的协议和规则一经在网站公布后，立即自动生效。乐享网的最新的协议和规则以及网站公告可供您随时登陆查阅，您也应当经常性的登陆查阅最新的协议和规则以及网站公告以了解乐享网最新动态。如您不同意相关变更，应当立即停止使用乐享网服务。您继续使用服务的，即表示您接受经修订的协议和规则。本协议和规则（及其各自的不时修订）条款具有可分割性，任一条款被视为违法、无效、被撤销、变更或因任何理由不可执行，并不影响其他条款的合法性、有效性和可执行性。

1.6 本协议在您注册乐享网账户时点击 “同意以下条款，提交”即生效。</p>

<p>第二条  定义

2.1 “lelele999.com（乐享网）”：指由湖南乐享生活租赁服务有限公司提供技术支持和服务的电子商务平台网站，网址为www.lelele999.com（或依湖南乐享生活租赁服务有限公司根据业务需要不时修改的URL）。

2.2 “乐享生活电子商务交易平台”：指湖南乐享生活租赁服务有限公司供用户发布或查询商品信息，进行信息交流，达成交易意向及向用户提供其他与交易有关的辅助信息服务的空间。

2.3 “用户及用户注册”：接受并同意本协议全部条款及乐享网发布的其他全部服务条款和操作规则、通过乐享网进行交易的乐享网注册用户。用户注册是指用户登录乐享网（www.lelele999.com），按要求填写相关信息，且在线阅读并确认接收或书面签署本协议以最终激活其乐享服务账户的过程。

2.4 “乐享服务账户”：即用户完成用户注册流程而获得的其将在使用服务的过程中必须与自设的账户密码共同使用的用户名，又称“乐享用户名”。用户应妥善保管其乐享服务账户及密码信息，用户不得以任何形式擅自转让或授权他人使用自己的乐享服务账户。

2.5 “商家”：通过乐享网发布商品/服务信息、向用户提供商品/服务的自然人、法人和其他组织。</p>

<p>第三条  用户注册

3.1 注册资格

您应当是具备完全民事权利能力和完全民事行为能力的自然人、法人或其他组织。若您不具备前述主体资格，则您及您的监护人应承担因此而导致的一切后果，且乐享网有权注销（永久冻结）您的乐享网账户，并向您及您的监护人索偿或者追偿。若您不具备前述主体资格，则需要监护人同意您方可注册成为乐享网用户，否则您和您的监护人应承担因此而导致的一切后果，且乐享网有权注销（永久冻结）您的乐享网账户，并向您及您的监护人索偿或者追偿。

3.2 注册流程

3.2.1 用户同意根据乐享网用户注册页面的要求提供有效电子邮箱、所在城市等信息，设置乐享网账号及密码，用户应确保所提供全部信息的真实性、完整性和准确性。

3.2.2 用户在注册时有权选择是否订阅乐享网发送的关于商品信息的电子邮件和/或短信息。

3.2.3 用户合法、完整并有效提供注册所需信息的，有权获得乐享网账号和密码，乐享网账号和密码用于用户在乐享网进行用户登录。

3.2.4 用户获得美乐享网账号及密码时视为用户注册成功，用户同意接收乐享网发送的与乐享网网站管理、运营相关的电子邮件和短消息。

3.3 账户

3.3.1 在您签署本协议，完成用户注册程序或以其他乐享网允许的方式实际使用乐享网服务时，乐享网会向您提供唯一编号的乐享服务账户（以下亦称账户）。

3.3.2 您可以对账户设置用户名和密码，通过该用户名密码登陆乐享网平台。您设置的用户名不得侵犯或涉嫌侵犯他人合法权益。

    3.3.3 您应对您的账户和密码的安全，以及对通过您的账户和密码实施的行为负责。除非经过正当法律程序，且征得乐享网的同意，否则，账户和密码不得以任何方式转让、赠与或继承。如果发现任何人不当使用您的账户或有任何其他可能危及您的账户安全的情形时，您应当立即以有效方式通知乐享网，要求乐享网暂停相关服务。您理解乐享网对您的请求采取行动需要合理时间，乐享网对在采取行动前已经产生的后果（包括但不限于您的任何损失）不承担任何责任，但乐享网未能在合理时间内采取行动的情况除外。您认可您在注册、使用乐享网服务过程中提供、形成的数据等相关信息的所有权及其他相关权利属于乐享网，乐享网有权使用上述信息。</p>

<p>第四条  用户服务

乐享网为用户通过乐享网进行网络交易活动提供网络交易平台服务，目前乐享网对用户提供的乐享网网络交易平台服务为免费服务，但乐享网保留未来对乐享网网络交易平台服务收取服务费用的权利。

4.1 服务内容

4.1.1 用户有权在乐享网浏览商品/服务的信息、有权通过乐享网与商家达成订单、支付价款、获得电子消费凭证（如有）等。

4.1.2 用户有权在乐享网查看其乐享网账号下的信息，有权应用乐享网提供的功能进行操作。

4.1.3 用户有权按照乐享网发布的活动规则参与乐享网组织的网站活动。

4.1.4 乐享网承诺为用户提供的其他服务。

4.2 服务规则

用户承诺遵守下列乐享网服务规则：

4.2.1 用户应当遵守法律法规、规章、规范性文件及政策要求的规定，不得在乐享网或利用乐享网服务从事非法或其他损害乐享网或第三方权益的活动，如发送或接收任何违法、违规、违反公序良俗、侵犯他人权益的信息，发送或接收传销材料或存在其他危害的信息或言论，未经乐享网授权使用或伪造乐享网电子邮件题头信息等。

4.2.2用户通过乐享网与商家进行交易时，应当遵守本协议约定及乐享网发布的其他关于交易的服务条款和操作规则的全部规定。

4.2.3用户在乐享网对商品/服务进行评价时应当根据实际情况如实进行评价。

4.2.4 用户应当按照乐享网发布的规则参加乐享网抽奖等活动，遵守活动秩序。

4.2.5 如果用户提供给乐享网的资料有变更，请及时通知乐享网做出相应的修改。

4.2.6用户不得出现恶意注册恶意点击等行为。

4.2.7用户应及时使用自己的乐享网账户中的返利金额。返利金额有使用期限，从用户在消费或各类活动中获得的返利金额进入用户的乐享网帐户开始起算。超过有效期仍未及时使用的，则此部分过期返利金额将逾期失效并作归零处理。返利金额有效期到期之日一个月前，乐享网将会通过用户登记注册的联系方式提前一个月通知用户尽快消费即将到期的返利金额。返利金额有效期到期后，乐享网仍然给予用户1个月的宽限期，在此宽限期内用户可申请消费已经到期的返利金额。宽限期届满仍未消费的，此部分过期返利金额将正式逾期失效并作归零处理。

    4.2.8 乐享网用户帐户如果两年内无登陆记录，将被视为休眠账户作冻结处理。用户账户自冻结第二个月开始，乐享网保留在每月1日自动扣除已经超出有效期的返利金额部分的权利。用户可向乐享网申请账号解冻，收到解冻申请后乐享网可以为用户解冻账号，但是已经扣除的返利金额不能恢复。

    4.2.9 超过三年无登陆记录，乐享网保留注销该帐户的权利。注销后该账户内所有返利金额自动清零且不予恢复。此时乐享网不接受用户申请解冻或找回账户，相应的用户名将开放给任意用户注册登记使用。

    4.2.10 在使用乐享网服务过程中实施的所有行为均遵守国家法律、法规等规范性文件及乐享网各项规则的规定和要求，不违背社会公共利益或公共道德，不损害他人的合法权益，不违反本协议及相关规则。您如果违反前述承诺，产生任何法律后果的，您应以自己独自承担所有的法律责任，并确保乐享网免于因此产生任何损失。如乐享网因此承担相应责任或者赔偿相关损失，则您承诺乐享网可以向您追偿，相关责任或损失由您最终承担。

    4.2.11 在与其他用户交易过程中，遵守诚实信用原则，不采取不正当竞争行为，不扰乱网上交易的正常秩序，不从事与网上交易无关的行为。

    4.2.12 不以虚构或歪曲事实的方式不当评价其他用户，不采取不正当方式制造或提高自身的信用度，不采取不正当方式制造或提高（降低）其他用户的信用度。

    4.2.13 不对乐享网平台上的任何数据作商业性利用，包括但不限于在未经乐享网事先书面同意的情况下，以复制、传播等任何方式使用乐享网站上展示的资料。

    4.2.14 乐享网严禁用户通过以下行为获得利益，一经发现，乐享网有权追回已经给予的相关返利金额和已经消费的返利金额，并视情节严重可中止用户账号直至注销用户账号，同时该用户必须承担由此给乐享网带来的所有损失：

a)购买产品后恶意取消订单；

b)劫持流量；

c)自买自卖；

d)劫持其他用户的正常访问链接使其变成推广链接；

e)骗取其他用户点击其设置的非乐享网设置的链接；

f)违反购物所在网站用户协议及其规则；

g)其他违反法律法规或者违反诚实信用、公平原则的行为。

    4.2.15 乐享网严禁各种针对乐享网活动的作弊行为。对于查实的作弊行为，我们将收回该账号全部的邀请奖励、取消邀请资格，扣除一定的返利金额，并列入乐享网黑名单账户。作弊行为包括但不限于：使用相同的电脑、相同的IP地址在同一天内注册多个账号，以骗取邀请奖励的行为；以注册送钱或注册送返利等利益诱导用户来注册乐享网获取奖励的行为等。

   4.2.16 乐享网禁止用户在乐享网的合作商城内进行任何形式的推广。

   4.2.17 您不得使用任何装置、软件或例行程序干预或试图干预乐享网平台的正常运作或正在乐享网上进行的任何交易、活动。您不得采取任何将导致不合理的庞大数据负载加诸乐享网网络设备的行动，否则乐享网将追究您的相关责任，包括但不限于取消相关返利金额、收回相关邀请奖励、取消邀请资格、列入乐享网黑名单账户、冻结账户或者注销账户等。如造成乐享网损失或者承担相应法律责任的，乐享网有权要求您赔偿并最终承担相应的责任。

4.2.18 乐享网发布的其他服务条款和操作规则。

第五条  交易规则

用户承诺在其进入乐享网消费，通过乐享网与商家进行交易的过程中良好遵守如下交易规则：

5.1浏览商品服务信息

用户在乐享网浏览商品/服务的信息时，应当仔细阅读商品/服务信息中包含的全部内容，包括但不限于商品/服务的名称、种类、数量、质量、价格、有效期、预约时间、商家地址、营业时间、退款条件、售后服务等内容，其中用户应特别注意商品/服务的有效期、预约时间及退款条件等内容，用户完全接受信息中包含的全部内容后方可点击购买。

5.2 提交及确认订单

5.2.1 用户应当仔细阅读订单页面中所包含的全部内容，包括但不限于商品/服务信息中的全部内容、为再次提示用户注意而标明的本单商品/服务的有效期、退款条件等内容（如有），选择及确认购买数量、价格、应付总额、用户接收电子消费凭证的联系方式或接收货物的收货地址和送货时间等内容。

    前述订单页面中所包含的全部内容，构成了用户与商家之间达成的购买合同的合同内容，用户完全同意订单的全部内容后方可提交订单。

5.2.2 用户再次阅读并确认订单的全部内容后方可点击确认订单并付款，用户确认订单即视为用户已知晓、同意并接受订单中的全部内容，与商家成立了买卖合同。订单中所包含的全部内容即为购买合同的内容，具体包括但不限于商品/服务的名称、种类、数量、质量、价格、有效期、预约时间、商家地址、营业时间、退款条件、售后服务等，用户与商家均应当按照前述合同的约定履行各自的权利义务。

5.3 支付价款

在订单成立之后用户应根据付款页面的提示通过网上支付平台完成价款的支付。因乐享网接受商家委托代商家向用户收取商品/服务价款，故用户将价款支付给乐享网且支付成功即视为用户已向商家履行了合同项下的商品/服务价款支付义务。用户在支付价款之前不得要求商家向用户提供商品/服务。

5.4 团购电子消费凭证

5.4.1 用户支付订单价款成功后，乐享网向用户发送订单电子消费凭证，用户可按照合同的约定凭电子消费凭证向商家主张获得商品/服务。

5.4.2 用户应当妥善保管电子消费凭证，因用户保管不善导致电子消费凭证被他人使用的，用户要求乐享网重新发送电子消费凭证的, 乐享有权拒绝提供。

5.4.3 对于需要通过电子消费凭证验证进行消费的商品/服务，用户进行消费时，应向商家出示电子消费凭证，商家对电子消费凭证验证成功后按照订单内容的约定向用户提供商品/服务。

5.4.4 电子消费凭证于发生以下情形之一时即失效：

5.4.4.1 凭电子消费凭证已获得商品/服务；

5.4.4.2 订单内容中约定的有效期届满。

5.5退款规则

5.5.1用户付款成功后，因不可抗力或商家原因，导致商家无法向用户提供商品/服务，经乐享网核实后属实的；

5.5.2如用户已实际消费商品/服务，又要求商家退款或要求乐享网代商家进行退款的，商家或乐享网有权拒绝提供。

5.5.3合同约定的有效期届满但用户未在有效期内进行消费的，是否及如何退款应根据订单合同的约定确定。根据订单合同的约定用户有权要求退款的，用户应按照约定要求乐享网代商家进行退款，在此种情况下如用户未向乐享网要求退款的，即视为用户放弃了主张退款的权利，乐享网有权保留及处理此等款项。

5.5.4如用户申请将款项退回至用户的支付账户的，即用户申请提现的，则乐享网将于3-10个工作日内将款项按照用户的支付路径原路退回至用户的支付账户。但如下商品或服务除外：

5.5.4.1已消费且无充分证据证明商户提供的商品或服务存在瑕疵或与页面信息承诺不符的；

5.5.4.2在乐享网中明确标明“不支持未消费随时退款”的产品或服务。

5.6 在退款进行过程中，用户应当遵守乐享网关于退款的服务条款和操作规则的规定。

5.7 如用户与商家在履行过程中发生任何争议，包括但不限于对商品/服务的数量、质量、价格、有效期、预约时间、商家地址、退款条件、售后服务等问题发生争议的，用户应与商家根据订单合同内容的约定确定用户与商家各自的权利义务，承担各自的责任，解决争议。乐享网可协助用户与商家之间争议的协商调解。</p>

<p>第六条  用户的权利和义务

6.1 用户有权按照本协议约定接受乐享网提供的乐享网网络交易平台服务。

6.2 用户有权在注册时选择是否订阅乐享网发送的关于商品/服务信息的电子邮件或短消息，并在注册成功后有权随时订阅或退订乐享网该等信息。

6.3 如用户要求获得商品/服务的发票、其他付款凭证、购货凭证或服务单据，有权且应当在对商品/服务进行消费时向商家提出，发票金额以实际支付的订单价款为准。

6.4 用户在消费商品/服务的过程中，如发现商品/服务与订单内容不符或存在质量、服务态度等其他问题的，应与商家采取协商或其他方式予以解决，乐享网可向用户提供商家的真实网站登记信息并积极协助用户与商家解决争议。

6.5 用户有权随时终止使用乐享网服务。

6.6 用户应保证其在注册时和提交订单时所提供的姓名、联系方式、联系地址等全部信息真实、完整、准确，并当上述信息发生变更时及时进行更新提供给乐享网的信息。

6.7 用户在乐享网进行交易时不得恶意干扰交易的正常进行、破坏乐享网交易秩序。

6.8 用户不得以任何技术手段或其他方式干扰乐享网的正常运行或干扰其他用户对乐享网服务的使用。

6.9 用户不得以虚构事实等方式恶意诋毁乐享网或商家的商誉。

6.10 用户通过乐享网进行交易应出于真实消费目的，不得以转售等商业目的进行交易。

6.11 用户在付款成功后应配合接收货物或电子消费凭证。

6.12 用户不得对商品/服务进行虚假评价或虚假投诉。</p>

<p>第七条  乐享网的权利和义务

7.1 如用户不具备本协议约定的注册资格，则乐享网有权拒绝用户进行注册，对已注册的用户有权注销其乐享网会员账号，乐享网因此而遭受损失的有权向前述用户或其法定代理人主张赔偿。同时，乐享网保留其他任何情况下决定是否接受用户注册的权利。

7.2 乐享网发现账户使用者并非账户初始注册人时，有权中止该账户的使用。

7.3 乐享网通过技术检测、人工抽检等检测方式合理怀疑用户提供的信息错误、不实、失效或不完整时，有权通知用户更正、更新信息或中止、终止为其提供乐享网服务。

7.4 乐享网有权在发现乐享网上显示的任何信息存在明显错误时，对信息予以更正。

    7.5用户付款成功后，如确因情况变化导致商家需对订单内容作出变更的，乐享网有权接受商家委托单方对订单内容作出变更，如用户接受变更则按变更后的订单内容进行消费，如用户不接受变更则用户有权取消订单并要求乐享网代商家全额退款。

    7.6 乐享网保留修改、中止或终止乐享网服务的权利，乐享网行使前述权利将按照法律规定的程序及方式告知用户。

    7.7 乐享网应当采取必要的技术手段和管理措施保障乐享网的正常运行，并提供必要、可靠的交易环境和交易服务，维护团购交易秩序。

    7.8 乐享网有权在本协议履行期间及本协议终止后保留用户的注册信息及用户应用乐享网服务期间的全部交易信息，但不得非法使用该等信息。

    7.9 乐享网有权随时删除乐享网网站内各类不符合国家法律法规、规范性文件或乐享网网站规定的用户评价等内容信息，乐享网行使该等权利不需提前通知用户。</p>

<p>第八条  用户信息

8.1 在遵守法律的前提下，为向用户提供优质、便捷的服务，当用户注册乐享网账户时，或访问乐享网站及其相关网站、乐享网移动设备客户端时，或使用乐享网提供的服务时，乐享网可能会记录用户操作的相关信息或采集用户的以下信息：

8.1.1 在用注册乐享网账户及使用乐享网提供的各项服务时，为识别用户的身份，可能要向乐享网提供一些个人信息（包括但不限于姓名、身份证明、地址、电话号码、电子邮件地址等信息及相关附加信息（如您所在的省份和城市、邮政编码等））。

8.1.2 如用户使用的乐享网服务需与用户的银行账户或其他支付工具的账户关联方能实现时，用户需要向乐享网提供用户的银行账户信息或其他支付工具的账户信息。

8.1.3 为便于用户查询自己的交易状态或历史记录，乐享网会保存用户使用乐享网服务产生的交易信息。

8.1.4 为更好地识别用户的身份以充分保护用户的账户安全，当用户访问乐享网站及其相关网站、乐享网移动设备客户端时，或使用乐享网提供的服务时，乐享网可能会记录用户操作的相关信息，包括但不限于用户的计算机IP地址、设备标识符、硬件型号、操作系统版本、用户的位置以及与乐享网服务相关的日志信息。

8.1.5 除上述信息外，乐享网还可能为了提供服务及改进服务质量的合理需要而收集用户的其他信息，包括用户与乐享网的客户服务团队联系时用户提供的相关信息，用户参与问卷调查时向乐享网发送的问卷答复信息，以及用户与乐享网及乐享网关联公司互动时乐享网收集的相关信息。与此同时，为提高用户使用乐享网提供的服务的安全性，更准确地预防钓鱼网站欺诈和木马病毒，乐享网可能会通过了解一些用户的网络使用习惯、用户常用的软件信息等手段来判断用户账户的风险，并可能会记录一些乐享网认为有风险的URL。

8.2 为保障用户的信息安全，乐享网一直并将继续努力采取各种合理的物理、电子和管理方面的安全措施来保护用户信息，使用户的信息不会被泄漏、毁损或者丢失，包括但不限于信息加密存储、数据中心的访问控制。乐享网对可能接触到用户的信息的员工或外包人员也采取了严格管理，包括但不限于根据岗位的不同设置不同的权限，与员工签署保密协议等措施。

8.3 在遵守法律的前提下，为向用户提供服务及提升服务质量，乐享网会把用户的信息用于下列用途：

8.3.1 向用户提供乐享网的各项服务及客户服务，并维护、改进这些服务。

8.3.2 比较信息的准确性，并与第三方进行验证。例如，将用户向乐享网提交的身份信息与身份验证的服务机构进行验证。

8.3.3 为使用户知晓自己使用乐享网服务的情况或了解乐享网的服务，向用户发送服务状态的通知、营销活动及其他商业性电子信息。

8.3.4 对乐享网用户的身份数据、交易信息等进行综合统计、分析或加工，并出于奖励或为了让用户拥有更广泛的社交圈的需要而使用、共享或披露；例如乐享网可能会统计某个时间段注册乐享网账户的新用户，对这些新用户提供专享的优惠活动。

8.3.5 预防或禁止非法的活动。

8.3.6 经用户许可的其他用途。

8.4 Cookie的使用

8.4.1 为使用户获得更轻松的访问体验，用户访问乐享网网站或使用乐享网提供的服务时，乐享网可能会通过小型数据文件识别用户的身份，帮用户省去重复输入注册信息的步骤，或者帮助判断用户的账户安全。这些数据文件可能是Cookie，Flash Cookie，或用户的浏览器或关联应用程序提供的其他本地存储（统称“Cookie”）。

8.4.2 请用户理解，乐享网的某些服务只能通过使用“Cookie”才可得到实现。如果用户的浏览器或浏览器附加服务允许，用户可以修改对Cookie的接受程度或者拒绝乐享网的Cookie，但这一举动在某些情况下可能会影响用户安全访问乐享网网站和使用乐享网提供的服务。</p>

<p>第九条  特别声明

9.1 用户未通过乐享网与商家之间进行的交易不属于乐享网订单交易，乐享网对不属于乐享网的交易事项不承担任何责任，用户不得因其与商家之间因此类交易发生的任何争议投诉乐享网或要求乐享承担任何责任。不属于乐享网交易的情况具体包括：用户未在乐享网与商家成立订单；用户虽在乐享网与商家成立订单，但未通过乐享网而直接向商家支付价款。

9.2 不论在何种情况下，乐享网对由于信息网络设备维护、信息网络连接故障、电脑、通讯或其他系统的故障、电力故障、罢工、劳动争议、暴乱、起义、骚乱、生产力或生产资料不足、火灾、洪水、风暴、爆炸、战争、政府行为、司法行政机关的命令、其他不可抗力或第三方的不作为而造成的不能服务或延迟服务不承担责任。

9.3 作弊、扰乱交易秩序的情况

9.3.1 除活动规则另有规定外，每次活动中，每个用户只限参加一次活动（活动包括并不限于促销优惠、秒杀、抽奖等等），每个用户只能中奖一次。同一手机、同一联系方式、同一IP地址、同一乐享网账户、同一身份证件、同一银行卡号、同一收货地址、同一终端设备号或其他可以合理显示为同一用户的情形，均视为同一用户。

9.3.2 活动期间，如发现有用户通过不正当手段（包括但不限于侵犯第三人合法权益、作弊、扰乱系统、实施网络攻击、恶意套现、刷信誉、批量注册、用机器注册乐享网账户、用机器模拟客户端）参加活动而有碍其他用户公平参加本次活动或有违反活动目的之行为，活动举办方有权取消其获奖资格或其因参加活动所获赠品或权益。如该作弊行为给活动举办方造成损失的，活动举办方保留追究赔偿的权利。

9.3.3 对于恶意进行注册，反复交易退款，侵害乐享实际经营交易的情况，乐享会停止服务、封停账号并追究责任。</p>

<p>第十条  知识产权

10.1 乐享网所包含的全部智力成果包括但不限于数据库、网站设计、文字和图表、软件、照片、录像、音乐、声音及其前述组合，软件编译、相关源代码和软件 (包括小应用程序和脚本) 的知识产权权利均归乐享网所有。用户不得为商业目的复制、更改、拷贝、发送或使用前述任何材料或内容。

10.2 乐享网名称中包含的所有权利 (包括商誉和商标) 均归乐享网所有。

10.3 用户接受本协议即视为用户主动将其在乐享网发表的任何形式的信息的著作权，包括但不限于：复制权、发行权、出租权、展览权、表演权、放映权、广播权、信息网络传播权、摄制权、改编权、翻译权、汇编权以及应当由著作权人享有的其他可转让权利无偿独家转让给乐享网所有，乐享网有权利就任何主体侵权单独提起诉讼并获得全部赔偿。本协议属于《中华人民共和国著作权法》第二十五条规定的书面协议，其效力及于用户在乐享网发布的任何受著作权法保护的作品内容，无论该内容形成于本协议签订前还是本协议签订后。

10.4 用户在使用乐享网服务过程中不得非法使用或处分乐享网或他人的知识产权权利。用户不得将已发表于乐享网的信息以任何形式发布或授权其它网站（及媒体）使用。</p>

<p>第十一条  客户服务

乐享网建立专业的客服团队，并建立完善的客户服务制度，从技术、人员和制度上保障用户提问及投诉渠道的畅通，为用户提供及时的疑难解答与投诉反馈。</p>

<p>第十二条  协议的变更和终止

12.1 协议的变更

乐享网有权对本协议内容或乐享网发布的其他服务条款及操作规则的内容进行变更，乐享网将按照法律规定的程序及方式发布公告。如用户继续使用乐享网提供的服务即视为用户同意该等内容变更，如用户不同意变更后的内容则用户有权注销乐享网账户、停止使用乐享网服务。

12.2 协议的终止

12.2.1 乐享网有权依据本协议约定注销用户的乐享网账号，本协议于账号注销之日终止。

12.2.2 乐享网有权终止全部乐享网服务，本协议于乐享网全部服务依法定程序及方式终止之日终止。

12.2.3 本协议终止后，用户不得要求乐享网继续向其提供任何服务或履行任何其他义务，包括但不限于要求乐享网为用户保留或向用户披露其原乐享网账号中的任何信息，向用户或第三方转发任何其未曾阅读或发送过的信息等。

12.2.4 本协议的终止不影响守约方向违约方追究违约责任。</p>

<p>第十三条  违约责任

13.1 乐享网或用户违反本协议的约定即构成违约，违约方应当向守约方承担违约责任。

13.2 如用户违反本协议约定，以转售等商业目的进行交易，则乐享网有权代商家取消相关交易，并有权注销其乐享网账号，终止为其提供乐享网服务，如乐享网因此而遭受损失的，有权要求用户赔偿损失。

13.3 如因用户提供的信息不真实、不完整或不准确给乐享网或商家造成损失的，乐享网有权要求用户对乐享网或对商家进行损失的赔偿。

13.4 如因用户违反法律法规规定或本协议约定，在乐享网或利用乐享网服务从事非法活动的，乐享网有权立即终止继续对其提供乐享网服务，注销其账号，并要求其赔偿由此给乐享网造成的损失。

13.5 如用户以技术手段干扰乐享网的运行或干扰其他用户对乐享网使用的，乐享网有权立即注销其乐享网账号，并有权要求其赔偿由此给乐享网造成的损失。

13.6 如用户以虚构事实等方式恶意诋毁乐享网或商家的商誉，乐享网有权要求用户向乐享网或商家公开道歉，赔偿其给乐享网或商家造成的损失，并有权终止对其提供乐享网服务。

第十四条  争议解决

用户与乐享网因本协议的履行发生争议的应通过友好协商解决，协商解决不成的，任一方有权向株洲市天元区人民提起诉讼。

第十五条  协议生效

本协议于用户点击乐享网注册页面的同意注册并完成注册程序、获得乐享网账号和密码时生效，对乐享网和用户均具有约束力。

本协议于2016年3月1日发布。

</p>





			</div>

		</div>

	</div>

</div>



<script type='text/javascript' src="<?php echo $this->getWebViewPath()."/javascript/reg.js";?>"></script>

<script>
	$(function(){
		$('.agree a').click(function(){
			layer.open({
			  type: 1,
			  title:'《第三课用户注册协议》',
			  skin: 'layui-layer-rim', //加上边框
			  area: ['700px', '80%'], //宽高
			  content: $('.agreement'),
			});
		})
	})
</script>
<script>
 	$('#close').click(function(){
     $('.agreement gray').css('display','none');
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


