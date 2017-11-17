$(document).ready(function(){
	// 课程连接
	$('.goods').click(function(){
		var _id = $(this).attr('id');
		window.document.location.href = '/index.php?controller=site&action=products&id=' + _id;
	});
	
	// 商家连接
	$('.seller').click(function(){
		var _id = $(this).attr('id');
		window.document.location.href = '/index.php?controller=site&action=brand_zone&id=' + _id;
	});
	
	// 输入框的处理效果
	$(document).ready(function(){		
		$('.lx_input').each(function( i ){
			var _lx_input_str = new Array();
			_lx_input_str.push( $(this).attr('placeholder') );
			
			$(this).focus(function(){
				$(this).attr('placeholder', '');	
			});
			
			$(this).blur(function(){
				$(this).attr('placeholder', _lx_input_str[i] );	
			});
		});
	});
	
	// 处理图片的大小
	$('#showGoods .goods').each(function(){
		var _width = $(this).width();
		var _parent_width = $(this).parent().width();
		var _max_width = _parent_width * 0.46;
		
		$(this).css({'max-width':_max_width,'overflow':'hidden'});
		$(this).find('.goods_image').css({'width': _max_width, 'height':_max_width,'oveflow':'hidden'});
		$(this).find('img').css({'width': _max_width, 'height':_max_width,'oveflow':'hidden'});	
	});
	$('#showGoods .seller').each(function(){
		var _width = $(this).width();
		var _parent_width = $(this).parent().width();
		var _max_width = _parent_width * 0.46;
		
		$(this).css({'max-width':_max_width,'overflow':'hidden'});
		$(this).find('.seller_image').css({'width': _max_width, 'height':_max_width,'oveflow':'hidden'});
		$(this).find('img').css({'width': _max_width, 'height':_max_width,'oveflow':'hidden'});	
	});
});