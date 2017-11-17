document.getElementById("mui-btn-primary").addEventListener('tap',function(){
  var price = get_price();
  var id = $('input[name=id]').val();
  if ( price <= 0 || isNaN(price))
  {
    mui.alert('请输入正确的支付金额');
    return false;
  } else {
    var url = creatUrl('/simple/cart2r/id/' + _receipt_goods_id + '/type/goods/num/1/seller_id/' + id + '/dprice/' + price);
    location.href = url;
  }
});

function get_price()
{
  var price = $('input[name=price]').val();
  price = parseFloat(price);
  price = price.toFixed(2);
  return price;
}

function set_discount(discount)
{
  _discount = discount;
  $('.goods_max_order_chit em').html(discount + '元');

  var price = get_price();
  var rest_price = price - discount;
  $('.goods_rest_price em').html(rest_price + '元');
}

$(document).ready(function(){
  $('.goods_price input[type=number]').keyup(function(){
    var price = get_price();
    var is_update = false;
    mui.each(_seller_discount_list,function(index,item){
      if(parseFloat(price) >= parseFloat(item.start_price) && parseFloat(item.discount) > parseFloat(_discount))
      {
        is_update = true;
        set_discount(item.discount);
      }
    })
    if ( !is_update )
    {
      set_discount(0);
    }
  });

  $('input[name=price]').val('');
})
