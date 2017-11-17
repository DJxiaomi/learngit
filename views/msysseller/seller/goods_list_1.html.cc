<link rel="stylesheet" href="{skin:css/goods_list.css}" />

<!--下拉刷新容器-->
<div id="goodslist" class="mui-content mui-scroll-wrapper">
	<div class="mui-scroll">
		<!--数据列表-->
		<ul class="mui-table-view mui-table-view-chevron">

		</ul>
	</div>
	<input type="hidden" id="page" value="1" />
</div>

<script>
mui.init({
	pullRefresh: {
		container: '#goodslist',
		up: {
			contentrefresh: '正在加载...',
			callback: pullupRefresh
		}
	}
});
/**
 * 上拉加载具体业务实现
 */
function pullupRefresh() {
	setTimeout(function() {
		var table = document.body.querySelector('.mui-table-view');
		var cells = document.body.querySelectorAll('.mui-card');
		var page = document.getElementById('page').value;
		mui.get('{url:/seller/ajax_goods_list}', {page: page}, function(json){
			if(json.num <= 10){
				mui('#goodslist').pullRefresh().endPullupToRefresh(true);
			}
			if(json.num > 0){
				for(var i = 0; i < json.num; i++){
					var cell = document.createElement('li');
					var url = '{url:/seller/goods_edit_1/id/@id@}';
					url = url.replace('@id@', json[i].id);
					cell.className = 'mui-table-view-cell mui-media';
					cell.innerHTML = '<div class="mui-media-object mui-pull-left"><img src="' + SITE_URL + json[i].img + '" /></div>' +
					            		 '<div class="mui-media-body">' +
					                 '<p class="goods_name">' + json[i].name + '</p>' +
													 '<p class="goods_brief">' + json[i].goods_brief + '</p>' +
													 '<a class="buycard editcard" href="' + url + '">编辑</a>' +
					                 '<a class="buycard delcart"  href="javascript:void(0);" onclick="del(' + json[i].id + ')">删除</a>' +
					            '</div>';
					table.appendChild(cell);
					mui('body').on('tap','a',function(){document.location.href=this.href;});
				}
				document.getElementById('page').value = json.page;
			}
		}, 'json');
	}, 1500);
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

$(function(){
	$('.mui-pull-right').attr('href','/seller/goods_edit3').html('添加课程');
})

function del(id)
{
	var btnArray = ['取消', '删除'];
	mui.confirm('您确定要删除该课程吗？', '提示信息', btnArray, function(e) {
			if (e.index == 1) {
					location.href = '{url:/seller/goods_del/id}/' + id;
			}
	})
}
</script>