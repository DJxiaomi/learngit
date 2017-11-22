<?php 
	$myCartObj  = new Cart();
	$myCartInfo = $myCartObj->getMyCart();
	$siteConfig = new Config("site_config");
	$callback   = IReq::get('callback') ? urlencode(IFilter::act(IReq::get('callback'),'url')) : '';
  $this->defaultAddressId = ( $this->defaultAddressId ) ? $this->defaultAddressId : ( $this->addressList ) ? $this->addressList[0]['id'] : 0;
?>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>康卓商城</title>
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
    <form action='<?php echo IUrl::creatUrl("/simple/cart3");?>' method='post' name='order_form' id="order_form">
        <input name="payment" type="radio" value="14" checked style="display:none">
    	<input type='hidden' name='timeKey' value='<?php echo time();?>' />
    	<input type='hidden' name='direct_gid' value='<?php echo $this->gid;?>' />
    	<input type='hidden' name='direct_type' value='<?php echo $this->type;?>' />
    	<input type='hidden' name='direct_num' id="direct_num" value='<?php echo $this->num;?>' />
    	<input type='hidden' name='direct_promo' value='<?php echo $this->promo;?>' />
    	<input type='hidden' name='direct_active_id' value='<?php echo $this->active_id;?>' />
    	<input type='hidden' name='takeself' value='0' />
	
            <div id="tabbar" class="mui-control-content mui-active">
                <header class="mui-bar mui-bar-nav" style="background-color: #5cc2d0;">
                    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
                    	<h1 class="mui-title" style="color:#fff">商 品 购 买</h1>
                </header>
                <div class="title" style="margin: 48px 30px 0px">
                    <h4>填写核对订单信息</h4>
                </div>
                <ul class="mui-table-view mui-table-view-striped mui-table-view-condensed" style="margin-top:8px">&nbsp;
                	<li class="mui-table-view-cell">
                		<div class="mui-slider-cell">
                			<div class="oa-contact-cell mui-table">
                			    <a class="mui-navigate-right">
                					<div class="oa-contact-avatar mui-table-cell">
                					    <span class="mui-icon mui-icon-location" style="height:50px;width:60px;font-size:42px"></span>
                					</div>
                					<div class="oa-contact-content mui-table-cell">
                						<div class="mui-clearfix">
                							<span class="oa-contact-position mui-h5">学员姓名：
                							<input type="text" id="accept_name" name="accept_name" value="小米" class="oa-contact-position mui-h6" style="width:80px;height:20px;border:none"/>
                							</span>
                						</div>
                						<p class="oa-contact-email mui-h5">学员电话： 
                						<input type="text" id="mobile" name="mobile" value="1304892106" class="oa-contact-position mui-h6" style="width:130px;height:20px;border:none"/>
                						</p>
                					</div>
                		        </a>
                				<input type="hidden" name="province" value="111111">
                                <input type="hidden" name="city" value="111111">
                                <input type="hidden" name="area" value="111111">
                                <input type="hidden" name="address" value="默认地址">
                                <input type="hidden" name="phone" value="123456">
                                <input type="hidden" name="zip" value="000000">
                			</div>
                		</div>
                	</li>
                </ul>
	
                <ul class="mui-table-view" style="margin: 10px 0px 18px;">
			        <?php foreach($this->goodsList as $key => $item){?>
    				<li class="mui-table-view-cell mui-media">
    					<a href="javascript:;">
    						<img class="mui-media-object mui-pull-left" src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/80/h/80");?>">
    						<div class="mui-media-body">
        						<?php echo isset($item['name'])?$item['name']:"";?><?php if($item['spec']){?>  - <?php echo isset($item['spec'])?$item['spec']:"";?><?php }?>
    							<p class="mui-ellipsis">
    							单价：<span class="red3">&yen;<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></span>
    							&nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp; 
    							人数：<span class="red3"><?php echo isset($item['count'])?$item['count']:"";?>&nbsp;人</span>
    							</p>
    						</div>
    					</a>
    				</li>
		            <?php }?>
    			</ul>
    			
                <div class="mui-input-row" style="margin: 10px 15px;">
    				<textarea id="textarea" name="message" rows="2" placeholder="订单备注 ..." style="background-color:#efeff4"></textarea>
			        <?php foreach($this->goodsList as $key => $item){?>
    							<p class="mui-ellipsis" style="text-align: right;">
    							共 <?php echo isset($item['count'])?$item['count']:"";?>个课程，总计 <?php echo $this->final_sum;?>元
    							</p>
		            <?php }?>
    			</div>

    			<center>
                    <button type="button" class="mui-btn mui-btn-danger mui-btn-block" onclick="submitForm();"
                    style="width: 90%;margin:10px 10px 10px;padding: 10px 15px;border: 1px solid #5cc2d0;background-color: #5cc2d0;">确认无误，提交订单</button>
    			</center>
			    <br><br><br>
            </div>
        
    </form>
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
</script>

<script type='text/javascript'>
//创建订单表单实例
orderFormInstance = new orderFormClass();
sellerList = <?php echo JSON::encode($this->seller);?>;
ticketList = <?php echo JSON::encode($this->prop);?>;addressList = <?php if($this->addressListJson){?><?php echo $this->addressListJson;?><?php }else{?>new Array()<?php }?>;
addressList = <?php if($this->addressListJson){?><?php echo $this->addressListJson;?><?php }else{?>new Array()<?php }?>;
sell_count = <?php if($this->sell_count){?><?php echo $this->sell_count;?><?php }else{?>0.00<?php }?>;
market_count = <?php if($this->market_count){?><?php echo $this->market_count;?><?php }else{?>0.00<?php }?>;

var _max_cprice = <?php if($this->max_cprice){?><?php echo $this->max_cprice;?><?php }else{?>0<?php }?>;
var _max_order_chit = <?php if($this->order_chit>0){?><?php echo $this->order_chit;?><?php }else{?>0<?php }?>;
var _cprice = <?php if($this->max_cprice){?><?php echo $this->max_cprice;?><?php }else{?>0<?php }?>;
var _order_chit = <?php if($this->order_chit>0){?><?php echo $this->order_chit;?><?php }else{?>0<?php }?>;
var _order_amount = <?php echo $this->final_sum;?>;

//DOM加载完毕
jQuery(function(){

	orderFormInstance.addressInit("<?php echo $this->defaultAddressId;?>", "<?php echo $this->mtruename;?>", "<?php echo $this->mtelephone;?>");

	//支付方式
	orderFormInstance.paymentInit("<?php echo isset($this->custom['payment'])?$this->custom['payment']:"";?>");

	// 支付方式自动保存
	$('input[name=payment]').click(function(){
		orderFormInstance.paymentSave();
	})

	$('.add_teaching_time').click(function(){
		$('.teaching_time2 ul').append('<li>' + $('.teaching_time2 li').eq(0).html() + '</li>');
	})

	// 地址自动保存
	$('.addr_list input[name=radio_address]').click(function(){
		var _radio_id = $(this).val();
		if ( _radio_id != '' )
		{
			address_save();
		}
	})

	function caculate()
	{
		var _coupon_nums = $("input[name=coupon_nums]").val();
		if ( $('input[name=use_coupon]').val() == '1' )
		{
			var _sum = market_count - _coupon_nums;
			var _t_yh = _order_chit - parseFloat($("input[name=coupon_nums]").val());
			$('.yh').html( _t_yh );
		} else {
			var _sum = market_count;
		}

		$('.yf_count').html(_sum);
	}



});

//[address]保存到常用的地址
function address_save()
{
	if(orderFormInstance.addressCheck())
	{
		if ( addressList.length > 0 )
		{
			var _accept_name = $('input[name=accept_name]').val();
			var _mobile = $('input[name=mobile]').val();
			if ( _accept_name == '' || _mobile == '')
			{
				mui.toast('姓名或联系方式不能为空');
				return false;
			}
			for( var i = 0; i < addressList.length; i++)
			{
				if ( addressList[i]['accept_name'] == _accept_name && addressList[i]['mobile'] == _mobile )
				{
					$('.addr_list').find("input[type=radio]").eq(i).attr("checked","checked");
					orderFormInstance.addressSave();
					$('#order_form').submit();
					return;
				}
			}
		}
		$.getJSON('<?php echo IUrl::creatUrl("/simple/address_add");?>',$('form[name="order_form"]').serialize(),function(content){
			if(content.data)
			{
				//$('input:radio[name="radio_address"]:first').trigger('click');
				$('#order_form').submit();
				return;
			}
			//orderFormInstance.addressSave();
		});
		var _address_info = [];
		var _accept_name = $('input[name=accept_name]').val();
		var _mobile = $('input[name=mobile]').val();
		_address_info['accept_name'] = _accept_name;
		_address_info['mobile'] = _mobile;
		addressList.push(_address_info);
	}
}

function submitForm(){
	var accept_name = document.getElementById('accept_name').value,
		mobile = document.getElementById('mobile').value;
	if(accept_name == ''){
		mui.alert('请填写联系人', '提示信息');
		return false;
	}
	if(mobile == ''){
		mui.alert('请填写手机号码', '提示信息');
		return false;
	}

	address_save();
	// $('#order_form').submit();
}
</script>
</body>
</html>