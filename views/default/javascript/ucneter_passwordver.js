var default_time = 60;
var s_count = 60;
var send_status = true;

//发送短信码
function sendMessage()
{
	var mobile = $('#mobile').val();
	var mobile_code   = $('#mobile_code').val();
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;

	if(!myreg.test(mobile))
	{
		$('#mobile').focus();
		return false;
	}

	if ( s_count == default_time && send_status )
	{
		$.get( _send_sms_url,{"mobile":mobile, "type":3},function(content){
			if(content == 'success')
			{
				update_sms_status();
				time = setInterval(function(){
					update_sms_status();
				}, 1000);
				$('#vbtn').addClass('btn-disable');
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
		$('#sendsms').addClass('btn-disable');
		$('#sendsms').html(s_count + '秒后重新发送');
	} else {
		s_count = default_time;
		send_status = true;
		clearInterval(time);

		$('#sendsms').removeClass('btn-disable');
		$('#sendsms').html('重新发送验证码');
	}
}
