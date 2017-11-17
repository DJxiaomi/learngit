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
	<link rel="stylesheet" type="text/css" href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" />
<form class="mui-input-group" action="<?php echo IUrl::creatUrl("/ucenter/update_trade_password");?>" method="post" enctype='multipart/form-data' id="passwordForm">
	<div class="mui-input-row">
		<label>手机号码</label>
		<input type="text" placeholder="请输入手机号码" value="" name="mobile" id="mobile" />
		<a href="javascript:;" id="sendcode" class="sendcode">发送验证码</a>
	</div>
	<div class="mui-input-row">
		<label>验证码</label>
		<input type="text" placeholder="验证码" value="" name="mobile_code" id="mobile_code" />
	</div>
	<div class="mui-content-padded">
		<input type="hidden" name="order_id" value="<?php echo $this->order_id;?>" />
        <button type="button" id="postpassword" class="mui-btn mui-btn-primary mui-btn-block">确定修改</button>
    </div>
</form> 

<script type='text/javascript'>
var default_time = 60;
var s_count = 60;
var send_status = true;
document.getElementById('sendcode').addEventListener('tap', function(){
    var mobile = document.getElementById('mobile').value;
    var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
	if(!myreg.test(mobile))
	{
		mui.toast('手机号码不正确');
		return false;
	}
    if ( s_count == default_time && send_status ){
        mui.get('<?php echo IUrl::creatUrl("/ucenter/send_password_sms");?>', {"mobile":mobile, "type":7}, function(res){
            if(res == 'success'){
                updateState();
                timer = setInterval(function(){
                    updateState();
                }, 1000);
            }else{
                mui.toast(res);
            }
        });
    }
});

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
    document.getElementById('postpassword').addEventListener('tap', function(){
    	var _mobile = $('#mobile').val();
		var _mobile_code = $('#mobile_code').val();

		if ( _mobile == '' ) {
			mui.toast('手机号码不能为空');
			return false;
		} else if ( _mobile_code == '' ) {
			mui.toast('手机验证码不能为空');
			return false;
		}else {
			$('#passwordForm').submit();
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
			<a class="mui-tab-item money <?php if($this->getId() == 'site' && $_GET['action'] == 'chit'){?>mui-hot-money<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit");?>" id="ztelBtn">
					<span class="mui-tab-label">代金券</span>
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
