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
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.poppicker.css";?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/plugins/newupload/plupload.full.min.js"></script>
<style>
	.mui-toast-container { bottom: 50% !important;}
</style>
<h5 class="mui-content-padded">资料修改</h5>
<div class="mui-content-padded" style="margin:0;">
	<form class="mui-input-group" action="<?php echo IUrl::creatUrl("/seller/brand_base_add");?>" method="post" enctype='multipart/form-data' id="brandFrom">
		<div class="mui-input-row">
			<label>用户名</label>
			<?php echo isset($this->brandRow['username'])?$this->brandRow['username']:"";?>
		</div>
		<div class="mui-input-row">
			<label>注册名称</label>
			<?php echo isset($this->brandRow['name'])?$this->brandRow['name']:"";?>
		</div>
		<div class="mui-input-row">
			<label>学校简称</label>
			<input type="text" name="shortname" value="<?php echo isset($this->brandRow['shortname'])?$this->brandRow['shortname']:"";?>" placeholder="请填写学校简称" />
		</div>

		<div class="mui-input-row" id="categorytxt">
			<label>所属分类</label>
			<span><?php if($brand_info['catname']){?><?php echo isset($brand_info['catname'])?$brand_info['catname']:"";?><?php }else{?>请选择<?php }?></span>
			<input type="hidden" name="category[]" id="category" />
			<i class="icon-angle-right"></i>
		</div>

		
		<div class="mui-input-row">
			<label>固定电话</label>
			<input type="text" name="telephone" value="<?php echo isset($this->brandRow['telephone'])?$this->brandRow['telephone']:"";?>" placeholder="请填写固定电话" />
		</div>
		<div class="mui-input-row" id="region">
			<label>学校地址</label>
			<span id="province"><?php if($brand_info['provinceval']){?><?php echo isset($brand_info['provinceval'])?$brand_info['provinceval']:"";?><?php }else{?>湖南省<?php }?></span>
			<span id="city"><?php if($brand_info['cityval']){?><?php echo isset($brand_info['cityval'])?$brand_info['cityval']:"";?><?php }else{?>株洲市<?php }?></span>
			<span id="discrict"><?php if($brand_info['discrictval']){?><?php echo isset($brand_info['discrictval'])?$brand_info['discrictval']:"";?><?php }else{?>市辖区<?php }?></span>
			<input type="hidden" name="province" id="provinceval" value="<?php if($this->brandRow['province']){?><?php echo isset($this->brandRow['province'])?$this->brandRow['province']:"";?><?php }else{?>430000<?php }?>" />
			<input type="hidden" name="city" id="cityval" value="<?php if($this->brandRow['city']){?><?php echo isset($this->brandRow['city'])?$this->brandRow['city']:"";?><?php }else{?>430200<?php }?>" />
			<input type="hidden" name="area" id="discrictval" value="<?php if($this->brandRow['discrict']){?><?php echo isset($this->brandRow['discrict'])?$this->brandRow['discrict']:"";?><?php }else{?>430201<?php }?>" />
			<i class="icon-angle-right"></i>
		</div>
		<div class="mui-input-row">
			<label>详细地址</label>
			<input type="text" name="address" value="<?php echo isset($this->brandRow['address'])?$this->brandRow['address']:"";?>" placeholder="请填写详细地址" />
		</div>
		<div class="mui-input-row">
			<label>邮箱</label>
			<input type="text" name="email" value="<?php echo isset($this->brandRow['email'])?$this->brandRow['email']:"";?>" placeholder="请填写邮箱" />
		</div>
		<div class="mui-input-row">
			<label>QQ</label>
			<input type="text" name="qq" value="<?php echo isset($this->brandRow['qq'])?$this->brandRow['qq']:"";?>" placeholder="请填写QQ" />
		</div>
		<div class="mui-input-row">
			<label>登录密码</label>
			<input type="password" name="password" placeholder="需要修改时填写密码" />
		</div>
		<div class="mui-input-row">
			<label>自定义网址</label>
			<input type="text" name="url" value="<?php echo isset($this->brandRow['url'])?$this->brandRow['url']:"";?>" placeholder="自定义网址" />
		</div>

		
		<div class="mui-button-row">
			<input type="hidden" name="brand_id" value="<?php echo isset($this->brandRow['id'])?$this->brandRow['id']:"";?>">
			<input type="hidden" name="is_mobile" value="1" />
			<button type="button" class="mui-btn mui-btn-primary" onclick="setAdImg()">确认</button>
		</div>
	</form>
</div>
<!-- 弹出菜单 -->

<script type='text/html' id='picTemplate2'>
 <div class='pic'>
		 <div class='pic_image'><img width="150" src="<?php echo IUrl::creatUrl("")."<%=picRoot%>";?>" alt="<%=picRoot%>" /></div>
		 <div class='pic_dels'><a href='javascript:void(0)'>删除</a></div>
 </div>
 </script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.poppicker.js";?>"></script>
<script type="text/javascript">
mui.init();
mui.ready(function(){
	var catdata = "[{vaue: '', text: '请选择'}";
	<?php $query = new IQuery("brand_category");$items = $query->find(); foreach($items as $key => $item){?><?php }?>
	<?php if($items){?>
	<?php foreach($items as $key => $item){?>
	catdata += ",{value: '<?php echo isset($item['id'])?$item['id']:"";?>', text: '<?php echo isset($item['name'])?$item['name']:"";?>'}";
	<?php }?>
	<?php }else{?>
	catdata += "{value: '', text: '无系统分类'}";
	<?php }?>
	catdata += ']';

	var userPicker = new mui.PopPicker();
	userPicker.setData(eval('(' + catdata + ')'));
	userPicker.pickers[0].setSelectedValue(<?php echo isset($this->brandRow['category_ids'])?$this->brandRow['category_ids']:"";?>, 0);
	var showUserPickerButton = document.getElementById('categorytxt');
	showUserPickerButton.addEventListener('tap', function(event) {
		userPicker.show(function(items) {
			$('#category').val(items[0].value);
			$('#categorytxt').find('span').text(items[0].text);
		});
	}, false);

	var regionPicker = new mui.PopPicker({
		layer: 3
	});

	var province = <?php echo isset($this->brandRow['province'])?$this->brandRow['province']:"";?>?<?php echo isset($this->brandRow['province'])?$this->brandRow['province']:"";?>:430000;
	var city = <?php echo isset($this->brandRow['city'])?$this->brandRow['city']:"";?>?<?php echo isset($this->brandRow['city'])?$this->brandRow['city']:"";?>:430200;
	var discrict = <?php echo isset($this->brandRow['discrict'])?$this->brandRow['discrict']:"";?>?<?php echo isset($this->brandRow['discrict'])?$this->brandRow['discrict']:"";?>:430201;

	regionPicker.setData(<?php echo isset($regiondata)?$regiondata:"";?>);
	regionPicker.pickers[0].setSelectedValue(province, 0,function(){
		regionPicker.pickers[1].setSelectedValue(city, 0,function(){
			regionPicker.pickers[2].setSelectedValue(discrict, 0);
		});	
	});	

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
<script language="javascript">

function del(obj){
	$(obj).parent().parent().remove();
}

function setAdImg(){
	$.getJSON($('#brandFrom').attr('action'),$('#brandFrom').serialize(),function(data){
		if(data.status == 1){
			mui.toast(data.info);
			setTimeout(function() {
				mui.back();
			}, 1200);
		}else{
			mui.toast(data.info);
		}
	})
}
</script>

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
