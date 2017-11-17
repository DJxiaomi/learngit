function show_msg(obj,title,content,admin,re_time,re_content)
{
	var show = '';
	if(re_content=='') show = 'none';
    $('#show_msg').css('display','').insertAfter($(obj).parent().parent());
    $('#show_msg #title').text(title);
    $('#show_msg #content').text(content);
    $('#show_msg #re_info').css('display',show);
    $('#show_msg #admin').text(admin);
    $('#show_msg #re_time').text(re_time);
    $('#show_msg #re_content').text(re_content);
}
