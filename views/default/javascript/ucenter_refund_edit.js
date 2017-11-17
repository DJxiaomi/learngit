//编辑器载入
KindEditorObj = KindEditor.create('#content',
{
	items : [
		'fontsize', '|', 'forecolor','bold', 'italic', 'underline',
		'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
		'insertunorderedlist', '|', 'emoticons', 'image', 'link']
});

//提交表单检查
function checkForm()
{
	if($('#content').val() == '')
	{
		alert('请填写退款原因');
		return false;
	}

  if ($('#mobile_code').val() == '')
  {
    alert('请填写手机验证码');
    return false;
  }

	if($('[name="order_goods_id[]"]:checked').length == 0)
	{
		alert('请选择要退款的课程');
		return false;
	}
	return true;
}


//发送短信码
function sendMessage()
{
	if ( s_count == default_time && send_status )
	{
		$.getJSON( _get_refund_sms_url,{"order_id":_order_id},function(response){
      if ( response.done !== false )
      {
        update_sms_status();
        time = setInterval(function(){
          update_sms_status();
        }, 1000);
        $('.send_sms').addClass('disable');
        $('.send_sms_notice').show();
      } else {
        alert(response.msg);
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
		$('.send_sms').attr('disabled',"true");
		$('.send_sms').val('重新发送验证码(' + s_count + ' s)');
		$('.send_sms').css('cursor', 'wait');
	} else {
		s_count = default_time;
		send_status = true;
		clearInterval(time);

		$('.send_sms').val('重新发送验证码');
		$('.send_sms').removeAttr("disabled");
		$('.send_sms').removeClass('disable');
		$('.send_sms').css('cursor', 'pointer');
	}
}
