<?php 
	$siteConfig = new Config("site_config");
	$callback   = IReq::get('callback') ? urlencode(IFilter::act(IReq::get('callback'),'url')) : '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $siteConfig->name;?></title>
	<link type="image/x-icon" href="favicon.ico" rel="icon">
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/index.css";?>" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/common.js";?>"></script>
	<script type='text/javascript' src='<?php echo $this->getWebViewPath()."javascript/site.js";?>'></script>
    
<style>
.form_table input.send_sms {
	padding: 0 10px;
	height: 28px;
	line-height: 28px;
	display: inline-block;
	background-color: #f2f2f2;
	color: #000;
	border-radius: 3px;
	text-decoration: none;
	border: 1px solid #c5c5c5;
	cursor: pointer;
}
.form_table input.disable {
	color: #ccc;	
}
.form_table .send_sms_notice {
	margin-top: 10px;
	background: url(/views/mobile/skin/blue/images/right.png) 0 3px no-repeat;
	background-size: 13px 13px;
	padding-left: 18px;
	display: none;
}
</style>
</head>
<body class="second" >
	<div class="brand_list container_2">
		<div class="header">
			<h1 class="logo"><a title="<?php echo $siteConfig->name;?>" style="background:url(<?php if($siteConfig->logo){?><?php echo IUrl::creatUrl("")."".$siteConfig->logo."";?><?php }else{?><?php echo $this->getWebSkinPath()."images/front/logo.png";?><?php }?>);" href="<?php echo IUrl::creatUrl("");?>"><?php echo $siteConfig->name;?></a></h1>
			<ul class="shortcut">
				<li class="first"><a href="<?php echo IUrl::creatUrl("/ucenter/index");?>">我的账户</a></li>
				<li><a href="<?php echo IUrl::creatUrl("/ucenter/order");?>">我的订单</a></li>
				<li><a href="<?php echo IUrl::creatUrl("/simple/seller");?>">申请开店</a></li>
				<li><a href="<?php echo IUrl::creatUrl("/seller/index");?>">商家管理</a></li>
		   		<li class='last'><a href="<?php echo IUrl::creatUrl("/site/help_list");?>">使用帮助</a></li>
			</ul>

			<p class="loginfo">
			<?php if($this->user){?>
			<?php echo isset($this->user['username'])?$this->user['username']:"";?>您好，欢迎您来到<?php echo $siteConfig->name;?>购物！[<a href="<?php echo IUrl::creatUrl("/simple/logout");?>" class="reg">安全退出</a>]
			<?php }else{?>
			[<a href="<?php echo IUrl::creatUrl("/simple/login?callback=".$callback."");?>">登录</a><a class="reg" href="<?php echo IUrl::creatUrl("/simple/reg?callback=".$callback."");?>">免费注册</a>]
			<?php }?>
			</p>
		</div>
	    <div class="wrapper clearfix">
	<div class="wrap_box">
		<h3 class="notice">忘记密码</h3>
		<p class="tips">欢迎来到乐享生活，如果忘记密码，请填写下面表单来重新获取密码</p>
		<div class="box">
        
		<form action="<?php echo IUrl::creatUrl("/simple/find_password_mobile/type/1");?>" method="post" id="mobileWay">
			<table class="form_table">
				<colgroup>
					<col width="300px" />
					<col />
				</colgroup>

				<tr><th>用户名：</th><td><input name="username" class="gray" type="text" pattern="required" alt="请输入正确的用户名" /></td></tr>
				<tr><th>手机号：</th><td><input name="mobile" class="gray" type="text" pattern="mobi" alt="请输入正确的手机号码" />
                <input type="button" class="send_sms" value="获取验证码" onclick="sendMessage();"/></td></tr>
				<tr><th>手机验证码：</th><td><input name="mobile_code" class="gray_s" type="text" pattern="required" alt="请输入短信息中验证码" />
                <div class="send_sms_notice">验证码已发送到您的手机，请查收</div>
				</td></tr>
				<tr>
					<td></td>
					<td><input class="submit" type="submit" value="找回密码" /></td>
				</tr>
				<tr><td></td><td><a href="javascript:changeTab()" class="link">电子邮件重置密码</a></td></tr>
			</table>
		</form>
        
		<form action="<?php echo IUrl::creatUrl("/simple/find_password_email/type/1");?>" method="post" id="mailWay" style="display:none">
			<table class="form_table">
				<colgroup>
					<col width="300px" />
					<col />
				</colgroup>

				<tr><th>用户名：</th><td><input name="username" class="gray" type="text" pattern="required" alt="请输入正确的用户名" /></td></tr>
				<tr><th>邮箱：</th><td><input name="email" class="gray" type="text" pattern="email" alt="请输入正确的邮件地址" />
				<input type="hidden" name="type" value="business"/></td></tr>
				<tr>
					<td></td>
					<td><input class="submit" type="submit" value="找回密码" /></td>
				</tr>
				<tr><td></td><td><a href="javascript:changeTab()" class="link">手机短信重置密码</a></td></tr>
			</table>
		</form>

		</div>
	</div>
</div>

<script language="javascript">
var default_time = 60;
var s_count = 60;
var send_status = true;

//短信和邮箱切换
function changeTab()
{
	$('#mailWay').toggle();
	$('#mobileWay').toggle();
}

//发送短信码
function sendMessage()
{
	var username = $('#mobileWay [name="username"]').val();
	var mobile   = $('#mobileWay [name="mobile"]').val();
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
	
	if ( username == '' )
	{
		$('#mobileWay').submit();
		return false;
	}
	if(!myreg.test(mobile))
	{
		$('#mobileWay').submit();
		return false;
	}
	
	if ( s_count == default_time && send_status )
	{				
		$.get("<?php echo IUrl::creatUrl("/simple/send_message_mobile");?>",{"username":username,"mobile":mobile,"type":"business"},function(content){
			if(content == 'success')
			{
				update_sms_status();
				time = setInterval(function(){
					update_sms_status();
				}, 1000);
				$('#mobileWay .send_sms').addClass('disable');
				$('.form_table .send_sms_notice').show();
			}
			else
			{
				alert(content);
				return;
			}
		});
	}
}

function update_sms_status()
{
	if ( s_count > 0 )
	{
		s_count--;
		send_status = false;
		$('#mobileWay .send_sms').attr('disabled',"true");
		$('#mobileWay .send_sms').val('重新发送验证码(' + s_count + ' s)');
		$('#mobileWay .send_sms').css('cursor', 'wait');
	} else {
		s_count = default_time;
		send_status = true;
		clearInterval(time);
		
		$('#mobileWay .send_sms').val('重新发送验证码');
		$('#mobileWay .send_sms').removeAttr("disabled"); 
		$('#mobileWay .send_sms').removeClass('disable');
		$('#mobileWay .send_sms').css('cursor', 'pointer');
	}
}
</script>


		<?php echo IFilter::stripSlash($siteConfig->site_footer_code);?>
	</div>
</body>
</html>
