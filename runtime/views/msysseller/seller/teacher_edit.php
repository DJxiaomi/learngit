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
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.poppicker.css";?>" rel="stylesheet" type="text/css" />
<h5 class="mui-content-padded">编辑教师</h5>
<div class="mui-content-padded" style="margin:0;">
	<form class="mui-input-group" action="<?php echo IUrl::creatUrl("/seller/teacher_save");?>" method="post" enctype='multipart/form-data'>
		<div class="mui-input-row">
			<label>教师姓名</label>
			<?php if($this->brand_info['category_ids'] == 16){?>
				<?php echo isset($this->seller_info['shortname'])?$this->seller_info['shortname']:"";?>
			<?php }else{?>
				<input type="text" name="name" value="<?php echo isset($teacher_info['name'])?$teacher_info['name']:"";?>" placeholder="教师姓名" />
			<?php }?>
		</div>
		<div class="mui-input-row" id="sextxt">
			<label>性别</label>
			<span>
				<?php if(!$teacher_info || $teacher_info['sex'] != 2){?>男<?php }?>
				<?php if($teacher_info['sex'] == 2){?>女<?php }?>
			</span>
			<input type="hidden" name="sex" id="sex" value="<?php if($teacher_info['sex']){?><?php echo isset($teacher_info['sex'])?$teacher_info['sex']:"";?><?php }else{?>1<?php }?>" />
			<i class="icon-angle-right"></i>
		</div>
		<div class="mui-input-row">
			<label>手机号码</label>
			<input type="number" name="mobile" value="<?php echo isset($teacher_info['mobile'])?$teacher_info['mobile']:"";?>" placeholder="请输入手机号码" />
		</div>
		<p>形象照片</p>
		<div id="image-list" class="row image-list">
			<?php if($teacher_info['icon']){?>
			<div class="image-item space" id="prev" style="background:url(<?php echo IUrl::creatUrl("")."".$teacher_info['icon']."";?>) no-repeat center center;background-size:100% auto;"></div>
			<?php }?>
			<div class="image-item space" id="uppic"><input type="file" accept="image/*" id="image-1"></div>
			<input type="hidden" name="icon" id="icon" value="<?php echo isset($teacher_info['icon'])?$teacher_info['icon']:"";?>">
		</div>
		<p>个人简介</p>
		<textarea name="description" id="description" class="txt"><?php echo isset($teacher_info['description'])?$teacher_info['description']:"";?></textarea>
		<div class="mui-button-row">
			<input type="hidden" name="id" value="<?php echo isset($teacher_info['id'])?$teacher_info['id']:"";?>" />
			<button type="submit" class="mui-btn mui-btn-primary">确认</button>
		</div>
	</form>
</div>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.poppicker.js";?>"></script>
<script language="javascript">
mui.init();
mui.ready(function(){
	var data = "[{value: 1, text: '男'}, {value: 2, text: '女'}]";
	var userPicker = new mui.PopPicker();
	userPicker.setData(eval('(' + data + ')'));
	var showUserPickerButton = document.getElementById('sextxt');
	showUserPickerButton.addEventListener('tap', function(event) {
		userPicker.show(function(items) {
			$('#sex').val(items[0].value);
			$('#sextxt').find('span').text(items[0].text);
		});
	}, false);
});

$.jUploader({
    button: 'uppic',
    action: '<?php echo IUrl::creatUrl("/seller/pic_upload");?>',
    allowedExtensions: ['jpg', 'png', 'gif', 'jpeg', 'JPG', 'JPEG'],
    onComplete: function(fileName, response){
      	if(response.success){
      		$('#icon').val(response.fileurl);
      		if($('#prev').length == 1){
      			$('#prev').css('background-image', 'url(/' + response.fileurl + ')');
      		}else{
      			$('#image-list').prepend('<div class="image-item space" id="prev" style="background:url(/' + response.fileurl + ') no-repeat center center;background-size:100% auto;"></div>');
      		}
      	}else{
        	mui.toast('上传失败');
      	}
    }
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
