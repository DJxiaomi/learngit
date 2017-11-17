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
				<a class="mui-icon mui-icon-left-nav mui-pull-left" href="<?php echo IUrl::creatUrl("/site/chit1");?>"></a>
			<?php }?>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<link href="<?php echo $this->getWebSkinPath()."css/search.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.css";?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/search.js";?>"></script>

<div class="search_content">
  <div class="search_info">
    <div class="search_form">
      <a class="back_btn" href="<?php echo IUrl::creatUrl("/");?>"></a>
      <form action="<?php echo IUrl::creatUrl("site/pro_list");?>" method="post">
      <input type="text" value="" id="keywords" name="word" placeholder="在此输入想要搜索的内容"/>
      <input type="button" value="" />
      </form>
      <a href="#" class="close_btn"></a>
    </div>
    <div class="search_tip">
      <img src="<?php echo $this->getWebSkinPath()."images/search_tip.png";?>" />
    </div>
    <div class="search_btn">
    	<a href="javascript:void(0);" class="search_icon">
            <div class="t-left">
                <img src="/views/mobile/skin/blue/images/1.png" />
            </div>
            <div class="t-right">
                <img src="/views/mobile/skin/blue/images/2.png" />
            </div>
        </a>
    </div>
  </div>
</div>
<script type="text/javascript">
var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    paginationClickable: true,
    loop : true,
    autoplay: 3000
});


</script>


<?php if($this->iswechat == 1){?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.1.0.js"> </script>
<script type="text/javascript">
wx.config({
    //debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: '<?php echo isset($this->signPackage['appId'])?$this->signPackage['appId']:"";?>', // 必填，公众号的唯一标识
    timestamp: '<?php echo isset($this->signPackage['timestamp'])?$this->signPackage['timestamp']:"";?>' , // 必填，生成签名的时间戳
    nonceStr: '<?php echo isset($this->signPackage['nonceStr'])?$this->signPackage['nonceStr']:"";?>', // 必填，生成签名的随机串
    signature: '<?php echo isset($this->signPackage['signature'])?$this->signPackage['signature']:"";?>',// 必填，签名，见附录1
    jsApiList: [
                  'getLocation' //获取地理位置接口
               ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});
wx.ready(function(){
	wx.getLocation({
      success: function (res) {
        //alert(res);
      },
      cancel: function (res) {
        alert('用户拒绝授权获取地理位置');
      }
    });
});
wx.error(function (res) {
  	//alert("调用微信jsapi返回的状态:"+res.errMsg);
});
</script>
<?php }?>

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
