function pullupRefresh() {
    setTimeout(function() {
        var table = document.body.querySelector('.mui-table-view');
        var cells = document.body.querySelectorAll('.mui-table-view-cell');
        var page = document.getElementById('pagenum').value;
        var params = 'page=' + page;
		$('.attrlist').each(function(i, el){
			if($(el).attr('data-id') != '' && $(el).attr('data-value') != ''){
				attr += '&attr[' + $(el).attr('data-id') + ']=' + $(el).attr('data-value');
				$('.attr' + $(el).attr('data-id')).text($(el).attr('data-value'));
			}
		});
		if(isrefesh){
			table.innerHTML = '';
		}
        mui.get(SITE_URL + 'ucenter/get_favorite_list_ajax', params, function(json){
            if(json.num < 10){
                mui('#favorite_list').pullRefresh().endPullupToRefresh(true);
            }else{
                mui('#favorite_list').pullRefresh().endPullupToRefresh();
            }

            for (var i = 0; i < json.num; i++) {
                var li = document.createElement('li');
                li.className = 'mui-table-view-cell mui-media';
                li.innerHTML = '<a href="/school/home/id/' + json[i]['seller_id'] + '">'+
                          '<img class="mui-media-object mui-pull-left" src="/' + json[i].logo + '">'+
                          '<div class="mui-media-body">'+
                              json[i].shortname +
                              '<p class="mui-ellipsis">' + json[i].category_str + '</p>'+
                              '<div class="address">地址：' + json[i].address + '</div>'+
                              '<div class="mui-del" _id="' + json[i]['id'] + '">删除</div>'+
                          '</div>'+
                      '</a>';

                table.appendChild(li);
            }
            document.getElementById('pagenum').value = json.page;
            isrefesh = false;
        }, 'json');
    }, 500);
}
mui.init({
	pullRefresh: {
        container: '#favorite_list',
        up: {
            contentrefresh: '正在加载...',
            callback: pullupRefresh
        }
    }
});
if (mui.os.plus) {
    mui.plusReady(function() {
        setTimeout(function() {
            mui('#favorite_list').pullRefresh().pullupLoading();
        }, 1000);

    });
} else {
    mui.ready(function() {
        mui('#favorite_list').pullRefresh().pullupLoading();
    });
}

mui('body').on('tap', '.mui-del', function(){
    var id = this.getAttribute('_id');
    mui.confirm('确定取消收藏吗？', '取消收藏', ['取消', '确定'], function(e) {
        if (e.index == 1) {
            mui.getJSON(_del_url, {id: id}, function(json){
                if(json.msg == 1){
                    mui.toast('删除成功');
                    window.location.reload();
                }else if(json.msg == -1){
                    mui.toast('信息不正确');
                }else if(json.msg == -2){
                    mui.toast('文章不存在或者已被删除');
                }else{
                    mui.toast('删除失败');
                }
            });
        }
    })
});
