$(function(){
	$('input[name="callback"]').val(_callback);
	$(".form_table input").focus(function(){$(this).addClass('current');}).blur(function(){$(this).removeClass('current');})

	//表单回填
	var formObj = new Form();
	formObj.init({"username": _username});
});

function onReg()
{
	var username = $('#username').val();
	var password = $('#password').val();
	// var repassword = $('#repassword').val();
	var mobile = $('#mobile').val();
	var mobile_code = $('#mobile_code').val();
	// var captcha = $('#captcha').val();
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
	var promo_code = $('#promo_code').val();

	if(username == ''){
		layer.alert('请输入用户名')
		return false;
	}

	if(password == ''){
		layer.alert('请输入密码')
		return false;
	}

	if(password.length < 6){
		layer.alert('密码为6-32个字符')
		return false;
	}

	// if(repassword != password){
		// alert('两次密码不一致')
		// return false;
	// }

	if(mobile == ''){
		layer.alert('请输入手机号')
		return false;
	}

	if(!myreg.test(mobile)){
		layer.alert('手机号不正确')
		return false;
	}

	if(mobile_code == ''){
		layer.alert('请输入手机验证码')
		return false;
	}

	// if(captcha == ''){
	// 	layer.alert('请输入验证码')
	// 	return false;
	// }

	$.post( _reg_ajax_url,{username: username, password: password, mobile: mobile, mobile_code: mobile_code, promo_code: promo_code},function(json){
		if(json.msg){
			layer.alert(json.msg);
			return false;
		}else{
			window.location.href = _ucenter_url;
		}
	}, 'json');
}

var default_time = 60;
var s_count = 60;
var send_status = true;

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
		$.get( _send_sms_url,{"mobile":mobile},function(content){
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
