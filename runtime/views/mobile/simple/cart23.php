<?php
	$member_info = member_class::get_member_info($this->user['user_id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- <title><?php echo $this->_siteConfig->name;?></title> -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<link href="<?php echo IUrl::creatUrl("")."resource/css/font-awesome.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/jquery-3.1.1.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/common.js";?>"></script>
	<!-- <script type="text/javascript">mui.init({swipeBack:true});var SITE_URL = '<?php echo IUrl::creatUrl("");?>';</script> -->
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
	<?php 
	$myCartObj  = new Cart();
	$myCartInfo = $myCartObj->getMyCart();
	$siteConfig = new Config("site_config");
	$callback   = IReq::get('callback') ? urlencode(IFilter::act(IReq::get('callback'),'url')) : '';
    $this->defaultAddressId = ( $this->defaultAddressId ) ? $this->defaultAddressId : ( $this->addressList ) ? $this->addressList[0]['id'] : 0;
?>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<link href="<?php echo $this->getWebSkinPath()."css/cart.css";?>" rel="stylesheet" type="text/css" />
<style>
.list_table input[type=text], .list_table select {width: auto;}
.notice {margin-left:0px;margin-top:15px;}
.notice b {color:red;font-size:12px;}
.teaching_time2 {padding-left:3%;font-size:100%;}
.teaching_time2 select, .teaching_time2 input {width:auto;}
.teaching_time2 input {border:1px solid #666;height:22px;line-height:22px; width: 80px;}
.list_table input {height: 25px; padding: 0px; border: 1px solid #ccc;}
.list_table tr {height: 28px; line-height: 28px;}
.form_table2 { border-bottom: 1px solid #f4f4f4; margin-bottom: 8px;}
.form_table2 th {width: 79px;}
.form_table2 td input {width: 60px; font-size: 100%; text-indent: 3px;}
</style>
<script type='text/javascript' src='<?php echo $this->getWebViewPath()."javascript/orderFormClass2.js";?>'></script>
<form action='<?php echo IUrl::creatUrl("/simple/cart3");?>' method='post' name='order_form' id="order_form">
	<input type='hidden' name='timeKey' value='<?php echo time();?>' />
	<input type='hidden' name='direct_gid' value='<?php echo $this->gid;?>' />
	<input type='hidden' name='direct_type' value='<?php echo $this->type;?>' />
	<input type='hidden' name='direct_num' id="direct_num" value='<?php echo $this->num;?>' />
	<input type='hidden' name='direct_promo' value='<?php echo $this->promo;?>' />
	<input type='hidden' name='direct_active_id' value='<?php echo $this->active_id;?>' />
	<input type='hidden' name='takeself' value='0' />
	<input type='hidden' name='dprice' value='<?php echo $this->dprice;?>' />
	<input type='hidden' name='stime' value='<?php echo $this->stime;?>' />
	<input type='hidden' name='statement' value='<?php echo $this->statement;?>' />
	<input type="hidden" name="ischit" value="<?php echo $this->ischit;?>" />
	<input type="hidden" name="chitid" value="<?php echo $this->chitid;?>" />
	<input type="hidden" name="seller_tutor_id" value="<?php echo $this->seller_tutor_id;?>" />
	<input type="hidden" name="user_tutor_id" value="<?php echo $this->user_tutor_id;?>" />
	<input type="hidden" name="seller_id" value="<?php echo $this->seller_id;?>" />
	<h5 class="mui-content-padded">联系人：</h5>
	<div class="mui-card">
		<div class="mui-input-group" id="address_form">
			<?php foreach($this->addressList as $key => $item){?>
			<div class="mui-input-row mui-radio mui-left">
				<label><?php echo isset($item['accept_name'])?$item['accept_name']:"";?>&nbsp;&nbsp;<?php echo isset($item['mobile'])?$item['mobile']:"";?></label>
				<input name="radio_address" type="radio" value="<?php echo isset($item['id'])?$item['id']:"";?>" onclick='orderFormInstance.addressSelected(<?php echo JSON::encode($item);?>);' data-json='<?php echo JSON::encode($item);?>'>
			</div>
	        <?php }?>
	        <div class="mui-input-row mui-radio mui-left">
				<label>新联系人</label>
				<input name="radio_address" type="radio" value="" onclick='orderFormInstance.addressEmpty();' <?php if(!$this->addressList){?>checked<?php }?>>
			</div>
			<div class="addr_list" id="acceptbox" style="display:none;">
				<div class="mui-input-row">
					<!-- <label>联系人姓名</label> -->
					<input type="text" class="mui-input-clear mui-input" id="accept_name" name="accept_name" value="" placeholder="姓名" />
				</div>
				<div class="mui-input-row">
					<!-- <label>手机号码</label> -->
					<input type="text" class="mui-input-clear mui-input" name="mobile" id="mobile" value="" placeholder="手机号码" />
				</div>
				<input type="hidden" name="province" value="111111">
                <input type="hidden" name="city" value="111111">
                <input type="hidden" name="area" value="111111">
                <input type="hidden" name="address" value="默认地址">
                <input type="hidden" name="phone" value="123456">
                <input type="hidden" name="zip" value="000000">
			</div>
		</div>
	</div>
	<h5 class="mui-content-padded" style="display:none;">支付方式</h5>
	<div class="mui-card" style="display:none;">
		<div class="mui-input-group">
			<?php $paymentList=Api::run('getPaymentList')?>
	    	<?php foreach($paymentList as $key => $item){?>
	    	<?php $paymentPrice = CountSum::getGoodsPaymentPrice($item['id'],$this->sum);?>
			<?php if($item['id'] != 10){?>
			<?php unset($item['config_param'])?>
			<?php unset($item['description'])?>
				<div class="mui-input-row mui-radio mui-left">
					<label><?php echo isset($item['name'])?$item['name']:"";?></label>
					<input name="payment" type="radio" alt="<?php echo isset($paymentPrice)?$paymentPrice:"";?>" value="<?php echo isset($item['id'])?$item['id']:"";?>" onclick='orderFormInstance.paymentSelected(<?php echo JSON::encode($item);?>);' title="<?php echo isset($item['name'])?$item['name']:"";?>"<?php if($item['id'] == 10){?> checked<?php }?>>
				</div>
			<?php }?>
			<?php if(IClient::isWechat()){?>
				<div class="mui-input-row mui-radio mui-left">
					<label>微信支付</label>
					<input name="payment" type="radio" value="14" checked>
				</div>
			<?php }?>
	  	<?php }?>
		</div>
	</div>

	<?php if($this->ischit || $this->seller_tutor_id || $this->user_tutor_id){?>
	<?php }else{?>
	<h5 class="mui-content-padded"></h5>
	<div>
		<ul class="mui-table-view">
			<?php foreach($this->goodsList as $key => $item){?>
		    <li class="mui-table-view-cell mui-media">
		    	<img class="mui-media-object mui-pull-left" src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/80/h/80");?>">
	    		<div class="mui-media-body">
	    			<?php echo isset($item['name'])?$item['name']:"";?><?php if($item['spec']){?>  - <?php echo isset($item['spec'])?$item['spec']:"";?><?php }?>
	    			<?php $cprice = number_format( order_class::get_cprice($item['dprice'], $item['rprice']), 2, '.', '');?>
					<?php
						$t_dprice = order_class::get_dprice($item['market_price'], $item['cost_price']);
						$t_rprice = order_class::get_rprice($t_dprice);
						$t_cprice = number_format( order_class::get_cprice($t_dprice, $t_rprice), 2, '.', '');
						$t_chit = number_format( order_class::get_max_order_chit($item['market_price'], $item['cost_price'], $t_dprice ),2, '.', '');

						$update_cprice = order_class::get_max_input_cprice($t_cprice);
						$update_chit = number_format( order_class::get_real_order_chit( $item['market_price'], $item['cost_price'], $update_cprice ), 2, '.','');
					?>
					<div class="qindanjg">价格：<span class="red3">&yen;<?php echo isset($item['market_price'])?$item['market_price']:"";?></span></div>
					<div>类型：<span class="red3">免费课</span></div>
					<div>人数：<span class="red3"><?php echo isset($item['count'])?$item['count']:"";?>&nbsp;人</span></div>
	    		</div>
		    </li>
		    <?php }?>
		</ul>
	</div>
	<?php }?>
	<h5 class="mui-content-padded"></h5>
	<div class="mui-content-padded">
		<button type="button" class="mui-btn mui-btn-primary mui-btn-block" id="confirm">提交报名免费课</button>
	</div>
</form>

<script type='text/javascript'>
//创建订单表单实例
orderFormInstance = new orderFormClass();
sellerList = <?php echo JSON::encode($this->seller);?>;
ticketList = <?php echo JSON::encode($this->prop);?>;addressList = <?php if($this->addressListJson){?><?php echo $this->addressListJson;?><?php }else{?>array()<?php }?>;
addressList = <?php if($this->addressListJson){?><?php echo $this->addressListJson;?><?php }else{?>array()<?php }?>;
sell_count = <?php if($this->sell_count){?><?php echo $this->sell_count;?><?php }else{?>0.00<?php }?>;
market_count = <?php if($this->market_count){?><?php echo $this->market_count;?><?php }else{?>0.00<?php }?>;
order_chit = <?php echo $this->order_chit;?>;

<?php if($this->statement != 2){?>
var _max_cprice = <?php if($this->max_cprice){?><?php echo $this->max_cprice;?><?php }else{?>0<?php }?>;
var _max_order_chit = <?php echo $this->order_chit;?>;
var _cprice = <?php if($this->max_cprice){?><?php echo $this->max_cprice;?><?php }else{?>0<?php }?>;
var _order_chit = <?php echo $this->order_chit;?>;
var _order_amount = <?php echo $this->final_sum;?>;
<?php }?>

//DOM加载完毕
jQuery(function(){

	orderFormInstance.addressInit("<?php echo $this->defaultAddressId;?>", "<?php echo $this->mtruename;?>", "<?php echo $this->mtelephone;?>");

	//支付方式
	orderFormInstance.paymentInit("<?php echo isset($this->custom['payment'])?$this->custom['payment']:"";?>");

	// 支付方式自动保存
	$('input[name=payment]').click(function(){
		orderFormInstance.paymentSave();
	})

	<?php if(!$this->addressList){?>
		orderFormInstance.addressEmpty();
	<?php }?>

	// 地址自动保存
	$('.addr_list input[name=radio_address]').click(function(){
		var _radio_id = $(this).val();
		if ( _radio_id != '' )
		{
			address_save();
		}
	})

	<?php if($this->statement == 1 or $this->statement == 3){?>
	$('input[name=use_coupon]').click(function(){
		update_use_coupon();
	});

	function update_use_coupon()
	{
		if ( $('input[name=use_coupon]').val() == '1' )
		{
			var _coupon_nums = $("input[name=coupon_nums]").val();
			$('input[name=coupon_nums]').removeAttr('disabled');
			$('.dai_nums').html(_coupon_nums );
		} else {
			$('.dai_nums').html('0');
			$('input[name=coupon_nums]').attr('disabled', 'disabled');
		}

		caculate();
	}
	<?php }?>

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

	document.getElementById('confirm').addEventListener('tap', function(){
		submitForm();
	});

	document.getElementById('add').addEventListener('tap', function(){
		var num = document.getElementById('num').value;
		document.getElementById('direct_num').value = num;
	});

	document.getElementById('minus').addEventListener('tap', function(){
		var num = document.getElementById('num').value;
		document.getElementById('direct_num').value = num;
	});
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
	//$('#order_form').submit();
}
</script>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
	    <a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'activity_discount'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/school/home/id/365");?>" id="ztelBtn">
	        <span class="mui-tab-label">免费</span>
	    </a>
	    <a class="mui-tab-item money <?php if($this->getId() == 'site' && $_GET['action'] == 'activity_props'){?>mui-hot-money<?php }?>" href="<?php echo IUrl::creatUrl("/school/home/id/366");?>">
	        <span class="mui-tab-label">券</span>
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
<!-- mui('body').on('tap', 'a', function(){ -->
    <!-- if(this.href != '#' && this.href != ''){ -->
        <!-- mui.openWindow({ -->
            <!-- url: this.href -->
        <!-- }); -->
    <!-- } -->
    <!-- this.click(); -->
<!-- }); -->

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