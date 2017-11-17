$(document).ready(function(){
  $('.action a').click(function(){
    var _id = $(this).attr('id');
    var _count = $(this).html();
    var _obj = $(this);

    $.post(_thumb_url,{id:_id}, function(result){
      if (result != '1')
      {
        if ( result == '0')
        {
          mui.toast('您已经点过赞了，请勿重复操作');
        } else {
          mui.toast('请先登录');
        }
      } else {
        mui.toast('点赞成功');
        _count++;
        _obj.html(_count);
        _obj.css('backgroundImage','url(/views/mobile/skin/blue/images/thumb2.png)');
      }
    })
  })

  $('.article_action a').click(function(){
    var _id = $(this).attr('id');
    var _count = $(this).html();
    var _obj = $(this);

    $.post(_article_thumb_url,{id:_id}, function(result){
      if (result != '1')
      {
        if ( result == '0')
        {
          mui.toast('您已经点过赞了，请勿重复操作');
        } else {
          mui.toast('请先登录');
        }
      } else {
        mui.toast('点赞成功');
        _count++;
        _obj.html(_count);
        _obj.css('backgroundImage','url(/views/mobile/skin/blue/images/thumb2.png)');
      }
    })
  })
})
