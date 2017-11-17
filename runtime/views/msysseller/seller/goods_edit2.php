<!doctype html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>管理中心</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<link href="<?php echo IUrl::creatUrl("")."resource/css/font-awesome.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/form.css";?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/jquery-3.1.1.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/jquery.juploader.js";?>"></script>
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/common.js";?>"></script>
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
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/cropper/cropper.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/cropper/cropper.min.css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.poppicker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo IUrl::creatUrl("")."resource/scripts/layer/skin/layer.css";?>" rel="stylesheet" type="text/css" />
<p class="part_tit">商家信息</p>
<script type="text/javascript" src="/plugins/newupload/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/layer/layer.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/goods_edit2.js";?>"></script>
<?php $seller_id = $this->seller['seller_id']?>
<div class="mui-content-padded" style="margin:0;">
	<form class="mui-input-group" action="<?php echo IUrl::creatUrl("/seller/brand_add2");?>" name="sellerForm" method="post" enctype='multipart/form-data' id="brandFrom">
		<p>logo（PC端）</p>
		<div id="pcLogoPics" class="row image-list">			
			<div class="image-item space" id="pcLogo"></div>
			<?php if($brand['pc_logo']){?>			
			<div class="image-item space">
				<img src="/<?php echo isset($brand['pc_logo'])?$brand['pc_logo']:"";?>"/>
				<div class="image-close">删除</div>
				<input type="hidden" name="pcLogo[]" value="<?php echo isset($brand['pc_logo'])?$brand['pc_logo']:"";?>" />
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
		<p>学校介绍</p>
		<div id="schoolIntroPics" class="row image-list">			
			<div class="image-item space" id="schoolIntro"></div>
			<?php if($brand['school_intro_img']){?>
	        <?php foreach($brand['school_intro_img'] as $key => $item){?>		
			<div class="image-item space">
				<img src="/<?php echo isset($item)?$item:"";?>"/>
				<div class="image-close">删除</div>
				<input type="hidden" name="schoolIntro[]" value="<?php echo isset($item)?$item:"";?>" />
			</div>
			<?php }?>
	        <?php }?>
		</div>
		<p>学校展示</p>
		<div id="schoolShowPics" class="row image-list">			
			<div class="image-item space" id="schoolShow"></div>
			<?php if($brand['school_img']){?>
	        <?php foreach($brand['school_img'] as $key => $item){?>		
			<div class="image-item space">
				<img src="/<?php echo isset($item)?$item:"";?>"/>
				<div class="image-close">删除</div>
				<input type="hidden" name="schoolShow[]" value="<?php echo isset($item)?$item:"";?>" />
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

		<p>学校简介</p>
		<textarea name="content" id="content" class="txt" style="width:100%;height:100px;" placeholder="请填写学校简介"><?php echo isset($seller_info['content'])?$seller_info['content']:"";?></textarea>			

		<div class="mui-button-row submit_btn">
			<input type="hidden" name="brand_id" value="<?php echo isset($brand['id'])?$brand['id']:"";?>" />
			<button type="button" class="mui-btn mui-btn-primary alt_btn1">提交信息</button>
		</div>
	</form>
	<p class="part_tit">课程信息</p>
	<ul class="mui-table-view">
		<?php foreach($goods_list as $key => $item){?>
	    <li class="mui-table-view-cell mui-media">
	        <a class="mui-navigate-right" href="<?php echo IUrl::creatUrl("seller/goods_edit3/id/".$item['id']."");?>">
	            <img class="mui-media-object mui-pull-left" src="/<?php echo isset($item['img'])?$item['img']:"";?>">
	            <div class="mui-media-body">
	                <p class='mui-ellipsis'><?php echo isset($item['name'])?$item['name']:"";?></p>
	            </div>
	        </a>
	    </li>
	    <?php }?>
	</ul>
	<ul class="mui-table-view addNew">
	    <li class="mui-table-view-cell">
	        <a class="mui-navigate-right" href="<?php echo IUrl::creatUrl("seller/goods_edit3");?>">添加新课程</a>
	    </li>
	</ul>

	<p class="part_tit">教师信息</p>
	<ul class="mui-table-view">
		<?php foreach($teacher_list as $key => $item){?>
	    <li class="mui-table-view-cell mui-media">
	        <a class="mui-navigate-right" href="<?php echo IUrl::creatUrl("seller/teacher_edit2/id/".$item['id']."");?>">
	            <img class="mui-media-object mui-pull-left" src="/<?php echo isset($item['icon'])?$item['icon']:"";?>">
	            <div class="mui-media-body">
	                <p class='mui-ellipsis'><?php echo isset($item['name'])?$item['name']:"";?></p>
	            </div>
	        </a>
	    </li>
	    <?php }?>
	</ul>
	<ul class="mui-table-view addNew">
	    <li class="mui-table-view-cell">
	        <a class="mui-navigate-right" href="<?php echo IUrl::creatUrl("seller/teacher_edit2");?>">添加新教师</a>
	    </li>
	</ul>

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

<!-- <script>
	<?php if($seller_info['is_system_seller']){?>
var ue = UE.getEditor('content',{
	elementPathEnabled:false,
    wordCount:false
});
<?php }else{?>
var ue = UE.getEditor('content',{
	toolbars: [
        ['justifyleft', 'justifyright', 'justifycenter', 'justifyjustify' ]
    ],
    elementPathEnabled:false,
    wordCount:false
});
<?php }?>
</script>
 -->
	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/brand_edit2");?>" id="ztelBtn">
	        <i class="mui-icon-my icon-book"></i>
	        <span class="mui-tab-label">学校信息</span>
	    </a>
	    <a class="mui-tab-item" href="<?php echo IUrl::creatUrl("/seller/goods_edit2");?>" id="ztelBtn">
	        <i class="mui-icon-my icon-globe"></i>
	        <span class="mui-tab-label">首页信息</span>
	    </a>
	    <a class="mui-tab-item mui-hot" href="<?php echo IUrl::creatUrl("/seller/chit");?>">
	        <i class="mui-icon-my icon-github-alt"></i>
	        <span class="mui-tab-label">代金券</span>
	    </a>
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
