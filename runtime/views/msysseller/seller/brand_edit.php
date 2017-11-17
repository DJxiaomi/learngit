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
	<?php $brand = seller_class::get_brand_info_by_seller_id($this->seller['seller_id'])?>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/cropper/cropper.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/cropper/cropper.min.css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.poppicker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo IUrl::creatUrl("")."resource/scripts/layer/skin/layer.css";?>" rel="stylesheet" type="text/css" />
<style>
.part_tit {color:#ff4b2b;}
.mui-btn-primary {width:90%;border-radius:5px;background:linear-gradient(to right,#ff9638,#ff4b2b);border:0px;}
</style>
<script type="text/javascript" src="/plugins/newupload/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/layer/layer.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/goods_edit2.js";?>"></script>

<?php $seller_id = $this->seller['seller_id']?>
<div class="mui-content-padded" style="margin:0;">
	<form class="mui-input-group" action="<?php echo IUrl::creatUrl("/seller/brand_save");?>" name="sellerForm" method="post" enctype='multipart/form-data' id="brandFrom">
		<div class="mui-input-row">
			<label>学校名称</label>
				<input type="text" name="name" value="<?php echo isset($brand['name'])?$brand['name']:"";?>" placeholder="学校名称不能为空" readonly="readonly"/>
		</div>
		<div class="mui-input-row" style="display:none;">
			<label>二级域名</label>
				<input type="text" name="url" value="<?php echo isset($brand['url'])?$brand['url']:"";?>" placeholder="二级域名" />
		</div>
		<p>logo（PC端）</p>
		<div id="pc_logoPics" class="row image-list">
			<div class="image-item space" id="pc_logo"></div>
			<?php if($brand['pc_logo']){?>
			<div class="image-item space">
				<img src="/<?php echo isset($brand['pc_logo'])?$brand['pc_logo']:"";?>"/>
				<div class="image-close">删除</div>
				<input type="hidden" name="pc_logo[]" value="<?php echo isset($brand['pc_logo'])?$brand['pc_logo']:"";?>" />
			</div>
			<?php }?>
		</div>
		<p>logo（手机端）</p>
		<div id="logoPics" class="row image-list">
			<div class="image-item space" id="logo"></div>
			<?php if($brand['logo']){?>
			<div class="image-item space">
				<img src="/<?php echo isset($brand['logo'])?$brand['logo']:"";?>"/>
				<div class="image-close">删除</div>
				<input type="hidden" name="logo[]" value="<?php echo isset($brand['logo'])?$brand['logo']:"";?>" />
			</div>
			<?php }?>
		</div>
		<div class="mui-input-row" id="sextxt" style="display:none;">
			<label>学校分类：</label>
			<span>
				<?php $query = new IQuery("brand_category");$items = $query->find(); foreach($items as $key => $item){?><?php }?>
				<?php foreach($items as $key => $item){?>
					<?php if(isset($brand) && stripos(','.$brand['category_ids'].',',','.$item['id'].',') !== false){?><?php echo isset($item['name'])?$item['name']:"";?><?php }?>
				<?php }?>
			</span>
			<input type="hidden" name="category[]" id="category" value="<?php if($teacher_info['sex']){?><?php echo isset($teacher_info['sex'])?$teacher_info['sex']:"";?><?php }else{?>1<?php }?>" />
			<i class="icon-angle-right"></i>
		</div>
		<p style="display:none;">学校介绍</p>
		<div id="schoolIntroPics" class="row image-list" style="display:none;">
			<div class="image-item space" id="schoolIntro"></div>
			<?php if($brand['class_desc_img']){?>
	        <?php foreach($brand['class_desc_img'] as $key => $item){?>
			<div class="image-item space">
				<img src="/<?php echo isset($item)?$item:"";?>"/>
				<div class="image-close">删除</div>
				<input type="hidden" name="class_desc_img[]" value="<?php echo isset($item)?$item:"";?>" />
			</div>
			<?php }?>
	        <?php }?>
		</div>
		<p>学校展示</p>
		<div id="schoolShowPics" class="row image-list">
			<div class="image-item space" id="schoolShow"></div>
			<?php if($brand['shop_desc_img']){?>
	        <?php foreach($brand['shop_desc_img'] as $key => $item){?>
			<div class="image-item space">
				<img src="/<?php echo isset($item)?$item:"";?>"/>
				<div class="image-close">删除</div>
				<input type="hidden" name="shop_desc_img[]" value="<?php echo isset($item)?$item:"";?>" />
			</div>
			<?php }?>
	        <?php }?>
		</div>

		<!-- 裁剪框 start -->
		<div class="cropper">
			<div class="cropper-wrapper"><img src="" alt=""></div>
			<!-- <div class="preview preview-lg"></div> -->
		</div>
		<div class="cropper_flag"></div>
		<!-- end -->

		<p>详细介绍</p>
		<textarea name="description" id="description" class="txt" style="width:90%;height:100px;" placeholder="请填写学校简介"><?php echo isset($brand['description'])?$brand['description']:"";?></textarea>

		<div class="mui-button-row submit_btn">
			<input type="hidden" name="brand_id" value="<?php echo isset($brand['id'])?$brand['id']:"";?>" />
			<button type="submit" class="mui-btn mui-btn-primary">提交信息</button>
		</div>
	</form>


	<div id="loading">
		<div class="progress"></div>
		<div class="progress_text"></div>
	</div>

<style>
	.image-list{height:auto;}
	.part_tit{text-align: center;font-size:125%;color:#08c;margin-top: 10px;}
	.addNew{text-align: center;color:#08c;}

	.cropper{width:100%;height:300px;display:none;}
	.cropper-wrapper {width:100%;height:300px; box-shadow: inset 0 0 5px rgba(0,0,0,.25); background-color: #fcfcfc; overflow: hidden;}
	.cutPic{display:none;}
	.cropper_flag{width:98%;border:1px solid #fff;margin:0 auto;}
	.image-item img{width:100%;height:100%;}
	.mui-table-view .mui-media-object{width:50px;height:50px;}

	#loading{width:80%;height:50px; position:fixed;left:10%;top:50%;background:rgba(0,0,0,0.2);padding:10px;border-radius: 5px;display: none;}
	#loading .progress{background:#08c;border:1px solid #ccc;width:1%;height:10px;border-radius: 5px;}
	#loading .progress_text{text-align: center;text-indent:-70px;}
	.mui-toast-container {bottom: 45% !important;}
</style>
</div>

<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.poppicker.js";?>"></script>

<script language="javascript">
var data = "[{vaue: '', text: '请选择'}";
<?php $query = new IQuery("brand_category");$items = $query->find(); foreach($items as $key => $item){?><?php }?>
<?php foreach($items as $key => $item){?>
data += ",{value: '<?php echo isset($item['id'])?$item['id']:"";?>', text: '<?php echo isset($item['name'])?$item['name']:"";?>'}";
<?php }?>
data += ']';

var userPicker = new mui.PopPicker();
userPicker.setData(eval('(' + data + ')'));
var showUserPickerButton = document.getElementById('sextxt');
showUserPickerButton.addEventListener('tap', function(event) {
	userPicker.show(function(items) {
		$('#category').val(items[0].value);
		$('#sextxt').find('span').text(items[0].text);
	});
}, false);
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
