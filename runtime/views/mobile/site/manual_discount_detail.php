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
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.css";?>">
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."resource/scripts/swiper/swiper.min.js";?>"></script>
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."resource/scripts/layer_mobile/layer.js";?>"></script>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/chit1_detail.css";?>" rel="stylesheet" type="text/css" />
<script language="javascript">
var dqk_list = <?php echo isset($dqk_list_json)?$dqk_list_json:"";?>;
var dqk_id = 0;
var dqk_join_ajax = '<?php echo IUrl::creatUrl("/site/join_dqk_ajax");?>';
var dqk_info = new Array();
var id = <?php echo isset($seller_info['id'])?$seller_info['id']:"";?>;
var user_id = <?php if($user_id){?><?php echo isset($user_id)?$user_id:"";?><?php }else{?>0<?php }?>;
var go_buy_url = '<?php echo IUrl::creatUrl("/site/create_brand_chit_zuhe/ids/@ids@");?>';
var check_user_manual_ajax = '<?php echo IUrl::creatUrl("/site/check_use_manual");?>';
var type = <?php if($type){?><?php echo isset($type)?$type:"";?><?php }else{?>1<?php }?>;
var choose_manual_url = '<?php echo IUrl::creatUrl("/site/manual_choose/dqk_id/@dqk_id@");?>';
</script>

  <div class="swiper-container">
  	<div class="swiper-wrapper">
  		<?php if($dqk_list){?>
    		<div class="swiper-slide">
    			<img width="100%" src="<?php echo IUrl::creatUrl("")."".$dqk_list['0']['logo']."";?>" />
    		</div>
  		<?php }?>
  	</div>
  	<div class="swiper-pagination"></div>
    <div class="dqk_name"><?php echo isset($seller_info['shortname'])?$seller_info['shortname']:"";?></div>
  </div>

	<?php if($dqk_list){?>
  <div class="content_module">
    <div class="hd">
      优惠详情
    </div>
    <div class="bd">
      <ul>
				<li class="dqk_list">
          <?php foreach($dqk_list as $key => $item){?>
          <?php echo isset($item['name'])?$item['name']:"";?>
          <?php }?>
        </li>
      </ul>
    </div>
  </div>
	<?php }?>

  <div class="content_module">
    <div class="hd">
      适用学校
    </div>
    <div class="bd seller_info">
      <ul>
        <li><?php echo isset($seller_info['shortname'])?$seller_info['shortname']:"";?></li>
        <li><?php echo isset($seller_info['address'])?$seller_info['address']:"";?></li>
      </ul>
      <?php if($seller_info['phone']){?><div class="seller_tel"><a href="tel:<?php echo isset($seller_info['phone'])?$seller_info['phone']:"";?>"></a></div><?php }?>
    </div>
  </div>

	<div class="content_module">
		<div class="bd">
			<?php if($brand_info['certificate_of_authorization']){?>
				<?php foreach($brand_info['certificate_of_authorization'] as $key => $item){?>
					<img src="<?php echo IUrl::creatUrl("")."".$item."";?>" />
				<?php }?>
			<?php }?>
		</div>
	</div>

	<?php if($brand_info['class_desc_img'] || $brand_info['description'] || $brand_info['shop_desc_img']){?>
  <div class="content_module last">
    <div class="hd">
      学校介绍
    </div>
    <div class="bd">
      <?php if($brand_info['class_desc_img']){?>
        <div class="seller_desc_img">
          <?php if($brand_info['class_desc_img'][1]){?>
      　　  <img src="<?php echo IUrl::creatUrl("")."".$brand_info['class_desc_img'][1]."";?>" />
          <?php }else{?>
            <img src="<?php echo IUrl::creatUrl("")."".$brand_info['class_desc_img'][0]."";?>" />
          <?php }?>
        </div>
      <?php }else{?>
        <div class="seller_desc">
          <?php echo isset($brand_info['description'])?$brand_info['description']:"";?>
        </div>
      <?php }?>

      <?php if($brand_info['shop_desc_img']){?>
      <div class="seller_album"><img src="/views/mobile/skin/blue/images/seller_album_icon.png" /></div>
      <ul class="seller_album_list">
        <?php foreach($brand_info['shop_desc_img'] as $key => $item){?>
        <li><img src="<?php echo IUrl::creatUrl("")."".$item."";?>" /></li>
        <?php }?>
      </ul>
      <?php }?>
    </div>
  </div>
	<?php }?>

  <div class="tocart" style="display:none;">
		<a href="javascript:void(0);" class="use_manual">使用学习通</a>
  </div>
  <div class="tocart_notice"></div>

  <script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/chit1_detail.js";?>"></script>

  <?php if($this->iswechat == 1){?>
  <script src="http://res.wx.qq.com/open/js/jweixin-1.1.0.js"> </script>
  <script type="text/javascript">
  sharedata = <?php echo $this->sharedata;?>;
  wx.config({
      //debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
      appId: '<?php echo isset($this->signPackage['appId'])?$this->signPackage['appId']:"";?>', // 必填，公众号的唯一标识
      timestamp: '<?php echo isset($this->signPackage['timestamp'])?$this->signPackage['timestamp']:"";?>' , // 必填，生成签名的时间戳
      nonceStr: '<?php echo isset($this->signPackage['nonceStr'])?$this->signPackage['nonceStr']:"";?>', // 必填，生成签名的随机串
      signature: '<?php echo isset($this->signPackage['signature'])?$this->signPackage['signature']:"";?>',// 必填，签名，见附录1
      jsApiList: [
        'checkJsApi',
    		'onMenuShareTimeline',
    		'onMenuShareAppMessage',
    		'onMenuShareQQ',
    		'onMenuShareWeibo',
    		'hideMenuItems',
    		'showMenuItems',
    		'hideAllNonBaseMenuItem',
    		'showAllNonBaseMenuItem',
    		'translateVoice',
    		'startRecord',
    		'stopRecord',
    		'onRecordEnd',
    		'playVoice',
    		'pauseVoice',
    		'stopVoice',
    		'uploadVoice',
    		'downloadVoice',
    		'chooseImage',
    		'previewImage',
    		'uploadImage',
    		'downloadImage',
    		'getNetworkType',
    		'openLocation',
    		'getLocation',
    		'hideOptionMenu',
    		'showOptionMenu',
    		'closeWindow',
    		'scanQRCode',
    		'chooseWXPay',
    		'openProductSpecificView',
    		'addCard',
    		'chooseCard',
    		'openCard'
      ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
  });
  wx.ready(function(){
    wx.onMenuShareAppMessage(sharedata);
    wx.onMenuShareTimeline(sharedata);
    wx.onMenuShareQQ(sharedata);
    wx.onMenuShareWeibo(sharedata);
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
