$(function(){
  $('.checkout').click(function(){
    var _id = $(this).attr('id');
    var _url = "{url:/ucenter/check_out_prop/id/@prop_id@/page/$page}";
    _url = _url.replace('@prop_id@', _id );
    document.location.href = _url;
  })

  $('#search').hideseek();

  $('input[name=seller_id]').on('focus',function(){
    $('.default_list').slideDown();
  }).on('blur',function(){
    $('.default_list').slideUp();
  })

  $('.default_list').children('li').on('click',function(){
    var obj = $(this).parent().siblings('input[name=seller_id]');
    obj.val($(this).text());
    obj.attr('data-id',$(this).data('id'));
  })

  $('.order_confirm').on('click',function(){
    var order_id = $(this).data('id');
    var url = $(this).data('url');
    $('.confirm').find('input[name=order_id]').val(order_id);
    $('.confirm').find('input[name=url]').val(url);
    $.getJSON('/ucenter/get_order_info',{'order_id':order_id},function(content){
      if(content.status == 1){
        $('.confirm').find('input[name=student_name]').val(content.info.student_name);
        $('.confirm').find('input[name=accept_name]').val(content.info.accept_name);
        $('.confirm').find('input[name=mobile]').val(content.info.mobile);
      }
    })
    layer.open({
      type: 1,
      title:'确认信息',
      skin: 'layui-layer-rim',
      area: ['600px', '320px'],
      content: $('.confirm')
    });
  })

  $('.confirm_submit').children('input').on('click',function(){
    var seller_id = $('input[name=seller_id]').attr('data-id');
    var pwd = $('.ch_pwd').val();
    var order_id = $(this).siblings('input[name=order_id]').val();
    var _url = $(this).siblings('input[name=url]').val();
    var accept_name = $('input[name=accept_name]').val();
    var student_name = $('input[name=student_name]').val();
    var mobile = $('input[name=mobile]').val();

    if( seller_id == '' ){
      layer.alert('请选择商户！',{icon:2});
      return false;
    }
    if( pwd == '' ){
      layer.alert('请输入交易密码！',{icon:2});
      return false;
    }
    var rData = 'seller_id='+seller_id+'&pwd='+pwd+'&order_id='+order_id+'&accept_name='+accept_name+'&student_name='+student_name+'&mobile='+mobile;
    $.getJSON('{url:ucenter/check_trade_pwd}',rData,function(data){
      if(data.status == 1){
        window.location.href = _url;
      }else{
        layer.alert(data.info,{icon:2});
      }
    })
  })
})