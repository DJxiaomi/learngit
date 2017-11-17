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
	<?php $callback = IReq::get('callback') ? IUrl::creatUrl(IReq::get('callback')) :IUrl::getRefRoute()?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->getWebSkinPath()."css/simple.css";?>" />
<script language="javascript">
var _callback = '<?php echo isset($callback)?$callback:"";?>';
var _this_callback = '<?php echo $this->callback;?>';
var _reg_url = '<?php echo IUrl::creatUrl("/simple/reg?callback=".$callback."");?>';
var _login_url = '<?php echo IUrl::creatUrl("/simple/login_pc_ajax?callback=".$callback."");?>';
var _oauth_login_url = '<?php echo IUrl::creatUrl("/simple/oauth_login");?>';
</script>
<form id='reg-form' class="mui-input-group">
    <div class="mui-input-rows">
        <input type="text" class="mui-input" name="mobile" id="mobile" placeholder="请输入手机号">
        <a href="javascript:;" id="sendcode" class="sendcode">发送验证码</a>
    </div>
    <div class="mui-input-rows promo_code_div" style="display:none;">
        <input type="text" class="mui-input-clear mui-input" name="mobile_code" id="mobile_code" placeholder="请输入手机验证码">
    </div>

    <div class="mui-input-rows">
        <input type="password" class="mui-input-clear mui-input" name="password" id="password" placeholder="请输入密码">
    </div>
    <div class="mui-input-rows" style="display:none;">
        <input type="password" class="mui-input-clear mui-input" name="repassword" id="repassword" placeholder="再次输入密码">
    </div>
    <div class="mui-input-rows">
        <input type="text" class="mui-input-clear mui-input" name="promo_code" id="promo_code" placeholder="没有推广人可不填">
    </div>

</form>
<div class="mui-content-padded">
    <button id='reg' class="mui-btn mui-btn-block mui-btn-primary">注册</button>
</div>

<script type="text/javascript">
var default_time = 60;
var s_count = 60;
var send_status = true;
document.getElementById('sendcode').addEventListener('tap', function(){
    var mobile = document.getElementById('mobile').value;
    if ( s_count == default_time && send_status ){
        mui.get('<?php echo IUrl::creatUrl("/simple/send_reg_sms");?>', {mobile: mobile}, function(res){
            if(res == 'success'){
                $('.promo_code_div').show();
                updateState();
                timer = setInterval(function(){
                    updateState();
                }, 1000);
            }else{
                $('.promo_code_div').show();
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

document.getElementById('reg').addEventListener('tap', function(){
    var password = document.getElementById('password').value,
        repassword = document.getElementById('repassword').value,
        mobile = document.getElementById('mobile').value,
        mobile_code = document.getElementById('mobile_code').value,
        promo_code = document.getElementById('promo_code').value;
        //captcha = document.getElementById('captcha').value;

    if(mobile == ''){
        mui.toast('请输入手机号码');
        return false;
    }
    if(mobile_code == ''){
        mui.toast('请输入手机验证码');
        return false;
    }
    if(password == ''){
        mui.toast('请输入密码');
        return false;
    }
    // if(password != repassword){
    //     mui.toast('两次密码不一致');
    //     return false;
    // }
    mui.post('<?php echo IUrl::creatUrl("/simple/reg_ajax");?>', {password: password, repassword: repassword, mobile: mobile, mobile_code: mobile_code, promo_code: promo_code}, function(json){
        if(json.message == 1){
            <?php if($this->callback){?>
            window.location.href = '<?php echo $this->callback;?>';
            <?php }else{?>
            window.location.href = '<?php echo IUrl::creatUrl("/ucenter/index");?>';
            <?php }?>
        }else{
            mui.toast(json.message);
        }
    }, 'json');
});
mui('.mui-content .mui-switch').each(function() {
    this.addEventListener('toggle', function(event) {
        document.getElementById('autoLogin').value = event.detail.isActive ? '1' : '0';
    });
});
$('.captcha').click(function(){
  $(this).removeAttr('src');
  var timestamp = new Date().getTime();
  $(this).attr('src', '<?php echo IUrl::creatUrl("/simple/getCaptcha/w/120/h/36");?>' + '?' + timestamp);
})
</script>
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."/javascript/login.js";?>"></script>

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

<?php if($id == 851){?>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/form.css";?>" />
<script>var pid = <?php echo isset($id)?$id:"";?>;</script>
<script language="javascript" src="<?php echo $this->getWebSkinPath()."js/form.js";?>"></script>
<?php }?>
