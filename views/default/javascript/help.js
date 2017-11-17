$(document).ready(function()
{
  $('.help_c .hc_title').click(function(){
    var _show_list = $(this).attr('show_list');
    if ( _show_list == '1')
    {
      set_show_list($(this),0);
    } else {
      set_show_list($(this),1);
    }
  });

  $('.help_search input[name=btn]').click(function(){
    var key = $(".help_search input[name=key]").val();
    if ( key == '请输入关键词' || key == '')
    {
      layer.alert('请输入关键词');
	  return false;
    } else {
      window.location.href =  'http://' + SITE_URL + '/site/help_list?key=' + key;
    }
  })
})

function set_show_list(obj, type)
{
  if ( type == 0 )
  {
    obj.find('i').html('+');
    obj.next('.m_10').addClass('hide');
  } else {
    obj.find('i').html('-');
    obj.next('.m_10').removeClass('hide');
  }
  obj.attr('show_list', type);
}
