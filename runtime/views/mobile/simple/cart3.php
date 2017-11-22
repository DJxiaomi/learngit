<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>康卓商城cart3</title>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/weui/weui.css";?>">
	<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/mui.min.css";?>">
	<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/icons-extra.css";?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/app.css";?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->getWebViewPath()."javascript/mui2/css/common.css";?>"/>
    <script type="text/javascript" src="/resource/scripts/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui2/js/mui.picker.js";?>"></script>
    <script type='text/javascript' src='<?php echo $this->getWebViewPath()."javascript/orderFormClass.js";?>'></script>
</head>
<body>

<div class="mui-content">
    <div id="tabbar" class="mui-control-content mui-active">
        <header class="mui-bar mui-bar-nav" style="background-color: #5cc2d0;">
            <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
            	<h1 class="mui-title" style="color:#fff">订单详情</h1>
        </header>
        <div class="mui-card" style="margin: 68px 30px 0px">
            <ul class="mui-table-view mui-table-view-striped mui-table-view-condensed" style="margin-top:8px">
				 <li class="mui-table-view-cell">订单编号： <?php echo $this->order_num;?></li>
		         <li class="mui-table-view-cell">订单金额：￥<b><?php echo $this->final_sum;?></b></li>
		         <li class="mui-table-view-cell">收货人名：<?php echo isset($accept_name)?$accept_name:"";?></li>
		         <li class="mui-table-view-cell">联系方式：<?php echo isset($mobile)?$mobile:"";?></li>
			</ul>
        </div>
		<?php if($this->deliveryType != 1 && $this->paymentType == 1){?>
		<?php $tmpId=$this->order_id;?>
		<form action='<?php echo IUrl::creatUrl("/block/doPay/order_id/".$tmpId."");?>' method='post' target='_blank'>
		    <center>
			    <input class="mui-btn mui-btn-danger mui-btn-block submit_pay"
			    style="width: 80%;margin:35px 10px 10px;padding: 10px 15px;border: 1px solid #5cc2d0;background-color: #5cc2d0;"
			    type="submit" value="立即支付" onclick="return dopay();" />
		    </center>
		</form>
		<?php }?>
        <br><br><br>
    </div>
</div>
    <?php if($this->iswechat == 1){?>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.1.0.js"> </script>
        <script type="text/javascript">
        sharedata = <?php echo $this->sharedata;?>;
        wx.config({
            //debug: true, // 开启调试模式
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
function dopay()
{
	window.location.href='<?php echo IUrl::creatUrl("/ucenter/order");?>';
}
</script>
</body>
</html>
