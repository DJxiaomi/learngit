$(document).ready(function(){

  // 加入购物车
  $('.join_cart').click(function(){
    var _dqk_id = get_dqk_id();
    if ( _dqk_id <= 0 )
    {
      mui.toast('请选择短期课');
      return false;
    }
    $.get(dqk_join_ajax,{id:_dqk_id},function(result){
      if ( result == '1')
      {
        mui.alert('加入购物车成功','提示信息',function(){
          var is_notice = getCookie('is_notice');
          if (!is_notice)
          {
            $('.tocart_notice').show();
            setCookie('is_notice',true);
          }
        });
      } else {
        if ( result == '请先登录')
        {
          mui.confirm('您暂未登录，是否先登录？', '提示信息', ['再看一会', '马上登录'], function(e) {
              if (e.index == 1) {
                var url = creatUrl('/simple/login');
                url += '?callback=/site/chit1_detail/id/' + id + '/type/' + type;
                location.href = url;
              }
          });
        } else {
          mui.alert(result);
        }
      }
    })
  });

  // 立即购买
  $('.go_buy').click(function(){
    if ( parseInt(user_id) <= 0 )
    {
      mui.confirm('您暂未登录，是否先登录？', '提示信息', ['再看一会', '马上登录'], function(e) {
          if (e.index == 1) {
            var url = creatUrl('/simple/login');
            url += '?callback=/site/chit1_detail/id/' + id + '/type/' + type;
            location.href = url;
          }
      });
      return false;
    }
    var _dqk_id = get_dqk_id();
    if ( _dqk_id <= 0 )
    {
      mui.toast('请选择短期课');
      return false;
    }

    go_buy_url = go_buy_url.replace('@ids@', _dqk_id);
    location.href = go_buy_url;
  });

  // 使用手册
  $('.use_manual').click(function(){
    if ( parseInt(user_id) <= 0 )
    {
      mui.confirm('您暂未登录，是否先登录？', '提示信息', ['再看一会', '马上登录'], function(e) {
          if (e.index == 1) {
            var url = creatUrl('/simple/login');
            url += '?callback=/site/chit1_detail/id/' + id + '/type/' + type;
            location.href = url;
          }
      });
      return false;
    }
    var _dqk_id = get_dqk_id();

    if ( _dqk_id <= 0 )
    {
      mui.toast('请选择短期课');
      return false;
    }

    choose_manual_url = choose_manual_url.replace('@dqk_id@',_dqk_id);
    location.href = choose_manual_url;
  })

  // 选择手册
  $(document).on('click','.choose_manual_list li',function(){
    $(this).parent().find('li').removeClass('active');
    $(this).addClass('active');
    var _id = $(this).attr('id');
    manual_id = _id;
  })

  $('.dqk_list a').click(function(){
    $('.dqk_list a').removeClass('current');
    $(this).addClass('current');
    var _id = $(this).attr('id');
    set_dqk_id(_id);
    get_dqk_info_by_id(_id);
    $('.content_module .bd .price em').html(dqk_info.max_price);
    if ( parseFloat(dqk_info.market_price) > 0)
      $('.content_module .bd .price .market_price').html('原价:<em>' + dqk_info.market_price + '</em>');
    else
      $('.content_module .bd .price .market_price').html('');

    if ( parseFloat(dqk_info.max_price) > parseFloat(dqk_info.tc_price) )
    {
      var diff_price = parseFloat(dqk_info.max_price) - parseFloat(dqk_info.tc_price);
      diff_price = diff_price.toFixed(2);
      $('.content_module .bd .notice').html('该短期课搭配其它课程一起购买，减' + diff_price + '元');
      $('.content_module .bd .notice').show();
    } else {
      $('.content_module .bd .notice').hide();
    }

    $('.content_module .bd .classnum span').html(dqk_info.use_times);
    if ( dqk_info.class_time != '')
    {
      $('.content_module .bd .use_time').show();
      $('.content_module .bd .use_time span').html(dqk_info.class_time);
    }
    else
    {
      $('.content_module .bd .use_time').hide();
    }

    if ( dqk_info.is_booking == 1)
    {
      $('.content_module .bd .appointment span').html(dqk_info.booking_desc);
    } else {
      $('.content_module .bd .appointment span').html('不需要预约');
    }

    if ( dqk_info.limittime != '')
    {
      $('.content_module .bd .limit_time span').html(dqk_info.limittime);
    } else {
      $('.content_module .bd .limit_time').hide();
    }

    if ( dqk_info.age_grade != '')
    {
      $('.content_module .bd .age_limit span').html(dqk_info.age_grade);
    } else {
      $('.content_module .bd .age_limit').hide();
    }

    if ( dqk_info.limitinfo != '')
    {
      $('.content_module .bd .use_notice span').html(dqk_info.limitinfo);
    } else {
      $('.content_module .bd .use_notice').hide();
    }

    if ( type == 2 && dqk_info.other_pay != '')
    {
        $('.content_module .bd .other_pay').html('其它费用：商户需要额外收取' + dqk_info.other_pay + '元/次');
        $('.content_module .bd .other_pay').show();
    } else {
      $('.other_pay').hide();
    }
  });

  $('.dqk_list a').eq(0).click();

  $('.tocart_notice').click(function(){
    $(this).hide();
  })


  $('.promote_tips').click(function(){
    layer.open({
      type: 1,
      title:'推广信息',
      style:'width:90%;overflow:hidden;',
      content: $('.promote_content').html(),
    });
    $('.promote_btn .mui-btn-primary').click(function(){
      layer.closeAll();
    })
  });

  // 预约功能
  if ( type == 2)
  {
    $('.make_appointment').click(function(){
      if ( manual_id <= 0 )
      {
        mui.alert('只有学习通会员才可以预约哦');
        return false;
      }
      layer.open({
        content: '<div class="appointment_content">'+
                  '<div class="hd">预约详情</div>'+
                  '<div class="bd">'+
                    '<table width="100%" border="0" cellpadding="0" cellspacing="0">' +
                    '<tr>' +
                    '<td>姓名：</td>' +
                    '<td><input type="text" name="username" value="' + manual_parents_name + '" /></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>电话：</td>' +
                    '<td><input type="text" name="mobile" value=" ' + manual_parents_tel + '" /></td>' +
                    '</tr>' +
                    '</table>' +
                  '</div>' +
                '</div>'
        ,btn: ['我要预约', '取消']
        ,yes: function(index){
          var parent_name = $('.appointment_content input[name=username]').val();
          var parent_tel = $('.appointment_content input[name=mobile]').val();
          layer.close(index);
          if ( parent_name == '')
          {
            mui.alert('请填写姓名');
          } else if ( parent_tel == '') {
            mui.alert('请填写手机号码');
          } else {
            var _dqk_id = get_dqk_id();
            $.post(appointment_ajax_url,{id:_dqk_id,parents_name:parent_name,parents_tel:parent_tel,manual_id:manual_id},function(result){
              if ( result.done )
              {
                mui.alert('预约成功');
              } else {
                mui.alert('预约失败，' + result.msg);
              }
            },'JSON');
          }
        }
      });
    });
  }
})

function get_dqk_id()
{
  return dqk_id;
}

function set_dqk_id(id)
{
  dqk_id = id;
}

function get_dqk_info_by_id(id)
{
  mui.each(dqk_list,function(index,item){
    if (id == item.id)
    {
      dqk_info = item;
      return ;
    }
  })
}

//设置cookie
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
//获取cookie
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
    }
    return "";
}
//清除cookie
function clearCookie(name) {
    setCookie(name, "", -1);
}
