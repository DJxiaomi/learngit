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
	<script language="javascript">
var _send_reg = '<?php echo IUrl::creatUrl("/simple/send_reg_sms");?>';
</script>
<script type='text/javascript' src="/resource/scripts/layer_mobile/layer.js"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/seller.js";?>"></script>
<style>
.sendcode {position:absolute;right: 0px;top:12px;width: 100px;z-index:3;font-size:90%;text-align:center;}
.mui-btn-primary {width:96%;border-radius:5px;background:linear-gradient(to right,#ff9638,#ff4b2b);border:0px;}
.tab {display:none;}
.tab_1 {display:block;}
</style>
<div class="mui-content-padded" style="margin:0;">
	<form class="mui-input-group" action="<?php echo IUrl::creatUrl("/simple/seller_reg");?>" id="mobileWay" method="post" enctype='multipart/form-data'>
		<div class="tab tab_1">
			<div class="mui-input-row">
				<label>手机号</label>
				<input type="number" name="mobile" id="mobile" value="" placeholder="请输入手机号" />
				<a href="javascript:;" id="sendcode" class="sendcode" onclick="sendMessage();">获取验证码</a>
			</div>
			<div class="mui-input-row">
				<label>验证码</label>
				<input type="number" name="mobile_code" id="mobile_code" value="" placeholder="请输入验证码" />
			</div>
			<div class="mui-content-padded">
					<a class="mui-btn mui-btn-block mui-btn-primary" onclick="check_step_1();">下一步</a>
			</div>
		</div>

		<div class="tab tab_2">
			<div class="mui-input-row">
				<label>学校名称</label>
				<input type="text" name="seller_name" id="seller_name" value="" placeholder="请输入学校名称" />
			</div>
			<div class="mui-input-row">
				<label>密码</label>
				<input name="password" type="password" value="" placeholder="请输入密码" />
			</div>
			<div class="mui-input-row">
				<label>重复密码</label>
				<input name="repassword" type="password" value="" placeholder="请再次输入密码" />
			</div>
			<div class="mui-content-padded">
					<a class="mui-btn mui-btn-block mui-btn-primary" onclick="check_step_2();">下一步</a>
			</div>
		</div>

		<div class="tab tab_3">
			<div class="mui-input-row">
				<label>推广码</label>
				<input type="text" name="promo_code" value="" placeholder="输入推广人的推广码" />
			</div>
			<div class="mui-content-padded">
					<button class="mui-btn mui-btn-block mui-btn-primary" onclick="check_step_2();">提交</button>
			</div>
		</div>

	</form>
</div>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
	    <a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'activity_free_class'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/activity_free_class");?>" id="ztelBtn">
	        <span class="mui-tab-label">免费</span>
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
