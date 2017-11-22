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
	
	<nav class="mui-bar mui-bar-tab">
    	<a class="mui-tab-item" href="/">
    		<span class="mui-icon mui-icon-home"></span>
    		<span class="mui-tab-label">首页</span>
    	</a>
    	<a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/simple/cart");?>">
    		<span class="mui-icon mui-icon-extra mui-icon-extra-cart"></span>
    		<span class="mui-tab-label">购物车</span>
    	</a>
    	<a class="mui-tab-item mui-active" href="<?php echo IUrl::creatUrl("/ucenter");?>">
    		<span class="mui-icon mui-icon-contact"></span>
    		<span class="mui-tab-label">个人中心</span>
    	</a>
    </nav>

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
<form id='login-form' class="mui-input-group">
    <div class="mui-input-rows">
        <input type="text" class="mui-input-clear mui-input" name="login_info" id="login_info" placeholder="用户名/手机号/邮箱">
    </div>
    <div class="mui-input-rows">
        <input type="password" class="mui-input-clear mui-input" name="password" id="password" placeholder="密码">
    </div>
</form>
<form class="mui-input-group">
    <ul class="mui-table-view mui-table-view-chevron">
        <li class="mui-table-view-cell">
            保持登录状态
            <div class="mui-switch">
                <div class="mui-switch-handle"></div>
            </div>
        </li>
        <input type="hidden" name="autoLogin" id="autoLogin" value="0" />
    </ul>
</form>
<div class="mui-content-padded">
    <button id='login' class="mui-btn mui-btn-block mui-btn-primary">登录</button>
    <?php $callback = $this->callback;?>
    <div class="link-areas"><a id='reg' href="<?php echo IUrl::creatUrl("simple/reg/");?>?callback=<?php echo isset($callback)?$callback:"";?>">手机注册</a> <a href="<?php echo IUrl::creatUrl("simple/find_password");?>" id='forgetPassword'>忘记密码</a></div>
</div>

<script type="text/javascript">
document.getElementById('login').addEventListener('tap', function(){
    var login_info = document.getElementById('login_info').value,
        password = document.getElementById('password').value;
    if(login_info == ''){
        mui.toast('请输入用户名');
        return false;
    }
    if(password == ''){
        mui.toast('请输入密码');
        return false;
    }
    mui.post('<?php echo IUrl::creatUrl("/simple/login_ajax");?>', {login_info: login_info, password: password}, function(json){
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
</script>

<script type='text/javascript' src="<?php echo $this->getWebViewPath()."/javascript/login.js";?>"></script>

	</div>

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