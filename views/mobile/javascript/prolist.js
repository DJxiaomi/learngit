window.Prolist = new (function Prolist(){
	
	var that = this;
	var der, tab, maincon, maincona, xbtn, childer, resetbtn, cat, area, min_price, max_price, word, pagenum, prolist, order, more, catdom, agedom, pricedom, areadom;

	that.perpage = 12;
	that.pagecount = 0;
	that.pagenum = 1;
	that.firstcat = 0;
	that._loading = false;

	(function(){
		der = $.Deferred();
		$(function(){
			tab = $('.mainclass');
			maincon = $('.mainnav-con');
			xbtn = $('.xulie-btn');
			childer = maincon.find('div');
			maincona = maincon.find('a');
			resetbtn = $('#resetbtn');
			order = $('#order');
			word = $('#word');
			cat = $('#cat');
			area = $('#area');
			min_price = $('#min_price');
			max_price = $('#max_price');
			pagenum = $('#pagenum');
			prolist = $('#prolist');
			more = $('#bl_more');
			catdom = $('#kecheng');
			agedom = $('.age');
			pricedom = $('#jiage');
			areadom = $('#quyu');
			der.resolve();
			that.submit();
			that.scroll();
		});
	})()
	that.tab = function(obj){
		var childclass = $(obj).attr('id'), showdom = $('.' + childclass);
		$(obj).siblings().stop().removeClass('current');
		$(obj).addClass('current');

		maincon.show();
		childer.hide();
		showdom.slideDown(function(){
			showdom.find('a').each(function(i, el){
				if(childclass == 'jiage'){
					var pricearea = showdom.find('input[id="min_price"]').val() + '-' + showdom.find('input[id="max_price"]').val();
					if($(el).attr('data-value') == pricearea){
						$(el).addClass('current');
					}
				}else{
					if($(el).attr('data-value') == showdom.find('input').val()){
						$(el).addClass('current');
					}
				}
			});
		});
		xbtn.show();
	}

	that.reset = function(){
		maincon.slideUp();
		childer.hide();
		tab.removeClass('current');
		maincona.removeClass('current');
		xbtn.hide();
		cat.val(that.firstcat);
		area.val('');
		min_price.val('');
		max_price.val('');
		catdom.text('课程分类');
		agedom.text('年龄');
		pricedom.text('价格区间');
		areadom.text('区域');
		pagenum.val(1);
		that.submit();
	}

	that.close = function(){
		maincon.slideUp();
		childer.hide();
		tab.removeClass('current');
		xbtn.hide();
	}

	that.closeAll = function(){
		maincon.slideUp();
		childer.hide();
		tab.removeClass('current');
		maincona.removeClass('current');
		xbtn.hide();
		cat.val('');
		area.val('');
		min_price.val('');
		max_price.val('');
		catdom.text('课程分类');
		agedom.text('年龄');
		pricedom.text('价格区间');
		areadom.text('区域');
		pagenum.val(1);
	}

	that.sort = function(obj, isclass){
		var ordervalue = $(obj).attr('data-toggle');
		isclass = typeof isclass != 'undefined' ? true : false;
		order.val(ordervalue);
		//$(obj).parent().parent().find('a').removeClass('current-link');
		//$(obj).addClass('current-link');
		//$('.pro-tab-nav').find('li').removeClass('toggledown');
		//$('.pro-tab-nav').find('li').removeClass('toggleup');
		$(obj).removeClass('toggledown');
		$(obj).removeClass('toggleup');
		if(/toggle/.test(ordervalue)){
			$(obj).attr('data-toggle', ordervalue.replace('_toggle', ''));
			//isclass && $(obj).parent().removeClass('toggledown');
			//isclass && $(obj).parent().addClass('toggleup');
			isclass && $(obj).removeClass('toggledown');
			isclass && $(obj).addClass('toggleup');
		}else{
			$(obj).attr('data-toggle', ordervalue + '_toggle');
			//isclass && $(obj).parent().addClass('toggledown');
			//isclass && $(obj).parent().removeClass('toggleup');
			isclass && $(obj).addClass('toggledown');
			isclass && $(obj).removeClass('toggleup');
		}
		pagenum.val(1);
		that.submit();
	}

	that.select = function(obj, type, isparent){
		var isparent = typeof isparent != 'undefined' ? true : false;
		var typeArr = type.split(';'), value = $(obj).attr('data-value');
		if(isparent){
			$(obj).parent().parent().find('a').removeClass('current');
			$(obj).addClass('current');
		}else{
			$(obj).siblings().stop().removeClass('current');
			$(obj).addClass('current');
		}

		if(typeArr.length > 1){
			var valueArr = value.split('-');
			for(var i = 0; i < typeArr.length; i++){
				$('#' + typeArr[i]).val(valueArr[i]);
			}
		}else{
			$('#' + type).val(value);
		}
	}

	that.submit = function(scroll, isclose){
		scroll = (typeof scroll != 'undefined' && scroll != '') ? true : false;
		isclose = typeof isclose != 'undefined' ? true : false;
		//isclose && word.val('');
		(word.val() != '' && !isclose) && that.closeAll();

		//var params = 'cat=' + cat.val() + '&area=' + area.val() + '&min_price=' + min_price.val() + '&max_price=' + max_price.val() + '&word=' + word.val() + '&perpage=' + that.perpage + '&page=' + pagenum.val() + '&order=' + order.val(), attr = '';
		var params = 'cat=' + cat.val() + '&word=' + word.val() + '&perpage=' + that.perpage + '&page=' + pagenum.val() + '&order=' + order.val(), attr = '';
		$('.attrlist').each(function(i, el){
			if($(el).attr('data-id') != '' && $(el).attr('data-value') != ''){
				attr += '&attr[' + $(el).attr('data-id') + ']=' + $(el).attr('data-value');
				$('.attr' + $(el).attr('data-id')).text($(el).attr('data-value'));
			}
		});

		params += attr;
		if(word.val() != '')
		{
			params += '&word=' + word.val();
		}

		if(isclose){
			$('.kecheng-list').hasClass('current') && catdom.text($('.kecheng-list.current').text());
			min_price.val() != '' && pricedom.text($('.jiage-list.current').text());
			area.val() != '' && areadom.text($('.quyu-list.current').text());
			that.close();
		}
		if(!scroll){
			layer.open({
				type: 2 ,content: '加载中'
			});
		}
		
		$.getJSON('/site/get_pro_list_ajax', params, function(json) {
			if(json.pagecount == 0){
				prolist.html('');
				more.text('没有查找的内容');
				layer.closeAll();
				return false;
			}
			if(scroll){
				if(json.html){
					prolist.append(json.html);
					pagenum.val(json.page);
					that._loading = false;
				}	
			}else{
				prolist.html(json.html);
				pagenum.val(2);
			}
			that.pagecount = json.pagecount;
			!scroll && layer.closeAll();
		});
	}

	that.scroll = function(){
		$(window).scroll(function(){
			var scrolltop = $(window).scrollTop() + $(window).height();
			var load_position = more.offset().top;
			if( scrolltop >= load_position -50 && that._loading == false && (Number(pagenum.val()) - 1) < that.pagecount){
				more.text('努力加载中...');
				that._loading = true;
				that.submit(true);
			}
			if(Number(pagenum.val()) > that.pagecount){
				more.text('');
				return false;
			}
		})
	}
})();