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
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/prolist.css";?>">
<input type="hidden" id="pagenum" value="1">
<input type="hidden" id="seller_id" value="<?php echo isset($seller_id)?$seller_id:"";?>">
<div class="mui-chit mui-scroll-wrapper card-list-box" id="goodslist">
	<div class="mui-scroll">
	    <ul class="mui-table-view">

	    </ul>
	</div>
</div>
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
});

function pullupRefresh() {
    setTimeout(function() {
        var table = document.body.querySelector('.mui-table-view');
        var cells = document.body.querySelectorAll('.mui-table-view-cell');
        var page = document.getElementById('pagenum').value;
        var seller_id = document.getElementById('seller_id').value;
        var params = 'page=' + page;
        if(seller_id){
            params += '&seller_id=' + seller_id;
        }

        mui.get(SITE_URL + 'site/get_chit_list_ajax2', params, function(json){
            if(json.num < 10){
                mui('#goodslist').pullRefresh().endPullupToRefresh(true);
            }else{
                mui('#goodslist').pullRefresh().endPullupToRefresh();
            }

            for (var i = 0; i < json.num; i++) {
                var li = document.createElement('li');
                li.className = 'mui-table-view-cell mui-media';
                var maxPrice = (json[i].is_zuhe) ? json[i].max_price + '元' : json[i].max_price + '元抢券';
                var limitnum = (json[i].limitnum <= 0) ? '数量无限制' : '每人限购' + json[i].limitnum + '张';
                var tip = json[i].type == 2 ? '立即领券' : '立即购买';

                var chittype = json[i].type == 2 ? '<em class="totip totip-1">赠送</em>' : '';
                li.innerHTML = '<div class="mui-media-object mui-pull-left" id="' + json[i].id + '" pid="' + json[i].pid + '">'+
								'<p class="tobuy"></p>'+
                                '<p class="tochit"><em>￥</em>' + json[i].max_order_chit + '</p>'+
								'</div>'+
								'<div class="mui-media-body">'+
								'<p>' + chittype + '<span class="mui-seller" id="' + json[i].seller_id + '">' + json[i].shortname + '<span></p>'+
								'<p class="tospec"></p>'+
                                '<p class="tospec tospec-1"> ' + maxPrice + '</p>';

								if (json[i].is_zuhe)
								{
									var url = '<?php echo IUrl::creatUrl("/simple/cart21/id/5280/num/1/type/product/statement/2/stime/1/ischit/1/zuhe_id/@id@");?>';
									url = url.replace('@id@',json[i].id);
									li.innerHTML += '<a class="buycard" href="' + url + '">' + tip + '</a>';
								} else {
									if ( json[i].pid > 0 )
										li.innerHTML += '<a class="buycard" onclick="buy_now_ding_card2(\'' + json[i].pid + '\', \'' + json[i].max_price + '\')">' + tip + '</a>';
									else
										li.innerHTML += '<a class="buycard" onclick="buy_now_ding_card(\'' + json[i].id + '\', \'' + json[i].max_price + '\')">' + tip + '</a>';
								}

								li.innerHTML += '</div>';

                table.appendChild(li);

                mui('body').on('tap', '.mui-pull-left', function(){
										var _pid = this.getAttribute('pid');
										_pid = parseInt( _pid );
										if ( _pid > 0 )
											window.location.href = SITE_URL + 'site/products/id/' + this.id;
										else
                    	window.location.href = SITE_URL + 'site/chit_show/id/' + this.id;
                });

                mui('body').on('tap', '.mui-seller', function(){
                    window.location.href = SITE_URL + 'school/show/id/' + this.id;
                });
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

function buy_now_ding_card(id, _input_dprice){
    var buyNums  = 1;
    //var type = 'chit';
    var url = '<?php echo IUrl::creatUrl("/simple/cart2/id/5280/num/@buyNums@/type/product/statement/2/ischit/1/chitid/@chitid@");?>';
        url = url.replace('@chitid@',id).replace('@buyNums@',buyNums);
    var _input_stime = 1;
    url += '/stime/' + _input_stime;
    url += '/dprice/' + _input_dprice;

    window.location.href = url;
}
function buy_now_ding_card2(pid, _input_dprice){
    var url = '<?php echo IUrl::creatUrl("/simple/cart2/id/@pid@/num/1/type/product/statement/2/stime/1/dprice/@max_price@");?>';
        url = url.replace('@pid@',pid).replace('@max_price@',_input_dprice);
    window.location.href = url;
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

(function($) {
	$(document).imageLazyload({
		placeholder: '<?php echo $this->getWebSkinPath()."images/lazyload.jpg";?>'
	});
})(mui);
</script>

<?php if($id == 851){?>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/form.css";?>" />
<script>var pid = <?php echo isset($id)?$id:"";?>;</script>
<script language="javascript" src="<?php echo $this->getWebSkinPath()."js/form.js";?>"></script>
<?php }?>
