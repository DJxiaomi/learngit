/** jQuery Calculation Plug-in**/
(function($) {
    var defaults = {reNumbers: /(-|-\$)?(\d+(,\d{3})*(\.\d{1,})?|\.\d{1,})/g, cleanseNumber: function (v) {
        return v.replace(/[^0-9.\-]/g, "");
    }, useFieldPlugin: (!!$.fn.getValue), onParseError: null, onParseClear: null};
    $.Calculation = {version: "0.4.07",setDefaults: function(options) {
        $.extend(defaults, options);
    }};
    $.fn.parseNumber = function(options) {
        var aValues = [];
        options = $.extend(options, defaults);
        this.each(function () {
            var $el = $(this),sMethod = ($el.is(":input") ? (defaults.useFieldPlugin ? "getValue" : "val") : "text"),v = $.trim($el[sMethod]()).match(defaults.reNumbers, "");
            if (v == null) {
                v = 0;
                if (jQuery.isFunction(options.onParseError)) options.onParseError.apply($el, [sMethod]);
                $.data($el[0], "calcParseError", true);
            } else {
                v = options.cleanseNumber.apply(this, [v[0]]);
                if ($.data($el[0], "calcParseError") && jQuery.isFunction(options.onParseClear)) {
                    options.onParseClear.apply($el, [sMethod]);
                    $.data($el[0], "calcParseError", false);
                }
            }
            aValues.push(parseFloat(v, 10));
        });
        return aValues;
    };
    $.fn.calc = function(expr, vars, cbFormat, cbDone) {
        var $this = this, exprValue = "", precision = 0, $el, parsedVars = {}, tmp, sMethod, _, bIsError = false;
        for (var k in vars) {
            expr = expr.replace((new RegExp("(" + k + ")", "g")), "_.$1");
            if (!!vars[k] && !!vars[k].jquery) {
                parsedVars[k] = vars[k].parseNumber();
            } else {
                parsedVars[k] = vars[k];
            }
        }
        this.each(function (i, el) {
            var p, len;
            $el = $(this);
            sMethod = ($el.is(":input") ? (defaults.useFieldPlugin ? "setValue" : "val") : "text");
            _ = {};
            for (var k in parsedVars) {
                if (typeof parsedVars[k] == "number") {
                    _[k] = parsedVars[k];
                } else if (typeof parsedVars[k] == "string") {
                    _[k] = parseFloat(parsedVars[k], 10);
                } else if (!!parsedVars[k] && (parsedVars[k] instanceof Array)) {
                    tmp = (parsedVars[k].length == $this.length) ? i : 0;
                    _[k] = parsedVars[k][tmp];
                }
                if (isNaN(_[k])) _[k] = 0;
                p = _[k].toString().match(/\.\d+$/gi);
                len = (p) ? p[0].length - 1 : 0;
                if (len > precision) precision = len;
            }
            try {
                exprValue = eval(expr);
                if (precision) exprValue = Number(exprValue.toFixed(Math.max(precision, 4)));
                if (jQuery.isFunction(cbFormat)) {
                    var tmp = cbFormat.apply(this, [exprValue]);
                    if (!!tmp) exprValue = tmp;
                }
            } catch(e) {
                exprValue = e;
                bIsError = true;
            }
            $el[sMethod](exprValue.toString());
        });
        if (jQuery.isFunction(cbDone)) cbDone.apply(this, [this]);
        return this;
    };
    $.each(["sum", "avg", "min", "max"], function (i, method) {
        $.fn[method] = function (bind, selector) {
            if (arguments.length == 0)return math[method](this.parseNumber());
            var bSelOpt = selector && (selector.constructor == Object) && !(selector instanceof jQuery);
            var opt = bind && bind.constructor == Object ? bind : {bind: bind || "keyup", selector: (!bSelOpt) ? selector : null, oncalc: null};
            if (bSelOpt) opt = jQuery.extend(opt, selector);
            if (!!opt.selector) opt.selector = $(opt.selector);
            var self = this, sMethod, doCalc = function () {
                var value = math[method](self.parseNumber(opt));
                if (!!opt.selector) {
                    sMethod = (opt.selector.is(":input") ? (defaults.useFieldPlugin ? "setValue" : "val") : "text");
                    opt.selector[sMethod](value.toString());
                }
                if (jQuery.isFunction(opt.oncalc)) opt.oncalc.apply(self, [value, opt]);
            };
            doCalc();
            return self.bind(opt.bind, doCalc);
        }
    });
    var math = {sum: function (a) {
        var total = 0, precision = 0;
        $.each(a, function (i, v) {
            var p = v.toString().match(/\.\d+$/gi), len = (p) ? p[0].length - 1 : 0;
            if (len > precision) precision = len;
            total += v;
        });
        if (precision) total = Number(total.toFixed(precision));
        return total;
    },avg: function (a) {
        return math.sum(a) / a.length;
    },min: function (a) {
        return Math.min.apply(Math, a);
    },max: function (a) {
        return Math.max.apply(Math, a);
    }};
})(jQuery);
/** ------------- choose -------------------- **/
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
        }
        return x;
    },
    reduce:function(obj) {
        var x = this.amount(obj, false);
        if (x >= this.min) {
            $(obj).val(x);
            recalc();
        } else {
            mui.alert("商品数量最少为" + this.min, '提示信息');
            $(obj).val(1);
            $(obj).focus();
        }

        calculation_cprice();
    },
    add:function(obj) {
        var x = this.amount(obj, true);
        if (x <= this.max) {
            $(obj).val(x);
            recalc();
        } else {
            mui.alert("商品数量最多为" + this.max, '提示信息');
            $(obj).val(999);
            $(obj).focus();
        }
        calculation_cprice();
    },
    modify:function(obj) {
        var x = $(obj).val();
        if (x < this.min || x > this.max || !this.reg(x)) {
            mui.alert("请输入正确的数量！", '提示信息');
            $(obj).val(1);
            $(obj).focus();
        }

        calculation_cprice();
    }
}

function BuyUrl(wid) {
    var pcounts = $("input[id^=qty_item_]").val();
    var patrn = /^[0-9]{1,4}$/;
    if (!patrn.exec(pcounts)) {
        pcounts = 1;
    }
    else {
        if (pcounts <= 0)
            pcounts = 1;
        if (pcounts >= 1000)
            pcounts = 999;
    }
}
;

/** total_item **/
$(document).ready(function () {
    $("input[name^=qty_item_]").bind("keyup", recalc);
    recalc();
    //var length = $('.goodstab a').length, width = $(window).width();
    //$('.pro-tab').css('width', width);
    /*$('.goodstab a').each(function(index, el) {
        $(el).click(function(){
            $(this).siblings().removeClass('current');
            $(this).addClass('current');

            $('.pro-tab').addClass('pro-hide');
            $('.pro-tab').eq(index).css('margin-left', width).removeClass('pro-hide').animate({'margin-left': 0});
        });
    });*/
});

function recalc() {

    $("input[id^=total_item]").val()

    //产品价格统计
    $("[id^=total_item]").calc(

        "qty * price",

        {
            qty: $("input[name^=qty_item_]"),
            price: $("[id^=price_item_]")
        },

        function (s) {

            return "￥" + s.toFixed(2);
        },

        function ($this) {

            var sum = $this.sum();
            $("[id^=total_item]").text(
                "￥" + sum.toFixed(2)
            );
            $("#total_price").val($("[id^=total_item]").text());
        }
    );

    //产品积分统计
    $("[id^=total_points]").calc(

        "qty * price",

        {
            qty: $("input[name^=qty_item_]"),
            price: $("[id^=price_item_]")
        },

        function (s) {
            return "" + s.toFixed(0);
        }

    );

};

function getRTime()
{
    var endtime = new Date($('#rtime').attr("endtime")).getTime();
    var nowtime = new Date().getTime();
    var youtime = endtime-nowtime;
    var seconds = youtime/1000;
    var minutes = Math.floor(seconds/60);
    var hours = Math.floor(minutes/60);
    var days = Math.floor(hours/24);
    var Hour= hours % 24;
    var Minute= minutes % 60;
    var Second= Math.floor(seconds%60);
    var tip = promo == 'time' ? '距离抢购结束还有' : '距离团购结束还有';
    if(endtime<=nowtime){
        $('#rtime').html("活动结束")
    }else{
        $('#rtime').html('<i>' + tip + '</i><i class="discount-time">' + days + '</i>天<i class="discount-time">' + Hour + '</i>时<i class="discount-time">' + Minute + '</i>分<i class="discount-time">' + Second + '</i>秒');
    }
    setTimeout("getRTime()",1000);
}

/*function goToLink(index){
    $('.goodstab a').eq(index).click();
}*/


//课程加入购物车
function joinCart()
{
	if(!checkSpecSelected())
	{
        mui.alert("请选择规格", '提示信息');
        $('body,html').animate({ scrollTop: $('#spec_list_mao').offset().top - 250 }, 500);
		return;
	}

	var buyNums   = parseInt($.trim($('#qty_item_1').val()));
	var price     = parseFloat($.trim($('#real_price').text()));
	var productId = $('#product_id').val();
	var type      = productId ? 'product' : 'goods';
	var goods_id  = (type == 'product') ? productId : _goods_id;

  // console.log("buyNums: " + buyNums );
  // console.log("price: " + price );
  // console.log("productId: " + productId );
  // console.log("type: " + type );
  // console.log("goods_id: " + goods_id );

	$.getJSON(_join_url,{"goods_id":goods_id,"type":type,"goods_num":buyNums,"random":Math.random},function(content){
		if(content.isError == false)
		{
            mui.alert("添加成功", '提示信息');
		}
		else
		{
            mui.alert(content.message, '提示信息');
		}
	});
}


/**
 * 监测库存操作
 */
function checkStoreNums()
{
	var storeNums = parseInt(_store_nums);
	if(storeNums > 0)
	{
		openBuy();
	} else {
		closeBuy();
	}
}

/**
 * 检查规格选择是否符合标准
 * @return boolen
 */
function checkSpecSelected()
{
  var current_length = 0;
  $('[name="specColls"]').each(function(){
    if ($(this).hasClass('current'))
      current_length++;
  })
	//if($('[name="specColls"]').length === current_length )
  if ($('[name="specColls"]').length === current_length || current_length > 0)
	{
		return true;
	}
	return false;
}

//检查购买数量是否合法
function checkBuyNums()
{
	//购买数量小于0
	var buyNums = parseInt($.trim($('#qty_item_1').val()));
	if(isNaN(buyNums) || buyNums <= 0)
	{
		$('#qty_item_1').val(1);
		return;
	}

	//购买数量大于库存
	var storeNums = parseInt(_store_nums);
	if(buyNums >= storeNums)
	{
		$('#qty_item_1').val(storeNums);
		return;
	}
}


//禁止购买
function closeBuy()
{
	$('.close_buy').show();
}

//开放购买
function openBuy()
{
	$('.close_buy').hide();
}


function buy_chit()
{
  //对规格的检查
  if(!checkSpecSelected())
  {
    mui.alert('请选择规格', '提示信息');
    $('body,html').animate({ scrollTop: $('#spec_list_mao').offset().top - 250 }, 500);
    return;
  }

  if ( !_is_buy_chit )
  {
    mui.alert('该课程无暂无优惠', '提示信息');
    return;
  }

  var productId = $('#product_id').val();
	var type      = productId ? 'product' : 'goods';
	var goods_id  = (type == 'product') ? productId : _goods_id;
  var url = creatUrl('/site/buy_chit/type/' + type + '/id/' + goods_id);
  location.href = url;
}

function seller_receipt(seller_id)
{
  var url = creatUrl('/site/seller_receipt/id/' + seller_id);
  location.href = url;
}

$(document).ready(function(){
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
  })
})
