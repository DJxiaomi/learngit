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
	<?php $callback = IUrl::creatUrl('/ucenter/index');?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.poppicker.css";?>" rel="stylesheet" type="text/css" />
<?php $user_ico = $this->user['head_ico']?>
<form class="mui-input-group" action="<?php echo IUrl::creatUrl("/ucenter/info_edit_act");?>" method="post" enctype='multipart/form-data'>
	<div class="mui-input-row">
		<label>姓名</label>
		<input type="text" placeholder="姓名" value="<?php echo isset($this->memberRow['true_name'])?$this->memberRow['true_name']:"";?>" name="true_name" />
	</div>
	<div class="mui-input-row">
		<label>邮箱</label>
		<input type="text" placeholder="邮箱" value="<?php echo isset($this->memberRow['email'])?$this->memberRow['email']:"";?>" name="email" />
	</div>
	<div class="mui-input-row">
		<label>手机号</label>
		<input type="text" placeholder="手机号码" value="<?php echo isset($this->memberRow['mobile'])?$this->memberRow['mobile']:"";?>" name="mobile"<?php if($this->memberRow['mobile'] != ''){?> disabled="disabled"<?php }?> />
	</div>
	<div class="mui-input-row" id="region">
		<label>地区</label>
		<span id="province"><?php if($this->memberRow['provinceval']){?><?php echo isset($this->memberRow['provinceval'])?$this->memberRow['provinceval']:"";?><?php }else{?>湖南省<?php }?></span>
		<span id="city"><?php if($this->memberRow['cityval']){?><?php echo isset($this->memberRow['cityval'])?$this->memberRow['cityval']:"";?><?php }else{?>株洲市<?php }?></span>
		<span id="discrict"><?php if($this->memberRow['discrictval']){?><?php echo isset($this->memberRow['discrictval'])?$this->memberRow['discrictval']:"";?><?php }else{?>市辖区<?php }?></span>
		<input type="hidden" name="province" id="provinceval" value="<?php if($this->memberRow['areas'][0]){?><?php echo isset($this->memberRow['areas'][0])?$this->memberRow['areas'][0]:"";?><?php }else{?>430000<?php }?>" />
		<input type="hidden" name="city" id="cityval" value="<?php if($this->memberRow['areas'][1]){?><?php echo isset($this->memberRow['areas'][0])?$this->memberRow['areas'][0]:"";?><?php }else{?>430200<?php }?>" />
		<input type="hidden" name="area" id="discrictval" value="<?php if($this->memberRow['areas'][2]){?><?php echo isset($this->brandRow['areas'][2])?$this->brandRow['areas'][2]:"";?><?php }else{?>430201<?php }?>" />
		<i class="icon-angle-right"></i>
	</div>
	<div class="mui-input-row">
		<label>街道地址</label>
		<input type="text" name="contact_addr" value="<?php echo isset($this->memberRow['contact_addr'])?$this->memberRow['contact_addr']:"";?>" placeholder="请填写街道地址" />
	</div>
	<div class="mui-content-padded">
        <button type="submit" class="mui-btn mui-btn-primary mui-btn-block">提交</button>
    </div>
</form>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.poppicker.js";?>"></script>
<script type="text/javascript">
mui.ready(function(){
	var regionPicker = new mui.PopPicker({
		layer: 3
	});
	regionPicker.setData(<?php echo isset($regiondata)?$regiondata:"";?>);
	regionPicker.pickers[0].setSelectedValue(430000, 0);
	regionPicker.pickers[1].setSelectedValue(430200, 1);
	var PickerButton = document.getElementById('region');
	PickerButton.addEventListener('tap', function(event) {
		regionPicker.show(function(items) {
			$('#provinceval').val(items[0].value);
			$('#province').text(items[0].text);
			$('#cityval').val(items[1].value);
			$('#city').text(items[1].text);
			$('#discrictval').val(items[2].value);
			$('#discrict').text(items[2].text);
		});
	}, false);
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
