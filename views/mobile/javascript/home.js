var swiper = new Swiper('.swiper-container', {
    loop : true,
    autoplay: 3000,
    autoHeight: true
});
var swiper2 = new Swiper('.swiper-container2', {
    loop : true,
    autoplay: 3000,
});

$(function(){
  var width = $('.class_description_list').find('li').innerWidth();
  $('.class_description_list').find('li').innerHeight(width);

  $('.receive').on('click',function(){

      var _check = checkSpecSelected();
      if ( _check != 1)
        {
        if ( _check == -1 )
          mui.alert("请选择课程", '提示信息');
        else if ( _check == -2 )
          mui.alert("请选择属性", '提示信息');

         return false;
      }
      var _goods_id = get_goods_id();
      var _spec_id = get_spec_id();

      // if ( _spec_id == 0)
      // {
      //   mui.alert("此课程暂无可用优惠券！", '提示信息');
      // } else {
      //
      // }


      var prop = 0;
      if ( _spec_id == 0)
      {
        if ( _goods_list[_goods_id]['product_list'].length == 0 && _goods_list[_goods_id]['chit'] > 0 && _goods_list[_goods_id]['max_price'] > 0 )
        {
          prop = _goods_list[_goods_id]['chit'];
        }
      } else {
        if ( _goods_list[_goods_id]['product_list'].length > 0 )
        {
          for( i in _goods_list[_goods_id]['product_list'] )
          {
            var item = _goods_list[_goods_id]['product_list'][i];
            if ( item['id'] == _spec_id && item['goods_id'] == _goods_id )
              var prop = item['chit'];
          }
        }
      }

      if(prop > 0){
        $.getJSON(creatUrl('site/get_chit_info'),{'seller_id':_seller_id,'goods_id':_goods_id,'spec_id':_spec_id},function(content){
          if(content){
            $('.tochit').find('span').text('抵用' + content.max_order_chit + '元');
            $('.tobuy').find('span').text(content.max_price);
            $('.chit_info').text(content.limitinfo);
            $('.card_left').children('.full').children('span').text($('.ticket_amount').text());
            $('.buycard').attr('onclick',"buy_now_ding_card('"+content.id+"', '"+ content.max_price+"')");
          }
        })

        layer.open({
          type: 1,
          title:'代金券',
          style:'width:90%;overflow:hidden;',
          btn:['购买','关闭'],
          content: $('.quan').html(),
          yes:function(){
            $('.buycard').click();
          }
        });
      }else if(prop < 0){
        layer.open({
          content: '此课程暂无可用优惠券！'
          ,skin: 'msg'
          ,time: 2
        });
      }else{
        layer.open({
          content: '请先选择课程！'
          ,skin: 'msg'
          ,time: 2
        });
      }




  })
})

function sele_goods(obj)
{
	$(obj).parent().find('a').removeClass('current');
  $(obj).addClass('current');
  var _goods_id_t = $(obj).attr('_id');
  set_goods_id(_goods_id_t);
  set_spec_id(0);

  // 获取属性列表
  var _spec_list = _goods_list[_goods_id_t]['product_list'];
  var _spec_list_html = '';
  if (_spec_list.length > 0 )
  {
    for( var i in _spec_list )
    {
	  if ( _spec_list.length == 1 && _spec_list[i]['cusval'] == '' && _spec_list[i]['classnum'] == '' && _spec_list[i]['month'] == '')
	  {
		 _spec_list[i]['cusval'] = $(obj).html();
	  }
      _spec_list_html += template.render('spec_list_template',_spec_list[i]);
    }

    $('.spec_list_row').show();
    $('.specs').html(_spec_list_html);

	$('.pop_contents .spec_list .bd').html(_spec_list_html);
  } else {
    $('.spec_list_row').hide();
  }

  get_price();
}
function sele_spec(obj)
{
  $(obj).parent().find('a').removeClass('current');
  $(obj).addClass('current');
  var _spec_id = $(obj).attr('_spec');
  set_spec_id(_spec_id);
  get_price();
}
function get_price()
{
  var _goods_id = get_goods_id();
  var _spec_id = get_spec_id();
  if ( _goods_id <= 0 )
  {
    console.log('无价格');
  }

  if (_goods_id <= 0 )
    return false;

  var _spec_list = _goods_list[_goods_id]['product_list'];
  var _price_str = '';
  var num = get_buy_num();

  if ( _goods_list[_goods_id]['active'] !==  false && _goods_list[_goods_id]['active'] !==  undefined)
  {
      if ( _goods_list[_goods_id]['active']['promo'] == 'groupon')
        _price_str = parseFloat(_goods_list[_goods_id]['active']['regiment_price']) * num;
      else
        _price_str = parseFloat(_goods_list[_goods_id]['active']['award_value']) * num;
  }
  else if ( _spec_list.length > 0 )
  {
    var min = 0
    var max = 0;
    for( j in _spec_list )
    {
      price = parseFloat(_spec_list[j]['sell_price']);
      price = price * num;
      if ( _spec_id > 0 && _spec_list[j]['id'] == _spec_id )
      {
        min = price;
        max = price;

        break;
      } else {
        if ( price > 0 )
        {
          if ( !min )
            min = price;

          if ( !max )
            max = price;

          if ( min && price < min )
            min = price;

          if ( max && price > max )
            max = price;
        }
      }
    }

    _price_str = (min != max ) ? min + '-' + max : min;
  } else {
    _price_str = parseFloat(_goods_list[_goods_id]['sell_price']) * num;
  }

  $.getJSON(creatUrl('site/get_current_chit'),{'seller_id':_seller_id,'goods_id':_goods_id,'spec_id':_spec_id},function(content){
    if(content == ''){
       $('.prop').val('-1');
       $('.tickett').hide();
    }else{
      $('.tickett').show();
      $('.ticket_prop').html(content.max_order_chit);
      //$('.tickett a').attr('src',creatUrl('/simple/cart2d/id/5280/num/1/type/product/chitid/' + content.id));
    }
  })

  set_price(_price_str);
}

function set_price(str)
{
  $('.goodsprice i').html(str);
  $('.pop_contents .goods_price i').html(str);
}

function save()
{
	var _check = checkSpecSelected();
	if ( _check != 1)
  	{
		if ( _check == -1 )
		  mui.alert("请选择课程", '提示信息');
		else if ( _check == -2 )
		  mui.alert("请选择属性", '提示信息');

		 return false;
	} else {
		if ( _action == 'join' )
		{
			joinCart();
		} else {
			buy_now();
		}
	}
}

/* reduce_add */
var setAmount = {
    min:1,
    max:999,
    reg:function(x) {
        return new RegExp("^[1-9]\\d*$").test(x);
    },
    amount:function(obj, mode) {
        var x = $(obj).val();
        if (this.reg(x)) {
            if (mode) {
                x++;
            } else {
                x--;
            }
        } else {
            mui.alert('请输入正确的数量！', '提示信息');
            $(obj).val(1);
            $(obj).focus();
            return false;
        }
        return x;
    },
    reduce:function(obj) {
        var x = this.amount(obj, false);
        if (x >= this.min) {
            $(obj).val(x);
			$('input[name=qty_item_2]').val(x);
        } else {
            mui.alert("商品数量最少为" + this.min, '提示信息');
            $(obj).val(1);
            $(obj).focus();
            return false;
        }

        get_price();
    },
    add:function(obj) {
        var x = this.amount(obj, true);
        var _goods_id = get_goods_id();
        if ( _goods_id > 0  && _goods_list[_goods_id] != 'undefined')
          this.max = _goods_list[_goods_id]['store_nums'];
        if (x <= this.max) {
			console.log(x);
            $(obj).val(x);
			$('input[name=qty_item_2]').val(x);
        } else {
            mui.alert("商品数量最多为" + this.max, '提示信息');
            $(obj).val(this.max);
            $(obj).focus();
            return false;
        }
        get_price();
    },
    modify:function(obj) {
        var x = $(obj).val();
        var _goods_id = get_goods_id();
        if ( _goods_id > 0  && _goods_list[_goods_id] != 'undefined')
          this.max = _goods_list[_goods_id]['store_nums'];

        if (x < this.min || x > this.max || !this.reg(x)) {
            mui.alert("请输入正确的数量！", '提示信息');
            $(obj).val(1);
            $(obj).focus();
            return false;
        }

        get_price();
    }
}

function check_spec()
{
  var _check = checkSpecSelected();
  if ( _check != 1)
  {
/*    if ( _check == -1 )
      mui.alert("请选择课程", '提示信息');
    else if ( _check == -2 )
      mui.alert("请选择属性", '提示信息');*/

	 //页面层
	 layer.open({
	 	type: 1
		,content: $('.pop_content').html()
		,anim: 'up'
		,style: 'position:fixed; bottom:0; left:0; width: 100%; height: 400px; padding:0px 0; border:none;'
	});

    return false;
  }
  return true;
}

function joinCart()
{
  if ( !check_spec() )
  {
  	_action = 'join';
	return false;
  }

  var _goods_id = get_goods_id();
  var _spec_id = get_spec_id();
  var type = (_spec_id > 0 ) ? 'product' : 'goods';
  var buyNums = get_buy_num();
  var _id = ( type == 'product') ? _spec_id : _goods_id;

  if ( _goods_list[_goods_id]['active'] !== false && _goods_list[_goods_id]['active'] !== undefined )
  {
    mui.alert("加入购物车失败，该课程正在进行促销活动，只能立即报名", '提示信息');
    return false;
  }
  $.getJSON(creatUrl('/simple/joinCart'),{"goods_id":_id,"type":type,"goods_num":buyNums,"random":Math.random},function(content){
    if(content.isError == false)
    {
      mui.alert("加入课表成功", '提示信息');
    } else {
      mui.alert(content.message, '提示信息');
    }
  });
}

function buy_now()
{
  if ( !check_spec() )
  {
  	_action = 'buy';
	return false;
  }

  var _goods_id = get_goods_id();
  var _spec_id = get_spec_id();
  var type = (_spec_id > 0 ) ? 'product' : 'goods';
  var id = (_spec_id > 0 ) ? _spec_id : _goods_id;
  var buyNums = get_buy_num();

  if ( _goods_list[_goods_id]['active'] !==  false && _goods_list[_goods_id]['active'] !==  undefined )
    var url = creatUrl('/simple/cart2n/id/' + id + '/num/' + buyNums + '/type/' + type + '/promo/' + _goods_list[_goods_id]['active']['promo'] + '/active_id/' + _goods_list[_goods_id]['active']['id'] );
  else
    var url = creatUrl('/simple/cart2n/id/' + id + '/num/' + buyNums + '/type/' + type);
  location.href = url;
}

function checkSpecSelected()
{
  var _goods_id = get_goods_id();
  var _spec_id = get_spec_id();
  if ( !_goods_id )
    return -1;

  var _spec_list = _goods_list[_goods_id]['product_list'];
  if ( _spec_list.length > 0 && !_spec_id )
    return -2;

  return true;
}

function get_buy_num()
{
  return parseInt($('#qty_item_1').val());
}

function set_goods_id(goods_id)
{
  _goods_id = goods_id
}

function set_spec_id(spec_id)
{
  _spec_id = spec_id
}
function get_goods_id()
{
  return _goods_id;
}

function get_spec_id()
{
  return _spec_id;
}

function buy_now_ding_card(id, _input_dprice){
  var buyNums  = 1;
  var url = creatUrl('/simple/cart2d/id/5280/num/' + buyNums + '/type/product/chitid/' + id);
  window.location.href = url;
}
