<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>康卓商城</title>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
    <script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui2/js/mui.picker.js";?>"></script>
	<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/weui/weui.css";?>">
	<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/mui.min.css";?>">
	<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/icons-extra.css";?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/app.css";?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/common.css";?>"/>
</head>

<body>

    <nav class="mui-bar mui-bar-tab">
    	<a class="mui-tab-item mui-active" href="#tabbar">
    		<span class="mui-icon mui-icon-home"></span>
    		<span class="mui-tab-label">首页</span>
    	</a>
    	<a class="mui-tab-item" href="/simple/cart">
    		<span class="mui-icon mui-icon-extra mui-icon-extra-cart"></span>
    		<span class="mui-tab-label">购物车</span>
    	</a>
    	<a class="mui-tab-item" href="/ucenter/index">
    		<span class="mui-icon mui-icon-contact"><!--span class="mui-badge">1</span--></span>
    		<span class="mui-tab-label">个人中心</span>
    	</a>
    </nav>
		

<div class="mui-content">
	<div id="tabbar" class="mui-control-content mui-active">
		<header class="mui-bar mui-bar-nav" style="background-color: #5cc2d0;">
			<h1 class="mui-title" style="color:#fff">商 品 列 表</h1>
		</header>
		<div class="title" style="margin-top:52px">
          <?php foreach($goods_list as $key => $item){?>
          <?php $i++;?>
			<div class="mui-card">
			    <a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>"> 
				<div class="mui-card-header mui-card-media" style="height:45vw;background-image:url(<?php echo IUrl::creatUrl("")."".$item['img']."";?>)">
				    <div class="layer"></div>
				    <div class="layertxt"> &nbsp; 已售:<?php echo isset($item['sale'])?$item['sale']:"";?> &nbsp; &nbsp; 原价：<del>￥<?php echo isset($item['market_price'])?$item['market_price']:"";?></del> &nbsp; ￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?>
				    </div>
				</div>
				</a>
				<div class="mui-card-footer">
					<a class="mui-card-link"><?php echo isset($item['name'])?$item['name']:"";?></a>
					<a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>" class="mui-card-link mui-btn mui-btn-warning" style="height:28px">购买</a>
				</div>
			</div>
          <?php }?>
			<br><br>
            <div class="weui-footer">
              <p class="weui-footer__text">Copyright © 2017 乐享生活</p>
            </div>
		</div>
	</div>
	
</div>
    <?php if($this->iswechat == 1){?>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.1.0.js"> </script>
        <script type="text/javascript">
        sharedata = <?php echo $this->sharedata;?>;
        wx.config({ //debug: true, // 开启调试模式
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
<script src="<?php echo $this->getWebViewPath()."javascript/mui2/js/mui.min.js";?>"></script>
<script>
	mui.init({swipeBack:true});
	mui('nav').on('tap','a',function(){document.location.href=this.href;});
</script>
</body>
</html>