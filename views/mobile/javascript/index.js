function show_intro_shop(obj, area_id)
{
  $(obj).parent().parent().find('li').removeClass('active');
  $(obj).parent().addClass('active');

  $('.goodslist .bd ul').each(function(i){
    var _id = $(this).attr('_id');
    if ( _id == area_id )
      $(this).show();
    else
      $(this).hide();
  })
}

function show_intro_dqk(obj, area_id)
{
  $(obj).parent().parent().find('li').removeClass('active');
  $(obj).parent().addClass('active');

  $('.dqk_list .bd ul').each(function(i){
    var _id = $(this).attr('_id');
    if ( _id == area_id )
      $(this).show();
    else
      $(this).hide();
  })
}

function check_search()
{
  var _keyword = $('.layui-m-layercont input[name=keywords]').val();
  if ( _keyword == '')
  {
    mui.alert('请输入关键词');
    return false;
  } else {
    return true;
  }
}

function close_pop_search()
{
  layer.closeAll();
}

function search_cc(_type)
{
  if ( !check_search())
  {
    return false;
  }

  var _keyword = $('.layui-m-layercont input[name=keywords]').val();
  switch(_type)
  {
    case 'seller':
      var url = '/site/brand?keywords=' + _keyword;
      break;
    case 'goods':
      var url = '/site/pro_list?keywords=' + _keyword;
      break;
    default:
      var url = '/site/chit1?keywords=' + _keyword;
      break;
  }
  location.href = url;
}

$(document).ready(function(){
  $('input[type=button]').click(function(){
    $('#search_form').submit();
  });

  $('#keywords2').focus(function(){
    $('#keywords2').blur();
    layer.open({
   	 	type: 1
   		,content: $('.pop_search_content').html()
   		,anim: 'up'
   		,style: 'position:fixed; bottom:0; left:0; width: 100%; height: 100%; padding:0px 0; border:none;z-index:99;'
   	});
    $('.layui-m-layercont input[name=keywords]').focus();
  });
})
