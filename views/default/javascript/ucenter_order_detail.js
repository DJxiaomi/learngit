function check_trade_passwd()
{
	window.location.href = _check_trade_passwd_url;
}

function set_trade_passwd()
{
	layer.confirm('您暂未设置交易密码，是否使用登录密码作为交易密码？', {
  btn: ['使用登录密码','设置交易密码'] //按钮
	}, function(){
	var index = layer.load(1, {
  shade: [0.1,'#fff'] //0.1透明度的白色背景
	});
  $.get( _set_trade_passwd_url, function(data){
		check_trade_passwd();
	});
	}, function(){
  	window.location.href = _update_trade_passwd_url;
	});
}
