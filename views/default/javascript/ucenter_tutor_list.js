$(document).ready(function(){
  $('.del_btn').click(function(){
    if(confirm('您确定要删除这条信息吗?'))
    {
      var _id = $(this).attr('_id');
      var _url = _del_url + '/' + _id
      window.location.href = _url;
    }
  })

  $('.publish_btn').click(function(){
    if (!_is_auth)
    {
      if(confirm('您尚未通过实名认证，是否先进行实名认证再发布家教信息'))
      {
          location.href = _auth_url;
      }
    } else {
      if ( confirm('您确认要发布该信息吗?'))
      {
          var _id = $(this).attr('_id');
          var _url = _publish_url.replace('@id@',_id);
          location.href = _url;
      }
    }
  })
})
