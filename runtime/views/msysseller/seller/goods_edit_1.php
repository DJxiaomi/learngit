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
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/cropper/cropper.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/cropper/cropper.min.css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.poppicker.css";?>" rel="stylesheet" type="text/css" />
<link href="/resource/scripts/layer/skin/layer.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/plugins/newupload/plupload.full.min.js"></script>
<script type="text/javascript" src="/resource/scripts/layer/layer.js"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/goods_edit2.js";?>"></script>
<script type="text/javascript" src="/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/plugins/ueditor/ueditor.all.min.js"></script>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/goods_edit3.css";?>" />
<?php $seller_id = $this->seller['seller_id']?>
<div class="mui-content">
<div class="mui-content-padded" style="margin:0;">
	<form class="mui-input-group" action="<?php echo IUrl::creatUrl("/seller/goods_update");?>" method="post" id="myForm" enctype='multipart/form-data'>
		<input type="hidden" name="id" value="<?php echo isset($form['id'])?$form['id']:"";?>" />
		<input type='hidden' name="callback" value="<?php echo IUrl::getRefRoute();?>" />
		<input name="goods_no" id="goods_no" type="hidden" value="<?php echo isset($form['goods_no'])?$form['goods_no']:"";?>"  />
		<input name="img" id="img" type="hidden" value="<?php echo isset($form['img'])?$form['img']:"";?>"  />
		<input type='hidden' name="_imgList" value="" />
		<div class="mui-input-row">
			<label>课程名称</label>
			<input type="text" name="name" value="<?php echo isset($form['name'])?$form['name']:"";?>" placeholder="课程名称" />
			<span class="mui-required-right">*</span>
		</div>
		<div class="mui-input-row">
			<label>关键词</label>
			<input type="text" name="search_words" value="<?php echo isset($form['search_words'])?$form['search_words']:"";?>" placeholder="关键词" />
		</div>
		<div class="mui-input-row" id="categorytxt">
			<label>所属分类</label>
			<span><?php if($catname){?><?php echo isset($catname)?$catname:"";?><?php }else{?>请选择<?php }?></span>
			<i class="icon-angle-right"></i>
			<div id="catlist">
			<?php if($goods_category){?>
			<?php foreach($goods_category as $key => $item){?>
			<input type="hidden" value="<?php echo isset($item)?$item:"";?>" name="_goods_category[]">
			<?php }?>
			<?php }?>
			</div>
			<span class="mui-required-right">*</span>
		</div>
		<p>产品相册<span class="mui-required-right">*</span></p>
		<div id="image-list" class="row image-list">
			<div class="image-item space" id="uploadButton"></div>
			<div id="loading">
				<div class="progress"></div>
				<div class="progress_text"></div>
			</div>
			<?php if($goods_photo){?>
			<?php foreach($goods_photo as $key => $item){?>
			<div class="image-item space">
				<img src="/<?php echo isset($item['img'])?$item['img']:"";?>"/>
				<div class="image-close">删除</div>
				<input type="hidden" name="uploadButton[]" value="<?php echo isset($item['img'])?$item['img']:"";?>" />
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
		<input type="hidden" name="model_id" value="1" />
		<div id="attrbox" style="hide"></div>
		<div id="sepc_list">
			<?php if($product){?>
			<?php foreach($product as $key => $item){?>
			<div class="mui-card">
				<div class="mui-card-content">
					<div class="mui-input-row">
						<label>标题</label>
						<input name="_cusval[]" type="text" value="<?php echo isset($item['cusval'])?$item['cusval']:"";?>" placeholder="例如：突破班" />
						<span class="mui-required-right">*</span>
					</div>
					<div class="mui-input-row">
						<label>课时数量</label>
						<input name="_classnum[]" type="number" value="<?php if($item['classnum'] > 0){?><?php echo isset($item['classnum'])?$item['classnum']:"";?><?php }else{?>0<?php }?>" placeholder="例如：100" />
					</div>
					<div class="mui-input-row">
						<label>上课时间/地点</label>
						<input name="_school_time[]" type="text" value="<?php echo isset($item['school_time'])?$item['school_time']:"";?>" />
					</div>
					<div class="mui-input-row">
						<label>学生年龄/年级</label>
						<input name="_Age_grade[]" type="text" value="<?php echo isset($item['Age_grade'])?$item['Age_grade']:"";?>" placeholder="" />
					</div>
					<div class="mui-input-row">
						<label>招生人数</label>
						<input name="_store_nums[]" type="text" value="<?php if($item['store_nums'] > 0){?><?php echo isset($item['store_nums'])?$item['store_nums']:"";?><?php }else{?>100<?php }?>" placeholder="" />
					</div>
					<div class="mui-input-row">
						<label>市场价格</label>
						<input class="market_price" name="_market_price[]" tt="3" type="text" value="<?php echo isset($item['market_price'])?$item['market_price']:"";?>" placeholder="例如：1500" />
						<span class="mui-required-right">*</span>
					</div>
					<div class="mui-input-row">
						<label>销售价格</label>
						<input class="discount" name="_sell_price[]" tt="1" type="text" value="<?php echo isset($item['sell_price'])?$item['sell_price']:"";?>" placeholder="例如：10" />
					</div>
				</div>
				</div>
				<div class="mui-card-footer">
					<a class="mui-card-link" onclick="delProduct(this, '<?php echo isset($item['id'])?$item['id']:"";?>');">删除</a>
				</div>
			</div>
			<?php }?>
			<?php }else{?>
			<div class="mui-card">
				<div class="mui-card-content" style="border: 1px solid #e25620;border-radius: 10px;">
					<div class="mui-input-row">
						<label>标题</label>
						<input name="_cusval[]" type="text" value="<?php echo isset($form['cusval'])?$form['cusval']:"";?>" placeholder="例如：突破班" />
						<span class="mui-required-right">*</span>
					</div>
					<div class="mui-input-row">
						<label>课时数量</label>
						<input name="_classnum[]" type="number" value="<?php if($form['classnum'] > 0 ){?><?php echo isset($form['classnum'])?$form['classnum']:"";?><?php }else{?>0<?php }?>" placeholder="例如：100" />
					</div>
					<div class="mui-input-row">
						<label>上课时间/地点</label>
						<input name="_school_time[]" type="text" value="<?php echo isset($form['school_time'])?$form['school_time']:"";?>" />
					</div>
					<div class="mui-input-row">
						<label>学生年龄/年级</label>
						<input name="_Age_grade[]" type="text" value="<?php echo isset($form['Age_grade'])?$form['Age_grade']:"";?>" placeholder="" />
					</div>
					<div class="mui-input-row">
						<label>招生人数</label>
						<input name="_store_nums[]" type="text" value="<?php if($form['Age_grade'] > 0 ){?><?php echo isset($form['Age_grade'])?$form['Age_grade']:"";?><?php }else{?>100<?php }?>" placeholder="" />
					</div>
					<div class="mui-input-row">
						<label>市场价格</label>
						<input class="market_price" name="_market_price[]" tt="3" type="text" value="<?php echo isset($form['market_price'])?$form['market_price']:"";?>" placeholder="例如：1500" />
						<span class="mui-required-right">*</span>
					</div>
					<div class="mui-input-row">
						<label>销售价格</label>
						<input class="discount" name="_sell_price[]" tt="1" type="text" value="<?php echo isset($form['sell_price'])?$form['sell_price']:"";?>" placeholder="例如：10" />
					</div>
				</div>
			</div>
			<?php }?>
		</div>

		<p>详细介绍<span class="mui-required-right">*</span></p>
		<textarea name="content" id="content" class="txt"><?php echo isset($form['content'])?$form['content']:"";?></textarea>


		<div class="mui-input-row">
			<label>是否上架</label>
			<div class="mui-radio mui-left mui-check-left">
				<label class="auto">上架</label>
				<input type="radio" name="is_del" value="3" checked>
			</div>
			<div class="mui-radio mui-left mui-check-left">
				<label class="auto">下架</label>
				<input type="radio" name="is_del" value="2">
			</div>
		</div>

		<div class="mui-input-row">
			<label>是否共享</label>
			<div class="mui-radio mui-left mui-check-left">
				<label class="auto">有</label>
				<input type="radio" class="auto" name="is_share" value="1" checked>
			</div>
			<div class="mui-radio mui-left mui-check-left">
				<label class="auto">无</label>
				<input type="radio" class="auto" name="is_share" value="0">
			</div>
		</div>


		<div class="mui-button-row" style="text-align:right;margin-right: 5%;">
			<button type="button" class="mui-btn mui-btn-danger add_spec_btn" onclick="addSpec()">添加属性</button>
		</div>
		<div class="mui-button-row">
			<button type="button" class="mui-btn mui-btn-primary" onclick="return checkForm()">确认提交</button>
		</div>
	</form>
</div>
</div>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.poppicker.js";?>"></script>
<script type="text/javascript">
mui.init();
mui.ready(function(){
	var userPicker = new mui.PopPicker({
		layer: 2
	});
	userPicker.setData(<?php echo isset($jsoncats)?$jsoncats:"";?>);
	<?php if($goods_category){?>
	userPicker.pickers[0].setSelectedValue(<?php echo isset($goods_category[0])?$goods_category[0]:"";?>, 0,function(){
		<?php if($goods_category[1]){?>
		userPicker.pickers[1].setSelectedValue(<?php echo isset($goods_category[1])?$goods_category[1]:"";?>, 0);
		<?php }?>
	});
	<?php }?>
	var showUserPickerButton = document.getElementById('categorytxt');
	showUserPickerButton.addEventListener('tap', function(event) {
		userPicker.show(function(items) {
			$('#catlist').html('');
			$('#catlist').append('<input type="hidden" value="' + items[0].value + '" name="_goods_category[]">');
			$('#catlist').append('<input type="hidden" value="' + items[1].value + '" name="_goods_category[]">');
			$('#categorytxt').find('span').text(items[0].text + ',' + items[1].text);
		});
	}, false);
});
</script>

<script language="javascript">
var defaultProductNo = '<?php echo goods_class::createGoodsNo();?>';
$(function()
{
	<?php if(!$form['model_id']){?>
	//create_attr(1);
	<?php }else{?>
	//create_attr(1);
	<?php }?>
	<?php if(!empty($form['goods_no'])){?>
		$('[name="goods_no"]').val('<?php echo isset($form['goods_no'])?$form['goods_no']:"";?>');
	<?php }else{?>
		$('[name="goods_no"]').val(defaultProductNo);
	<?php }?>


	$('textarea[name=content]').each(function(i){
			var vname = $(this).attr('id');
			createEditor(vname);
	})
});




function checkForm()
{
	var goodsPhoto = [];
	$('.imgListprocess').each(function(){
		goodsPhoto.push($(this).text());
	});
	if(goodsPhoto.length > 0)
	{
		$('input[name="_imgList"]').val(goodsPhoto.join(','));
		$('input[name="img"]').val(goodsPhoto[0]);
	}
	//goods_submit();
	$('#myForm').submit();
}

function goods_submit(){
	$.post($('#myForm').attr('action'),$('#myForm').serialize(),function(data){
		if(data.status == 1){
			mui.toast('提交成功');
			setTimeout(function() {
				mui.back();
			}, 1200);

		}else{
			mui.toast(data.info);
		}
	},'json')
}


function create_attr(model_id)

{

	$.getJSON("<?php echo IUrl::creatUrl("/block/attribute_init");?>",{'model_id':model_id}, function(json)

	{
		<?php if(isset($goods_attr)){?>
		<?php $attrArray = '';?>
		<?php foreach($goods_attr as $key => $item){?>
		<?php $attrArray .= $item . ','?>
		<?php }?>
		<?php }else{?>
		<?php $attrArray = '每周一,每周二,每周三,每周四,每周五,每周六,每周日';?>
		<?php }?>

		if(json && json.length > 0)

		{
			var html = '';
			for(var i in json)
			{
				html += '<div class="mui-input-row mui-input-row-auto clearfix">';
				var valueItems = json[i]['value'].split(',');
				html += '<p>' + json[i]['name'] + '</p>';
				for(var j in valueItems)
				{
					var checkattr = '<?php echo isset($attrArray)?$attrArray:"";?>';
					var checked = '';
					checkattr = checkattr.split(',');
					for(var k = 0; k< checkattr.length; k++){
						if(checkattr[k] == valueItems[j]){
							checked = " checked";
						}
					}

					html += '<div class="mui-checkbox mui-left mui-check-left"><label class="auto">' + valueItems[j] + '</label><input type="checkbox" name="attr_id_' + json[i]['id'] + '[]" value="' + valueItems[j] + '"' + checked + '></div>';
				}
				html += '</div>';
			}


			$('#attrbox').html(html);
		}

		else

		{
			$('#attrbox').hide();

		}

	});

}


function wordsPart(){

	var goodsName = $('input[name="name"]').val();

	if(goodsName)

	{

		$.getJSON("<?php echo IUrl::creatUrl("/goods/goods_tags_words");?>",{"content":goodsName},function(json)

		{

			if(json.result == 'success')

			{

				$('input[name="search_words"]').val(json.data);

			}

		});

	}

}

function addSpec(){
	var html = '<div class="mui-card">'+
				'<div class="mui-card-content">'+
					'<div class="mui-input-row">'+
						'<label>标题</label>'+
						'<input name="_cusval[]" type="text" value="" placeholder="例如：突破班" />'+
					'</div>'+
					'<div class="mui-input-row">'+
						'<label>课时数量</label>'+
						'<input name="_classnum[]" type="number" value="0" placeholder="例如：100" />'+
					'</div>'+
					'<div class="mui-input-row">'+
						'<label>上课时间/地点</label>'+
						'<input name="_school_time[]" type="text" value="" />'+
					'</div>'+
					'<div class="mui-input-row">'+
						'<label>学生年龄/年级</label>'+
						'<input name="_Age_grade[]" type="text" value="" placeholder="" />'+
					'</div>'+
					'<div class="mui-input-row">'+
						'<label>招生人数</label>'+
						'<input name="_store_nums[]" type="text" value="100" placeholder="" />'+
					'</div>'+
					'<div class="mui-input-row">'+
						'<label>市场价格</label>'+
						'<input class="market_price" name="_market_price[]" tt="3" type="text" value="" placeholder="例如：1500" />'+
					'</div>'+
					'<div class="mui-input-row">'+
						'<label>销售价格</label>'+
						'<input class="market_price" name="_sell_price[]" tt="3" type="text" value="" placeholder="例如：1500" />'+
					'</div>'+
				'</div>'+
				'<div class="mui-card-footer">'+
					'<a class="mui-card-link" onclick="delProduct(this);">删除</a>'+
				'</div>'+
			'</div>';
	$('#sepc_list').append(html);
}

function delProduct(_self, productid)

{
	productid = typeof productid != 'undefined' ? productid : false;
	if(productid){
		$.getJSON('<?php echo IUrl::creatUrl("/seller/delpro");?>/productid/' + productid, {}, function(json){
			if(json.msg == 1){
				$(_self).parent().parent().remove();
			}
		})
	}else{
		$(_self).parent().parent().remove();
	}

}
function createEditor(_str){
    UE.getEditor(_str,{
        elementPathEnabled : false,
        toolbars: [
            ['justifyleft', 'justifyright', 'justifycenter', 'justifyjustify','fontsize' ]
        ],
    });
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
