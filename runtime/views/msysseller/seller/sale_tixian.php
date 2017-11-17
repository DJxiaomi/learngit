<!doctype html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>管理中心</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<link href="/resource/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/form.css";?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/resource/scripts/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/jquery.juploader.js";?>"></script>
	<script type="text/javascript" src="/resource/scripts/common.js"></script>
	<script type="text/javascript">mui.init();var SITE_URL = '<?php echo IUrl::creatUrl("");?>';</script>
</head>
<body>
	<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '')){?>
	<?php }else{?>
	<header class="mui-bar mui-bar-nav">
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }else{?>
		<a href="" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<div class="mui-card">
    <div class="mui-card-content">
        <div class="mui-card-content-inner">
            账户余额：<span class="ordbigbt-price">￥<?php echo isset($sellerRow['sale_balance'])?$sellerRow['sale_balance']:"";?>元</span>
        </div>
    </div>
</div>
<h5 class="mui-content-padded">我要提现</h5>
<form action='<?php echo IUrl::creatUrl("/seller/sale_withdraw/type/1");?>' method='post' id='withdrawForm'>
<div class="mui-card">
    <?php if($sellerRow['sale_balance'] > 0 ){?>
    <div class="mui-input-group">
        <div class="mui-input-row">
            <label>提现金额</label>
            <input type="text" name="sale" id="sale" value="" placeholder="最多可提<?php echo isset($sellerRow['sale_balance'])?$sellerRow['sale_balance']:"";?>" onchange="check_balance()" />
        </div>
        <div class="mui-input-row" style="display:none;">
            <label>账户类型</label>
            <?php if($sellerRow['bank'] == 1){?>银行<?php }else{?>支付宝<?php }?>
        </div>
        <div class="mui-input-row">
            <label>银行名称</label>
            <?php echo isset($sellerRow['account_bank_name'])?$sellerRow['account_bank_name']:"";?>
        </div>
        <div class="mui-input-row">
            <label>支行名称</label>
            <?php echo isset($sellerRow['account_bank_branch'])?$sellerRow['account_bank_branch']:"";?>
        </div>
        <div class="mui-input-row">
            <label>收款账号</label>
            <?php echo isset($sellerRow['account_cart_no'])?$sellerRow['account_cart_no']:"";?>
        </div>
        <div class="mui-input-row">
            <label>账户户名</label>
            <?php echo isset($sellerRow['account_name'])?$sellerRow['account_name']:"";?>
        </div>
        <div class="mui-input-row">
    			<label>手机验证码</label>
    			<input type="text" placeholder="请输入手机验证码" value="" name="mobile_code" id="mobile_code" />
    			<a href="javascript:;" id="sendcode" class="sendcode">发送验证码</a>
    		</div>
    </div>
    <?php }else{?>
    <div class="mui-input-row">
        &nbsp; &nbsp; <font color="green">销售额不足</font>
    </div>
    <?php }?>
</div>
<?php if($sellerRow['sale_balance'] > 0 ){?>
<div class="mui-content-padded">
    <button type="button" id="withdraw" class="mui-btn mui-btn-primary mui-btn-block">提交申请</button>
</div>
<?php }?>
<div class="mui-card" style="display:none;">
    <div class="mui-card-header">结算详情</div>
    <div class="mui-card-content">
        <div class="mui-card-content-inner">
            <table width="100%" cellpadding="0" cellspacing="0" class="dingtable">
                <tr>
                    <th>订单详情</th>
                    <th>学员姓名</th>
                    <th>结算状态</th>
                    <th>未结算</th>
                    <th>已结算</th>
                </tr>
                <?php 
                $page = (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;
                $orderGoodsQuery = CountSum::getSellerGoodsFeeQuery($seller_id);
                $orderGoodsQuery->page = $page;
                ?>
                <?php foreach($orderGoodsQuery->find() as $key => $item){?>
                <?php $countData = CountSum::countSellerOrderFee(array($item))?>
                <?php $goods_list = Order_Class::get_order_goods_list($item['id'])?>
                <?php $goods = $goods_list[0]?>
                <?php $goods_array = $goods['goods_array']?>
                <?php $countFee = CountSum::countSellerOrderFee(array($item));?>
                <?php if($item['statement'] == 2 && $item['chit_id'] > 0 && $item['order_amount'] <= 0){?>
                <?php }elseif($item['statement'] == 4){?>
                <?php }else{?>
                <?php $total_not_settled += $item['not_settled']?>
                <?php $total_settled += $item['settled']?>
                <?php 
                        if( $item['statement'] == 1 )
                            $template = 'order_show';
                        else if ( $item['statement'] == 2 )
                            $template = 'order_show_dai';
                        else
                            $template = 'order_show_ding';
                ?>
                <tr>
                    <td align="center"><a href="<?php echo IUrl::creatUrl("/seller/".$template."/id/".$item['id']."");?>">查看订单</a></td>
                    <td align="center"><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td>

                    <td align="center"><?php if($item['is_checkout'] == 1){?>已结算<?php }elseif($item['is_checkout'] == 2){?>部分结算<?php }else{?>未结算<?php }?></td>
                    <td align="center"><?php echo isset($item['not_settled'])?$item['not_settled']:"";?></td>
                    <td align="center"><?php echo isset($item['settled'])?$item['settled']:"";?></td>
                </tr>
                <?php }?>
                <?php }?>
                <tr>
                    <td align="center">结算合计</td>
                    <td align="center">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="center"><?php echo isset($total_not_settled)?$total_not_settled:"";?></td>
                    <td align="center"><?php echo isset($total_settled)?$total_settled:"";?></td>
                </tr>
            </table>
        </div>
    </div>

</div>


<script type='text/javascript'>
var _sale_balance = <?php echo isset($sellerRow['sale_balance'])?$sellerRow['sale_balance']:"";?>;
var _mobile = '<?php echo isset($mobile)?$mobile:"";?>';
var default_time = 60;
var s_count = 60;
var send_status = true;
document.getElementById('sendcode').addEventListener('tap', function(){
	<?php if(!$can_tixian){?>
		mui.toast('账户信息不完善，请完善账户信息认证后再重新操作');
		return false;
	<?php }?>
    if ( s_count == default_time && send_status ){
        mui.getJSON('<?php echo IUrl::creatUrl("/seller/get_withdraw_code_ajax");?>', {}, function(res){
            if(res.done !== false){
                updateState();
                timer = setInterval(function(){
                    updateState();
                }, 1000);
            }else{
                mui.toast(res.msg);
            }
        });
    }
});

function check_balance()
{
  var _input_balance = $('#sale').val();
  if ( _input_balance != '' && parseInt(_input_balance) > _sale_balance )
  {
    mui.toast('可用余额不足');
    $('#sale').val(_sale_balance);
  }
}

function updateState(){
    if ( s_count > 0 ){
        s_count--;
        send_status = false;
        document.getElementById('sendcode').innerText = s_count + ' s后重新发送';
    } else {
        s_count = default_time;
        send_status = true;
        clearInterval(timer);
        document.getElementById('sendcode').innerText = '重新发送验证码';
    }
}
$(function(){
    document.getElementById('withdraw').addEventListener('tap', function(){
    	var _sale = $('#sale').val();
		if ( _sale == ''){
			mui.toast('请输入提现的金额');
			return false;
		}
		if( _sale > _sale_balance){
			return false;
		}
		if ( $('#mobile_code').val() == ''){
			mui.toast('请输入手机验证码');
			return false;
		}

		$('#withdrawForm').submit();
    });
});
</script>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/brand_edit");?>" id="ztelBtn">
	        <i class="mui-icon-my icon-book"></i>
	        <span class="mui-tab-label">页面信息</span>
	    </a>
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/seller_edit");?>" id="ztelBtn">
	        <i class="mui-icon-my icon-globe"></i>
	        <span class="mui-tab-label">基本信息</span>
	    </a>
	    <!-- <a class="mui-tab-item mui-hot" href="<?php echo IUrl::creatUrl("/seller/chit");?>">
	        <i class="mui-icon-my icon-github-alt"></i>
	        <span class="mui-tab-label">代金券</span>
	    </a> -->
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/order_list");?>">
	        <i class="mui-icon-my icon-shopping-cart"></i>
	        <span class="mui-tab-label">学校订单</span>
	    </a>
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/meau_index");?>" id="ltelBtn">
	        <i class="mui-icon-my icon-user"></i>
	        <span class="mui-tab-label">管理中心</span>
	    </a>
	</nav>
</body>
</html>
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
