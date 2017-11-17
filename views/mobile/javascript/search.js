$(document).ready(function(){
  $('.search_content .close_btn').click(function(){
    $('#keywords').val('');
  });

  $('.search_content .search_form input[type=button]').click(function(){

    var _keywords = $('#keywords').val();
    if ( _keywords == '')
    {
      mui.alert('请输入关键词','提示信息');
      return false;
    } else {
      window.location.href = SITE_URL + 'site/search_list?word=' + _keywords;
    }
  })

  $('.search_icon').click(function(){
	  $('.search_content .search_form input[type=button]').click();
  });

  $('.search_form').find('form').submit(function(){
    var _keywords = $('#keywords').val();
    if ( _keywords == '')
    {
      mui.alert('请输入关键词','提示信息');
      return false;
    }
  })

})
