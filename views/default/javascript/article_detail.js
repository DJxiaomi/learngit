jQuery(".sideBox").slide( { mainCell:".bd ul",autoPlay:true, delayTime:0} );
function checkReply()
{
  var _content = $('#reply_content').val();
  var _captcha = $('#captcha').val();

  if ( _content == '')
  {
    layer.alert('请输入回复的内容', {icon: 2});
  } else if ( _captcha == '')
  {
    layer.alert('请输入验证码', {icon: 2});
  } else if ( _captcha.length != 5 )
  {
    layer.alert('验证码不合法', {icon: 2});
  } else {
    $('#form_reply').submit();
  }
}
