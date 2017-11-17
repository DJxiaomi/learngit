var isrefesh = false;
mui.init({
	pullRefresh: {
        container: '#goodslist',
        up: {
            contentrefresh: '正在加载...',
            callback: pullupRefresh
        }
    }
});

function pullupRefresh() {
    setTimeout(function() {
        var table = document.body.querySelector('.mui-table-view');
        var cells = document.body.querySelectorAll('.mui-table-view-cell');
				page = pagenum;
        var cat_id = document.getElementById('cat_id').value;
        var keyword = document.getElementById('keyword').value;
        var params = 'page=' + page + '&cat_id=' + cat_id + '&keyword=' + keyword;

				if(isrefesh){
						table.innerHTML = '';
				}

        mui.get(SITE_URL + 'site/get_chit_list_ajax1', params, function(json){
            if(json.num < 10){
                mui('#goodslist').pullRefresh().endPullupToRefresh(true);
            }else{
                mui('#goodslist').pullRefresh().endPullupToRefresh();
            }

            for (var i = 0; i < json.num; i++) {
                var li = document.createElement('li');
								var seller_id = json[i].seller_id;
                var logo = json[i].logo;
                var name = json[i].name;
                var seller_name = json[i].seller_name;
                var use_times = json[i].use_times;
                var id = json[i].id;
                var url = detail_url.replace('@id@',seller_id);
								var goods_names = json[i].goods_names;
								var sale = json[i].sale;
								var c_sale = json[i].c_sale;
								var market_price = json[i].market_price;
								var max_price = json[i].max_price;

                li.innerHTML = '<a href="' + url + '"><div class="mui-card" id="' + seller_id + '">' +
                                 '<div class="mui-card-header mui-card-media">' +
																	 '<img src="/' + logo + '" />' +
																	 '<div class="mui-card-bg"></div>' +
																	 '<div class="mui-card-info">' +
																	 '<div class="t-left">已售：' + c_sale + '</div>' +
																	 '<div class="t-right"><span>原价：' + json[i].max_order_chit + '</span><i>&yen;</i>' + max_price + '</div>' +
																	 '</div>' +
																 '</div>' +
                                 '<div class="mui-card-content">' +
																 		'<div class="t-left"><img src="/' + json[i].b_logo + '" /></div>' +
																		'<div class="t-right">' +
																	 		'<div class="goods-name">' + json[i].seller_name + '短期课-' + json[i].use_times + '课时</div>' +
																			'<div class="goods-addr">' + json[i].address + '</div>' +
																			'<div class="goods-content">' + json[i].brief + '</div>' +
																		'</div>' +
																 '</div>' +
                               '</div></a>';
                table.appendChild(li);
            }
						pagenum = json.page;
            isrefesh = false;
        }, 'json');
    }, 500);
}
if (mui.os.plus) {
    mui.plusReady(function() {
        setTimeout(function() {
            mui('#goodslist').pullRefresh().pullupLoading();
        }, 1000);
    });
} else {
    mui.ready(function() {
        mui('#goodslist').pullRefresh().pullupLoading();
    });
}

var userPicker = new mui.PopPicker({
  layer: 1
});
userPicker.setData(catdata);
var showUserPickerButton = document.getElementById('choose_category');
showUserPickerButton.addEventListener('tap', function(event) {
  userPicker.show(function(items) {
    document.getElementById('cat_id').value = items[0].value;
    document.getElementById('choose_category').innerText = items[0].text;
		pagenum = 1;
		isrefesh = true;
		mui('#goodslist').pullRefresh().pullupLoading();
  });
}, false);

function check_search()
{
	// var keyword = document.getElementById('keyword').value;
	// if ( keyword == '' || keyword == '搜索您感兴趣的内容')
	// {
	// 	mui.toast('请输入关键词');
	// } else {
	// 	pagenum = 1;
	// 	isrefesh = true;
	// 	mui('#goodslist').pullRefresh().pullupLoading();
	// }

	pagenum = 1;
	isrefesh = true;
	mui('#goodslist').pullRefresh().pullupLoading();
	return false;
}

var search_btn = document.getElementById('search_btn');
search_btn.addEventListener('tap',function(event){
  // var keyword = document.getElementById('keyword').value;
  // if ( keyword == '' || keyword == '搜索您感兴趣的内容')
  // {
  //   mui.toast('请输入关键词');
  //   return false;
  // } else {
	// 	pagenum = 1;
	// 	isrefesh = true;
	// 	mui('#goodslist').pullRefresh().pullupLoading();
  // }

	pagenum = 1;
	isrefesh = true;
	mui('#goodslist').pullRefresh().pullupLoading();
})

$('.search_form i').click(function(){
	document.getElementById('keyword').value = '';
})
