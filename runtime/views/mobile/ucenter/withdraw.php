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
	<?php $callback = IUrl::creatUrl('/ucenter/account_log');?>
<link href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" rel="stylesheet" type="text/css" />
<div class="mui-card">
    <div class="mui-card-content">
        <div class="mui-card-content-inner">
            账户余额：<span class="ordbigbt-price">￥<?php echo isset($this->memberRow['balance'])?$this->memberRow['balance']:"";?></span>
        </div>
    </div>
</div>
<h5 class="mui-content-padded">我要提现</h5>
<form action='<?php echo IUrl::creatUrl("/ucenter/withdraw_act");?>' method='post' id='withdrawForm'>
<div class="mui-card">
    <?php if($trade){?>
    <div class="mui-input-group">
        <div class="mui-input-row">
            <label>收款人姓名</label>
            <input type="text" name="name" id="name" value="" placeholder="请填写真实的收款人姓名" />
        </div>
        <div class="mui-input-row">
            <label>银行卡号</label>
            <input type="text" name="cart_no" id="cart_no" value="" placeholder="请填写开户银行的卡号" />
        </div>
        <div class="mui-input-row">
            <label>银行名称</label>
            <input type="text" name="bank_name" id="bank_name" value="" placeholder="如：中国建设银行某某支行" />
        </div>
        <div class="mui-input-row">
            <label>提现金额</label>
            <input type="text" name="amount" id="amount" value="" placeholder="填写提现金额" />
        </div>
        <div class="mui-input-row">
            <label>交易密码</label>
            <input type="password" name="trade_password" id="trade_password" value="" placeholder="请填写交易密码" />
        </div>
    </div>
    <?php }else{?>
    <div class="mui-card-content">
        <div class="mui-card-content-inner">
            请先设置交易密码，<a href="<?php echo IUrl::creatUrl("/ucenter/update_trade_password_ver");?>">去设置</a>
        </div>
    </div>
    <?php }?>
</div>
<?php if($trade){?>
<div class="mui-content-padded">
    <button type="button" class="mui-btn mui-btn-primary mui-btn-block" id="withdraw">提交提现申请</button>
</div>
<?php }?>
</form>
<script language="javascript">
<?php if($message){?>
mui.toast('<?php echo isset($message)?$message:"";?>');
<?php }?>
$(function(){
    document.getElementById('withdraw').addEventListener('tap', function(){
        var name = $('#name').val();
        var cart_no = $('#cart_no').val();
        var bank_name = $('#bank_name').val();
        var amount = $('#amount').val();
        var trade_password = $('#trade_password').val();

        if ( name == '' ) {
            mui.toast('收款人姓名不能为空');
            return false;
        } else if ( cart_no == '' ) {
            mui.toast('开户银行的卡号不能为空');
            return false;
        }else if ( bank_name == '' ) {
            mui.toast('银行名称不能为空');
            return false;
        }else if ( amount == '' ) {
            mui.toast('提现金额不能为空');
            return false;
        }else if ( trade_password == '' ) {
            mui.toast('交易密码不能为空');
            return false;
        }else {
            $('#withdrawForm').submit();
            return false;
        }
    });
});
</script>


	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
	    <a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
	    <a class="mui-tab-item money <?php if($this->getId() == 'site' && $_GET['action'] == 'chit2'){?>mui-hot-money<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit2");?>">
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
