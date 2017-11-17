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
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/seller_edit.css";?>" />
<div class="mui-content-padded" style="margin:0;">
	<form action="<?php echo IUrl::creatUrl("/seller/seller_add6");?>" method="post" id="sellerForm" enctype='multipart/form-data' class="mui-input-group">
		<div class="mui-input-row">
			<label>商户真实全称：</label>
			<input name="true_name" type="text" value="<?php echo isset($this->sellerRow['true_name'])?$this->sellerRow['true_name']:"";?>" />
			<span class="mui-required-right">*</span>
		</div>
		<div class="mui-input-row">
			<label>营业执照号码</label>
			<input name="papersn" type="text" placeholder="营业执照号码" value="<?php echo isset($this->sellerRow['papersn'])?$this->sellerRow['papersn']:"";?>" />
			<span class="mui-required-right">*</span>
		</div>
		<p>营业执照上传<span class="mui-required-right">*</span></p>
		<div id="paper-image-list" class="row image-list">
			<?php if($this->sellerRow['paper_img']){?>
			<div class="image-item space" id="paper_img_prev" style="background:url(/<?php echo isset($this->sellerRow['paper_img'])?$this->sellerRow['paper_img']:"";?>) no-repeat center center;background-size:100% auto;"><div class="image-close" onclick="deloneimage(this, 'paper_img_val')">删除</div></div>
			<?php }?>
			<?php if($this->sellerRow['is_auth'] != 1){?>
			<div class="image-item space" id="paper_img"><input type="file" accept="image/*" id="image-1"></div>
			<input type="hidden" name="paper_img" id="paper_img_val" value="<?php echo isset($this->sellerRow['paper_img'])?$this->sellerRow['paper_img']:"";?>">
			<?php }?>
		</div>
		<div class="mui-input-row">
			<label>法人代表姓名</label>
			<input name="legal" type="text" value="<?php echo isset($this->sellerRow['legal'])?$this->sellerRow['legal']:"";?>" placeholder="法人代表" />
			<span class="mui-required-right">*</span>
		</div>
		<div class="mui-input-row">
			<label>法人身份证号</label>
			<input name="cardsn" type="text" value="<?php echo isset($this->sellerRow['cardsn'])?$this->sellerRow['cardsn']:"";?>" placeholder="法人身份证号" />
			<span class="mui-required-right">*</span>
		</div>
		<p>法人身份证正面上传<span class="mui-required-right">*</span></p>
		<div id="upphoto-image-list" class="row image-list">
			<?php if($this->sellerRow['upphoto']){?>
			<div class="image-item space" id="upphoto_img_prev" style="background:url(/<?php echo isset($this->sellerRow['upphoto'])?$this->sellerRow['upphoto']:"";?>) no-repeat center center;background-size:100% auto;"><div class="image-close" onclick="deloneimage(this, 'upphoto_val')">删除</div></div>
			<?php }?>
			<?php if($this->sellerRow['is_auth'] != 1){?>
			<div class="image-item space" id="upphoto"><input type="file" accept="image/*" id="image-1"></div>
			<input type="hidden" name="upphoto" id="upphoto_val" value="<?php echo isset($this->sellerRow['upphoto'])?$this->sellerRow['upphoto']:"";?>">
			<?php }?>
		</div>
		<p>法人身份证背面上传<span class="mui-required-right">*</span></p>
		<div id="downphoto-image-list" class="row image-list">
			<?php if($this->sellerRow['downphoto']){?>
			<div class="image-item space" id="downphoto_img_prev" style="background:url(/<?php echo isset($this->sellerRow['downphoto'])?$this->sellerRow['downphoto']:"";?>) no-repeat center center;background-size:100% auto;"><div class="image-close" onclick="deloneimage(this, 'downphoto_val')">删除</div></div>
			<?php }?>
			<?php if($this->sellerRow['is_auth'] != 1){?>
			<div class="image-item space" id="downphoto"><input type="file" accept="image/*" id="image-1"></div>
			<input type="hidden" name="downphoto" id="downphoto_val" value="<?php echo isset($this->sellerRow['downphoto'])?$this->sellerRow['downphoto']:"";?>">
			<?php }?>
		</div>
		<div class="mui-input-row">
			<label>安全手机号码</label>
			<input name="safe_mobile" id="mobile_val" type="text" value="<?php echo isset($this->sellerRow['safe_mobile'])?$this->sellerRow['safe_mobile']:"";?>" placeholder="安全手机号码" />
		</div>
		<div class="mui-input-row">
			<label>联系人</label>
			<input name="contacter" type="text" value="<?php echo isset($this->sellerRow['contacter'])?$this->sellerRow['contacter']:"";?>" placeholder="联系人" />
			<span class="mui-required-right">*</span>
		</div>
		<div class="mui-input-row">
			<label>联系人身份证号</label>
			<input name="contactcardsn" type="text" value="<?php echo isset($this->sellerRow['contactcardsn'])?$this->sellerRow['contactcardsn']:"";?>" placeholder="联系人身份证号" />
			<span class="mui-required-right">*</span>
		</div>
		<p>联系人身份证正面上传<span class="mui-required-right">*</span></p>
		<div id="cupphoto-image-list" class="row image-list">
			<?php if($this->sellerRow['cupphoto']){?>
			<div class="image-item space" id="cupphoto_img_prev" style="background:url(/<?php echo isset($this->sellerRow['cupphoto'])?$this->sellerRow['cupphoto']:"";?>) no-repeat center center;background-size:100% auto;"><div class="image-close" onclick="deloneimage(this, 'cupphoto_val')">删除</div></div>
			<?php }?>
			<?php if($this->sellerRow['is_auth'] != 1){?>
			<div class="image-item space" id="cupphoto"><input type="file" accept="image/*" id="image-1"></div>
			<input type="hidden" name="cupphoto" id="cupphoto_val" value="<?php echo isset($this->sellerRow['cupphoto'])?$this->sellerRow['cupphoto']:"";?>">
			<?php }?>
		</div>
		<p>联系人身份证背面上传<span class="mui-required-right">*</span></p>
		<div id="cdownphoto-image-list" class="row image-list">
			<?php if($this->sellerRow['cdownphoto']){?>
			<div class="image-item space" id="cdownphoto_img_prev" style="background:url(/<?php echo isset($this->sellerRow['cdownphoto'])?$this->sellerRow['cdownphoto']:"";?>) no-repeat center center;background-size:100% auto;"><div class="image-close" onclick="deloneimage(this, 'cdownphoto_val')">删除</div></div>
			<?php }?>
			<?php if($this->sellerRow['is_auth'] != 1){?>
			<div class="image-item space" id="cdownphoto"><input type="file" accept="image/*" id="image-1"></div>
			<input type="hidden" name="cdownphoto" id="cdownphoto_val" value="<?php echo isset($this->sellerRow['cdownphoto'])?$this->sellerRow['cdownphoto']:"";?>">
			<?php }?>
		</div>
		<div class="mui-button-row">
			<button type="button" id="infopost" class="mui-btn mui-btn-primary">提交认证</button>
		</div>
	</form>
</div>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.poppicker.js";?>"></script>
<script language="javascript">
mui.init();
$(function(){
	$.jUploader({
		button: 'paper_img',
		action: '<?php echo IUrl::creatUrl("/seller/pic_upload");?>',
		allowedExtensions: ['jpg', 'png', 'gif', 'jpeg', 'JPG', 'JPEG'],
		onUpload: function(fileName){
	    	Lx.common.loading();
	    },
		onComplete: function(fileName, response){
			if(response.success){
				$('#paper_img_val').val(response.fileurl);
	      		if($('#paper_img_prev').length == 1){
	      			$('#paper_img_prev').css('background-image', 'url(/' + response.fileurl + ')');
	      		}else{
	      			$('#paper-image-list').prepend('<div class="image-item space" id="paper_img_prev" style="background:url(/' + response.fileurl + ') no-repeat center center;background-size:100% auto;"></div>');
	      		}
			}else{
				mui.toast('上传失败');
			}
			Lx.common.loadingClose();
		}
	});

	$.jUploader({
		button: 'upphoto',
		action: '<?php echo IUrl::creatUrl("/seller/pic_upload");?>',
		allowedExtensions: ['jpg', 'png', 'gif', 'jpeg', 'JPG', 'JPEG'],
		onUpload: function(fileName){
	    	Lx.common.loading();
	    },
		onComplete: function(fileName, response){
			if(response.success){
				$('#upphoto_val').val(response.fileurl);
	      		if($('#upphoto_img_prev').length == 1){
	      			$('#upphoto_img_prev').css('background-image', 'url(/' + response.fileurl + ')');
	      		}else{
	      			$('#upphoto-image-list').prepend('<div class="image-item space" id="upphoto_img_prev" style="background:url(/' + response.fileurl + ') no-repeat center center;background-size:100% auto;"></div>');
	      		}
			}else{
				mui.toast('上传失败');
			}
			Lx.common.loadingClose();
		}
	});

	$.jUploader({
		button: 'downphoto',
		action: '<?php echo IUrl::creatUrl("/seller/pic_upload");?>',
		allowedExtensions: ['jpg', 'png', 'gif', 'jpeg', 'JPG', 'JPEG'],
		onUpload: function(fileName){
	    	Lx.common.loading();
	    },
		onComplete: function(fileName, response){
			if(response.success){
				$('#downphoto_val').val(response.fileurl);
	      		if($('#downphoto_img_prev').length == 1){
	      			$('#downphoto_img_prev').css('background-image', 'url(/' + response.fileurl + ')');
	      		}else{
	      			$('#downphoto-image-list').prepend('<div class="image-item space" id="downphoto_img_prev" style="background:url(/' + response.fileurl + ') no-repeat center center;background-size:100% auto;"></div>');
	      		}
			}else{
				mui.toast('上传失败');
			}
			Lx.common.loadingClose();
		}
	});

	$.jUploader({
		button: 'cupphoto',
		action: '<?php echo IUrl::creatUrl("/seller/pic_upload");?>',
		allowedExtensions: ['jpg', 'png', 'gif', 'jpeg', 'JPG', 'JPEG'],
		onUpload: function(fileName){
	    	Lx.common.loading();
	    },
		onComplete: function(fileName, response){
			if(response.success){
				$('#cupphoto_val').val(response.fileurl);
	      		if($('#cupphoto_img_prev').length == 1){
	      			$('#cupphoto_img_prev').css('background-image', 'url(/' + response.fileurl + ')');
	      		}else{
	      			$('#cupphoto-image-list').prepend('<div class="image-item space" id="cupphoto_img_prev" style="background:url(/' + response.fileurl + ') no-repeat center center;background-size:100% auto;"></div>');
	      		}
			}else{
				mui.toast('上传失败');
			}
			Lx.common.loadingClose();
		}
	});

	$.jUploader({
		button: 'cdownphoto',
		action: '<?php echo IUrl::creatUrl("/seller/pic_upload");?>',
		allowedExtensions: ['jpg', 'png', 'gif', 'jpeg', 'JPG', 'JPEG'],
		onUpload: function(fileName){
	    	Lx.common.loading();
	    },
		onComplete: function(fileName, response){
			if(response.success){
				$('#cdownphoto_val').val(response.fileurl);
	      		if($('#cdownphoto_img_prev').length == 1){
	      			$('#cdownphoto_img_prev').css('background-image', 'url(/' + response.fileurl + ')');
	      		}else{
	      			$('#cdownphoto-image-list').prepend('<div class="image-item space" id="cdownphoto_img_prev" style="background:url(/' + response.fileurl + ') no-repeat center center;background-size:100% auto;"></div>');
	      		}
			}else{
				mui.toast('上传失败');
			}
			Lx.common.loadingClose();
		}
	});
});

function deloneimage(obj, item){
	$(obj).parent().remove();
	$('#' + item).val('');
}
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
