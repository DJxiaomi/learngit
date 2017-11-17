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
		$.get( _send_sms_url,{"username":username,"mobile":mobile,"type":'user'},function(content){
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
