$(document).ready(function(){
  $('.del_btn').click(function(){
    if(confirm('您确定要删除这条信息吗?'))
    {
      var _id = $(this).attr('_id');
      var _url = _del_url + '/' + _id
      window.location.href = _url;
    }
  })
})
