var default_time = 60;
var s_count = 60;
var send_status = true;

//发送短信码
function sendMessage()
{
	var mobile   = $('#mobileWay [name="mobile"]').val();
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;

	if ( mobile == '')
	{
		mui.toast('手机号码不能为空');
		return false;
	}
	if(!myreg.test(mobile))
	{
		mui.toast('手机号码不正确');
		return false;
	}

	if ( s_count == default_time && send_status )
	{
		$.get(_send_reg,{"mobile":mobile,"type":2},function(content){
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

function check_step_1()
{
	var mobile   = $('#mobileWay [name="mobile"]').val();
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;

	if ( mobile == '')
	{
		mui.toast('手机号码不能为空');
		return false;
	}
	if(!myreg.test(mobile))
	{
		mui.toast('手机号码不正确');
		return false;
	}

	var mobile_code = $('#mobile_code').val();
	if ( mobile_code == '')
	{
		mui.toast('验证码不能为空');
		return false;
	} else {
		$('.tab_1').hide();
		$('.tab_2').fadeIn();
	}
}

function check_step_2()
{
	var seller_name = $('#seller_name').val();
	var passwd = $('input[name=password]').val();
	var repasswd = $('input[name=repassword]').val();

	if ( seller_name == '')
	{
		mui.toast('学校名称不能为空');
		return false;
	} else if ( passwd == '') {
		mui.toast('密码不能为空');
		return false;
	} else if ( repasswd == '') {
		mui.toast('重复密码不能为空');
		return false;
	} else if (passwd != repasswd) {
		mui.toast('两次输入密码不一致');
		return false;
	} else {
		$('.tab_2').hide();
		$('.tab_3').fadeIn();
	}
}
