<link href="<?php echo $this->getWebSkinPath()."css/prolist.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.poppicker.css";?>" rel="stylesheet" type="text/css" />
<input type="hidden" id="pagenum" value="1">
<input type="hidden" id="order" value="">
<input type="hidden" id="cat" value="<?php echo $this->catId;?>">
<input type="hidden" id="area_id" value="<?php echo isset($area_id)?$area_id:"";?>">
<input type="hidden" id="keywords" value="<?php echo isset($keywords)?$keywords:"";?>">
<div class="pro-tab">
	<a href="javascript:;" id="category"><?php echo isset($this->catRow['name'])?$this->catRow['name']:"";?></a>
	<a href="javascript:;" id="area">区域</a>
	<a href="javascript:;" id="key"><?php if($keywords != ''){?><?php echo isset($keywords)?$keywords:"";?><?php }else{?>关键词<?php }?></a>
</div>
<div class="mui-scroll-wrapper list" id="goodslist" style="top:83px;">
	<div class="mui-scroll">
	    <ul class="mui-table-view"></ul>
	</div>
</div>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.poppicker.js";?>"></script>
<script type="text/javascript">
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
mui.ready(function(){
	document.getElementById('pagenum').value = 1;
	var catdata = <?php if($jsoncats){?><?php echo isset($jsoncats)?$jsoncats:"";?><?php }else{?>new Array()<?php }?>;
	var userPicker = new mui.PopPicker({
		layer: 2
	});
	userPicker.setData(catdata);
	var showUserPickerButton = document.getElementById('category');
	showUserPickerButton.addEventListener('tap', function(event) {
		userPicker.show(function(items) {
			document.getElementById('cat').value = items[1].value;
			document.getElementById('category').innerText = items[1].text;
			document.getElementById('pagenum').value = 1;
			isrefesh = true;
			mui('#goodslist').pullRefresh().pullupLoading();
		});
	}, false);

	var areadata = <?php if($area_arr){?><?php echo isset($area_arr)?$area_arr:"";?><?php }else{?>new Array()<?php }?>;
	var areaPicker = new mui.PopPicker({
		layer: 1
	});
	areaPicker.setData(areadata);
	var showAreaPickerButton = document.getElementById('area');
	showAreaPickerButton.addEventListener('tap', function(event) {
		areaPicker.show(function(items) {
			document.getElementById('area_id').value = items[0].value;
			document.getElementById('area').innerText = items[0].text;
			document.getElementById('pagenum').value = 1;
			isrefesh = true;
			mui('#goodslist').pullRefresh().pullupLoading();
		});
	}, false);

	document.getElementById('key').addEventListener('tap',function(){
		var _keywords = $('#keywords').val();
		mui.prompt('请输入关键词',_keywords,'提示',['确定','取消'],function(result){
			if ( result.value == '')
			{
					$('#key').html('关键词');
			} else {
					$('#key').html(result.value);
			}

			document.getElementById('pagenum').value = 1;
			$('#keywords').val(result.value);
			isrefesh = true;
			mui('#goodslist').pullRefresh().pullupLoading();
		},'div');
	});
});

function pullupRefresh() {
    setTimeout(function() {
        var table = document.body.querySelector('.mui-table-view');
        var cells = document.body.querySelectorAll('.mui-table-view-cell');
        var page = document.getElementById('pagenum').value,
        	cat = document.getElementById('cat').value,
					area_id = document.getElementById('area_id').value,
					keywords = document.getElementById('keywords').value,
        	params = 'page=' + page;
        if(cat){
        	params += '&cat=' + cat;
        }
				if (area_id) {
					params += '&area_id=' + area_id;
				}
				if (keywords) {
					params += '&keywords=' + keywords;
				}
				if(isrefesh){
					table.innerHTML = '';
				}
				console.log(params);
        mui.get(SITE_URL + 'site/get_pro_list_ajax', params, function(json){
            if(json.num < 10){
                mui('#goodslist').pullRefresh().endPullupToRefresh(true);
            }else{
                mui('#goodslist').pullRefresh().endPullupToRefresh();
            }

            for (var i = 0; i < json.num; i++) {
                var li = document.createElement('li');
                li.className = 'mui-table-view-cell mui-media';
                	li.innerHTML = '<a href="<?php echo IUrl::creatUrl("/site/products");?>/id/' + json[i].id + '">'+
                            '<div class="goods_image"><img src="/' + json[i].img + '"></div>'+
                            '<div class="mui-media-body">'+
                                '<div class="goods_name">' + json[i].name + '-' + json[i].seller_info.shortname + '</div>' +
																'<div class="goods_keywords">' + json[i].keywords + '</div>' +
                                '<div class="goods_price">' +
																	'<div class="t-left">&yen;' + json[i].sell_price + '</div>' +
																	'<div class="t-right">销售：' + json[i].sale + '</div>'+
																'</div>' +
                                '<div class="address">[' + json[i].seller_info.address + ']</div>'+
                            '</div>'+
                        '</a>';
                table.appendChild(li);
            }
            document.getElementById('pagenum').value = json.page;
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
</script>