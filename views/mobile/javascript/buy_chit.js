$(document).ready(function(){
  $('.goods_price input[type=number]').keyup(function(){
    var _sell_price = $(this).val();
    _sell_price = parseFloat(_sell_price);

    if (_sell_price <= 0 || isNaN(_sell_price) )
    {
      $('.goods_rest_price em').html('0元');
      $('.goods_max_order_chit em').html('0元');
      $('.chit_info em').html('0元');
    } else {
      max_order_chit = _sell_price * rate;
      max_order_chit = max_order_chit.toFixed(0);
      max_order_chit = parseFloat(max_order_chit);
      max_price = max_order_chit / 2;

      var _price_diff = _sell_price - max_order_chit;
      $('.goods_rest_price em').html(_price_diff + '元');
      $('.goods_max_order_chit em').html(max_order_chit + '元');
      $('.chit_info em').html(max_price + '元');
    }
  });
})

document.getElementById("mui-btn-primary").addEventListener('tap',function(){
  if (max_price <= 0 )
  {
    mui.alert('请输入正确的课程学费');
    return false;
  } else {
    var brand_chit_id = $('input[name=brand_chit_id]').val();
    var type = $('input[name=type]').val();
    var id = $('input[name=id]').val();
    var sell_price = $('.goods_price input[type=number]').val();
    var url = creatUrl('/simple/cart2d/id/5280/num/1/type/product/dprice/' + max_price + '/goods_type/' + type + '/goods_id/' + id + '/goods_sell_price/' + sell_price);
    location.href = url;
  }
})
