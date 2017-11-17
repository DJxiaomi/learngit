//DOM加载完毕
$(function(){

	$('.box_tab li ').click(function(){
		var _tt = parseInt($(this).attr('tt'));
		$('.box_tab li ').removeClass('active');
		$(this).addClass('active');

		switch (_tt) {
			case 1:
				var _t1 = '<th>学校名称：</th><td><input class="normal" name="shortname" type="text" pattern="required" alt="请填写学校名称" /><label>* 请填写学校名称</label></td>';
				break;
			case 2:
			var _t1 = '<th>教师名称：</th><td><input class="normal" name="shortname" type="text" pattern="required" alt="请填写教师名称" /><label>* 请填写教师名称</label></td>';
				break;
			default:
				break;
		}
		$('#t1').html(_t1);
		$('input[name=type]').val(_tt);
	})

	// 切换用户类型
	// $('select[name=category_ids]').change(function(){
	// 	var _ids = $(this).val();
	// 	if ( _ids == '16')
	// 	{
	// 		$('#t1 th').html('姓名：');
	// 	} else {
	// 		$('#t1 th').html('学校名称：');
	// 	}
	// })
});

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
		$.get(_send_sms_url,{"mobile":mobile,"type":2},function(content){
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
