<?php
	$member_info = member_class::get_member_info($this->user['user_id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $this->_siteConfig->name;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<link href="<?php echo IUrl::creatUrl("")."resource/css/font-awesome.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/jquery-3.1.1.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/common.js";?>"></script>
	<script type="text/javascript">mui.init({swipeBack:true});var SITE_URL = '<?php echo IUrl::creatUrl("");?>';</script>
</head>
<body>
	<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '')){?>
	<?php }else{?>
	<header class="mui-bar mui-bar-nav">
			<?php if(!$this->back_url){?>
	    	<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
			<?php }else{?>
				<style>
				.mui-icon-back:before, .mui-icon-left-nav:before {color: #fff;}
				</style>
				<a class="mui-icon mui-icon-left-nav mui-pull-left" href="<?php echo IUrl::creatUrl("".$this->back_url."");?>"></a>
			<?php }?>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
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

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
			<a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
			<a class="mui-tab-item brand <?php if($this->getId() == 'site' && $_GET['action'] == 'manual'){?>mui-hot-brand<?php }?>" href="<?php echo IUrl::creatUrl("/site/manual");?>" id="ztelBtn">
					<span class="mui-tab-label">学习通</span>
			</a>
	    <a class="mui-tab-item user <?php if($this->getId() == 'ucenter' || ($this->getId() == 'simple' && $_GET['action'] == 'login')){?>mui-hot-user<?php }?>" href="<?php echo IUrl::creatUrl("/simple/login");?>?callback=/ucenter" id="ltelBtn">
	        <span class="mui-tab-label">我的</span>
	    </a>
      <a class="mui-tab-item service" href="<?php echo IUrl::creatUrl("/site/service");?>" id="ltelBtn">
	        <span class="mui-tab-label">客服</span>
	    </a>
	</nav>
</body>
</html>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.lazyload.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.lazyload.img.js";?>"></script>
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

<?php if($id == 851){?>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/form.css";?>" />
<script>var pid = <?php echo isset($id)?$id:"";?>;</script>
<script language="javascript" src="<?php echo $this->getWebSkinPath()."js/form.js";?>"></script>
<?php }?>
