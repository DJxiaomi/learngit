

function initchart(map,grade='',legend='',sold=''){	

	var $cart = $('#selected-seats'), //座位区
	$counter = $('#counter'), //票数
	$total = $('#total'); //总计金额
	var sc;

	
	sc = $('#seat-map').seatCharts({
		map: map,
		seats:grade,
		naming : {
			top : false,
			getLabel : function (character, row, column) {
				return column;
			}
		},
		legend : { //定义图例
			node : $('#legend'),
			items : legend					
		},
		click: function () { //点击事件
			if (this.status() == 'available') { //可选座
				/*$('<li>'+(this.settings.row+1)+'排'+this.settings.label+'座<br/>￥<span>'+this.data().price+'</span></li>')
					.attr('id', 'cart-item-'+this.settings.id)
					.attr('data-seatId', this.settings.id)
					.attr('data-level', this.data().category)
					.appendTo($cart);*/

				// $counter.text(sc.find('selected').length+1);
				// $total.text(recalculateTotal(sc)+this.data().price);
							
				return 'selected';
			} else if (this.status() == 'selected') { //已选中
					/*//更新数量
					$counter.text(sc.find('selected').length-1);
					//更新总计
					$total.text(recalculateTotal(sc)-this.data().price);
						
					//删除已预订座位
					$('#cart-item-'+this.settings.id).remove();
					//可选座*/
					return 'available';
			} else if (this.status() == 'unavailable') { //已售出
				return 'unavailable';
			} else {
				return this.style();
			}
		}
	});
	//已售出的座位
	if(sold != ''){
		sc.get(sold).status('unavailable');
	}
	
}


//计算总金额
/*function recalculateTotal(sc) {
	var total = 0;
	sc.find('selected').each(function () {
		total += this.data().price;
	});
			
	return total;
}*/
