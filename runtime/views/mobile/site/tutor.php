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
	<link href="<?php echo $this->getWebSkinPath()."css/prolist.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.poppicker.css";?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.poppicker.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.lazyload.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.lazyload.img.js";?>"></script>
<script type="text/javascript">mui.init({swipeBack:true});var SITE_URL = '/';</script>
<div class="mui-content">
    <input type="hidden" id="pagenum" value="1">
    <input type="hidden" id="cat" value="0">
    <input type="hidden" id="teaching_time" value="0">
    <input type="hidden" id="region" value="0">
    <div class="pro-tab">
      <a href="javascript:;" id="attrtext0">课程分类</a>
      <a href="javascript:;" class="attr1" id="attrtext1">上课时间</a>
      <a href="javascript:;" class="attr2" id="attrtext2">授课地区</a>
    </div>
    <div class="mui-scroll-wrapper list" id="goodslist">
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

            var attrPicker1 = new mui.PopPicker();
            var attrdata = "[{value: '', text: '上课时间'}";
            <?php foreach($teaching_time as $key => $item){?>
            attrdata += ",{value: <?php echo isset($key)?$key:"";?>, text: '<?php echo isset($item)?$item:"";?>'}";
            <?php }?>
            attrdata += ']';
            attrPicker1.setData(eval('(' + attrdata + ')'));
            document.getElementById('attrtext1').addEventListener('tap', function(event) {
                attrPicker1.show(function(items) {
                    $('#teaching_time').val(items[0].value);
                    document.getElementById('attrtext1').innerText = items[0].text;
                    document.getElementById('pagenum').value = 1;
                    isrefesh = true;
                    mui('#goodslist').pullRefresh().pullupLoading();
                });
            }, false);
            var attrPicker2 = new mui.PopPicker();
            var attrdata = "[{value: '', text: '授课地区'}";
            <?php foreach($region_list as $key => $item){?>
            attrdata += ",{value: <?php echo isset($item['area_id'])?$item['area_id']:"";?>, text: '<?php echo isset($item['area_name'])?$item['area_name']:"";?>'}";
            <?php }?>
            attrdata += ']';
            attrPicker2.setData(eval('(' + attrdata + ')'));
            document.getElementById('attrtext2').addEventListener('tap', function(event) {
                attrPicker2.show(function(items) {
                    $('#region').val(items[0].value);
                    document.getElementById('attrtext2').innerText = items[0].text;
                    document.getElementById('pagenum').value = 1;
                    isrefesh = true;
                    mui('#goodslist').pullRefresh().pullupLoading();
                });
            }, false);
            var attrPicker3 = new mui.PopPicker();
            var attrdata = "[{value: '', text: '课程分类'}";
            <?php foreach($cates_arr as $key => $item){?>
            attrdata += ",{value: <?php echo isset($key)?$key:"";?>, text: '<?php echo isset($item)?$item:"";?>'}";
            <?php }?>
            attrdata += ']';
            attrPicker3.setData(eval('(' + attrdata + ')'));
            document.getElementById('attrtext0').addEventListener('tap', function(event) {
                attrPicker3.show(function(items) {
                    $('#cat').val(items[0].value);
                    document.getElementById('attrtext0').innerText = items[0].text;
                    document.getElementById('pagenum').value = 1;
                    isrefesh = true;
                    mui('#goodslist').pullRefresh().pullupLoading();
                });
            }, false);
        });

        function pullupRefresh() {
            setTimeout(function() {
                var table = document.body.querySelector('.mui-table-view');
                var cells = document.body.querySelectorAll('.mui-table-view-cell');
                var page = document.getElementById('pagenum').value,
                    cat = document.getElementById('cat').value,
                    teaching_time = document.getElementById('teaching_time').value,
                    region = document.getElementById('region').value,
                    attr = '';
                var params = 'page=' + page, attr = '';
                if(cat){
                    params += '&cat=' + cat;
                }
                if(teaching_time){
                    params += '&teaching_time=' + teaching_time;
                }
                if(region){
                    params += '&region=' + region;
                }
                //console.log(params);
                $('.attrlist').each(function(i, el){
                    if($(el).attr('data-id') != '' && $(el).attr('data-value') != ''){
                        attr += '&attr[' + $(el).attr('data-id') + ']=' + $(el).attr('data-value');
                        $('.attr' + $(el).attr('data-id')).text($(el).attr('data-value'));
                    }
                });

                params += attr;
                if(isrefesh){
                    table.innerHTML = '';
                }
                mui.get(SITE_URL + 'site/get_tutor_list_ajax', params, function(json){
                    if(json.num < 10){
                        mui('#goodslist').pullRefresh().endPullupToRefresh(true);
                    }else{
                        mui('#goodslist').pullRefresh().endPullupToRefresh();
                    }

                    for (var i = 0; i < json.num; i++) {
                        var li = document.createElement('li');
                        li.className = 'mui-table-view-cell mui-media';
                        li.innerHTML = '<a href="' + json[i].link + '"><img class="mui-media-object mui-pull-left" src="/' + json[i].logo  + '">'+
                                            '<div class="mui-media-body">' + json[i].true_name +
                                                '<p class="mui-ellipsis">' + json[i].str +
                                                '</p>' +
                                                '<div class="goodsprice">学费：￥' + json[i].price + '</div>' +
                                            '</div>' +
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
            placeholder: '/views/mobile/skin/blue/images/lazyload.jpg'
        });
    })(mui);
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
