$(document).ready(function(){
	$('.display_list li .pic').hover(function(){
		$(this).addClass('active');
	}, function(){
		$(this).removeClass('active');
	});

  // 图片懒加载
  Lx.common.lazyload();

	// 鼠标放上去的效果
	$('.display_list li').hover(function(){
		$(this).addClass('active');
	}, function(){
		$(this).removeClass('active');
	});
});

//价格跳转
function priceLink()
{
	ere = /^\d+$/;
	var minVal = $('[name="min_price"]').val();
	var maxVal = $('[name="max_price"]').val();
	if ( !ere.test( minVal ) || !ere.test(maxVal ))
	{
		layer.alert('请填写正确价格', {icon: 2});
		return;
	}
	var urlVal = "{echo:IFilter::act(preg_replace('|&min_price=\w*&max_price=\w*|','',search_goods::searchUrl(array('min_price','max_price'),'')),'url')}";
	window.location.href=urlVal+'&min_price='+minVal+'&max_price='+maxVal;
}

//价格检查
function checkPrice(obj)
{
	if(isNaN(obj.value))
	{
		obj.value = '';
	}
}
