function showTab(idx, obj){
	$(obj).siblings().removeClass('current');
	$(obj).addClass('current');
	$('.tabbox').addClass('hide');
	$('.tabbox').eq(idx).removeClass('hide');
}

//修改头像
function select_ico()
{

	art.dialog.open( _select_ico_url,
	{
		'id':'user_ico',
		'title':'设置头像',
		'ok':function(iframeWin, topWin)
		{
			iframeWin.document.forms[0].submit();
			return false;
		}
	});
}

//头像上传回调函数
function callback_user_ico(content)
{
	var content = eval(content);
	if(content.isError == true)
	{
		alert(content.message);
	}
	else
	{
		$('#user_ico_img').attr('src',content.data);
	}
	art.dialog({id:'user_ico'}).close();
}
