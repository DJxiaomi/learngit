function show_msg(obj,re_time,re_content)
{
    $('#show_msg').css('display','').insertAfter($(obj).parent().parent())
    $('#show_msg #re_time').text(re_time);
    $('#show_msg #re_content').text(re_content);
}
