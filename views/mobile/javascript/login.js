//DOM加载结束
$(function(){
	$(document).keyup(function(e){
		var key =  e.which || e.keyCode;
		if(key == 13){
			onlogin();
		}
	});

  //回调地址设置
  $('input[name="callback"]').val(_callback);
  $('.reg_btn').attr('href', _reg_url);
  $(".form_table input").focus(function(){$(this).addClass('current');}).blur(function(){$(this).removeClass('current');})
})
function onlogin(){
	var login_info = $('#login_info').val(),
		password = $('#password').val(),
		remember = $('input[type="checkbox"][name="remember"]:checked').val();
	if(login_info == ''){
		$('#tip').html('请输入用户名/邮箱/手机号');
		return false;
	}
	if(password == ''){
		$('#tip').html('请输入密码');
		return false;
	}
	$.post( _login_url, {login_info: login_info, password: password, remember: remember}, function(json) {
		if(json.msg){
			$('#tip').html(json.msg);
			return false;
		}else{
			if ( _this_callback)
				window.location.href = _this_callback;
			else
				window.location.href = json.back;
		}
	}, 'json');
}

//多平台登录
function oauthlogin(oauth_id)
{
	$.getJSON( _oauth_login_url,{"id":oauth_id,"callback":_callback},function(content){
		if(content.isError == false)
		{
			window.location.href = content.url;
		}
		else
		{
			alert(content.message);
		}
	});
}
