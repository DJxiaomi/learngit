//DOM加载结束后
$(function(){

  //绑定商品图片
  $('[thumbimg]').bind('click',function()
  {
    $('#picShow').prop('src',$(this).attr('thumbimg'));
    $('#picShow').attr('rel',$(this).attr('sourceimg'));
    $(this).addClass('current');
  });

  $('#buyNums').change(function(){
      calculation_cprice();
  });

	//初始化商品轮换图
	$('#goodsPhotoList').bxSlider({
		infiniteLoop:false,
		hideControlOnEnd:true,
		controls:true,
		pager:false,
		minSlides: 5,
		maxSlides: 5,
		slideWidth: 72,
		slideMargin: 15,
		onSliderLoad:function(currentIndex){
			//默认初始化显示第一张
			$('[thumbimg]:eq('+currentIndex+')').trigger('click');
		}
	});

  // 默认第一项选中
  // $('.receive').on('click',function(){
  //     var _check = checkSpecSelected();
  //     if ( _check != 1)
  //     {
  //       if ( _check == -1 )
  //         alert('请选择课程');
  //       else if ( _check == -2 )
  //         alert('请选择属性');
  //
  //       return false;
  //     }
  //
  //     var _goods_id = get_goods_id();
  //     var _spec_id = get_spec_id();
  //
  //     if ( _spec_id == 0)
  //     {
  //       alert('此课程暂无可用优惠券！');
  //     } else {
  //       var prop = 0;
  //       if ( _goods_list[_goods_id]['product_list'].length > 0 )
  //       {
  //         for( i in _goods_list[_goods_id]['product_list'] )
  //         {
  //           var item = _goods_list[_goods_id]['product_list'][i];
  //           if ( item['id'] == _spec_id && item['goods_id'] == _goods_id )
  //             var prop = item['chit'];
  //         }
  //       }
  //
  //       if(prop > 0){
  //         $.getJSON(SITE_URL + '/site/get_chit_info',{'seller_id':_seller_id,'goods_id':_goods_id,'spec_id':_spec_id},function(content){
  //           if(content){
  //             $('.tochit').find('span').text(prop);
  //             $('.tobuy').find('span').text(content.max_price);
  //             $('.limittime').find('span').text(content.limittime);
  //             $('.chit_info').text(content.limitinfo);
  //             $('.card_left').children('.full').children('span').text($('.ticket_amount').text());
  //             $('.buycard').attr('onclick',"buy_now_ding_card('"+content.id+"', '"+ content.max_price+"')");
  //           }
  //         })
  //
  //         layer.open({
  //           type: 1,
  //           title:false,
  //           closeBtn:1,
  //           area: ['545px', '164px'], //宽高
  //           content: $('.quan')
  //         });
  //       } else {
  //         alert('此课程暂无可用优惠券！');
  //       }
  //     }
  // })

});



function sele_goods(obj)
{
  $('.w_27 a').removeClass('active');
  $(obj).addClass('active');
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
    $('.spec_list').html(_spec_list_html);
  } else {
    $('.spec_list_row').hide();
  }

  get_price();
}
function sele_spec(obj)
{
  $(obj).parent().parent().find('a').removeClass('active');
  $(obj).addClass('active');
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

/*   if ( _goods_list[_goods_id]['active'] !==  false && typeof(_goods_list[_goods_id]['active'] != 'undefined'))
  {
      if ( _goods_list[_goods_id]['active']['promo'] == 'groupon')
        _price_str = parseFloat(_goods_list[_goods_id]['active']['regiment_price']) * num;
      else
        _price_str = parseFloat(_goods_list[_goods_id]['active']['award_value']) * num;
  }
  else  */
  if ( _spec_list.length > 0 )
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

  if(_price_str == 0){
    $('.price').children('p').hide().siblings('.noprice').show();
    $('.ticket').hide();
  }else{
    $('.price').children('.noprice').hide().siblings('p').show();
    $('.ticket').show();
    set_price(_price_str);
  }

}

function set_price(str)
{
  if ( str == _hide_price)
  {
    $('#data_marketPrice').html('<i>' + _hide_price_str + '</i>');
    $('#buyNowButton').hide();
    $('#joinCarButton').hide();
  } else {
    $('#data_marketPrice').html('&yen;' + str);
    $('#buyNowButton').show();
    $('#joinCarButton').show();
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
            layer.alert('请输入正确的数量！');
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
            //recalc();
        } else {
            layer.alert("商品数量最少为" + this.min);
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
            $(obj).val(x);
        } else {
            layer.alert("商品数量最多为" + this.max);
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
            layer.alert("请输入正确的数量！");
            $(obj).val(1);
            $(obj).focus();
            return false;
        }

        get_price();
    }
}

function joinCart()
{
  var _check = checkSpecSelected();
  if ( _check != 1)
  {
    if ( _check == -1 )
      layer.alert("请选择课程");
    else if ( _check == -2 )
      layer.alert("请选择属性");

    return false;
  }

  var _goods_id = get_goods_id();
  var _spec_id = get_spec_id();
  var type = (_spec_id > 0 ) ? 'product' : 'goods';
  var buyNums = get_buy_num();
  var _id = ( type == 'product') ? _spec_id : _goods_id;

  if ( _goods_list[_goods_id]['active'] !== false )
  {
    layer.alert("加入购物车失败，该课程正在进行促销活动，只能立即报名");
    return false;
  }
  $.getJSON(SITE_URL + '/simple/joinCart',{"goods_id":_id,"type":type,"goods_num":buyNums,"random":Math.random},function(content){
    if(content.isError == false)
    {
      layer.alert("加入课表成功");
    } else {
      layer.alert(content.message);
    }
  });
}

function buy_now()
{
  var _check = checkSpecSelected();
  if ( _check != 1)
  {
    if ( _check == -1 )
      layer.alert("请选择课程");
    else if ( _check == -2 )
      layer.alert("请选择属性");

    return false;
  }

  var _goods_id = get_goods_id();
  var _spec_id = get_spec_id();
  var type = (_spec_id > 0 ) ? 'product' : 'goods';
  var id = (_spec_id > 0 ) ? _spec_id : _goods_id;
  var buyNums = get_buy_num();

	/**
  if ( _goods_list[_goods_id]['active'] !==  false )
    var url = SITE_URL + '/simple/cart2n/id/' + id + '/num/' + buyNums + '/type/' + type + '/promo/' + _goods_list[_goods_id]['active']['promo'] + '/active_id/' + _goods_list[_goods_id]['active']['id'];
  else
	  **/
    var url = SITE_URL + '/simple/cart2n/id/' + id + '/num/' + buyNums + '/type/' + type;

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
  return parseInt($('#buyNums').val());
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
  var url = '/simple/cart2d/id/5280/num/@buyNums@/type/product/statement/2/chitid/@chitid@';
  url = url.replace('@chitid@',id).replace('@buyNums@',buyNums);
  window.location.href = SITE_URL + url;
}

function buy_now_ding()
{
  var _check = checkSpecSelected();
  if ( _check != 1)
  {
    if ( _check == -1 )
      layer.alert("请选择课程");
    else if ( _check == -2 )
      layer.alert("请选择属性");

    return false;
  }

  var buyNums  = 1;
  var _goods_id = get_goods_id();
  var _spec_id = get_spec_id();

  if ( _spec_id > 0)
  {
    var url = '/simple/cart22/id/' + _spec_id + '/num/@buyNums@/type/product/statement/3';
  } else {
    var url = '/simple/cart22/id/' + _goods_id + '/num/@buyNums@/type/goods/statement/3';
  }
  url = url.replace('@buyNums@',buyNums);
  window.location.href = SITE_URL + url;
}
