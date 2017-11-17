<!doctype html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>管理中心</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<link href="/resource/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/form.css";?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/resource/scripts/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/jquery.juploader.js";?>"></script>
	<script type="text/javascript" src="/resource/scripts/common.js"></script>
	<script type="text/javascript">mui.init();var SITE_URL = '<?php echo IUrl::creatUrl("");?>';</script>
</head>
<body>
	<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '')){?>
	<?php }else{?>
	<header class="mui-bar mui-bar-nav">
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }else{?>
		<a href="" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/goods_list.css";?>" />

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
		mui.get('<?php echo IUrl::creatUrl("/seller/ajax_goods_list");?>', {page: page}, function(json){
			if(json.num <= 10){
				mui('#goodslist').pullRefresh().endPullupToRefresh(true);
			}
			if(json.num > 0){
				for(var i = 0; i < json.num; i++){
					var cell = document.createElement('li');
					console.log(json[i].img);
					cell.className = 'mui-table-view-cell mui-media';
					cell.innerHTML = '<div class="mui-media-object mui-pull-left"><img src="' + SITE_URL + json[i].img + '" /></div>' +
					            		 '<div class="mui-media-body">' +
					                 '<p class="goods_name">' + json[i].name + '</p>' +
													 '<a class="buycard editcard" href="<?php echo IUrl::creatUrl("/seller/goods_edit_1/id");?>/' + json[i].id + '">编辑</a>' +
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
	$('.mui-pull-right').attr('href','/seller/goods_edit_1').html('添加课程');
})

function del(id)
{
	var btnArray = ['取消', '删除'];
	mui.confirm('您确定要删除该课程吗？', '提示信息', btnArray, function(e) {
			if (e.index == 1) {
					location.href = '<?php echo IUrl::creatUrl("/seller/goods_del/id");?>/' + id;
			}
	})
}
</script>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/brand_edit");?>" id="ztelBtn">
	        <i class="mui-icon-my icon-book"></i>
	        <span class="mui-tab-label">页面信息</span>
	    </a>
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/seller_edit");?>" id="ztelBtn">
	        <i class="mui-icon-my icon-globe"></i>
	        <span class="mui-tab-label">基本信息</span>
	    </a>
	    <!-- <a class="mui-tab-item mui-hot" href="<?php echo IUrl::creatUrl("/seller/chit");?>">
	        <i class="mui-icon-my icon-github-alt"></i>
	        <span class="mui-tab-label">代金券</span>
	    </a> -->
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/order_list");?>">
	        <i class="mui-icon-my icon-shopping-cart"></i>
	        <span class="mui-tab-label">学校订单</span>
	    </a>
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/meau_index");?>" id="ltelBtn">
	        <i class="mui-icon-my icon-user"></i>
	        <span class="mui-tab-label">管理中心</span>
	    </a>
	</nav>
</body>
</html>
<script type="text/javascript">
mui('body').on('tap', 'a', function(){
    if(this.href != '#' && this.href != ''){
        mui.openWindow({
            url: this.href
        });
    }
    this.click();
});
</script>
