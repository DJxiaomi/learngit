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
<h5 class="mui-content-padded">课程编辑</h5>
<script type="text/javascript" src="/plugins/newupload/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/layer/layer.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/goods_edit2.js";?>"></script>
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
	.mui-toast-container { bottom: 50% !important;}

	#loading{width:80%;height:50px; position:relative;left:10%;top:50%;background:rgba(0,0,0,0.2);padding:10px;border-radius: 5px;display: none;}
	#loading .progress{background:#08c;border:1px solid #ccc;width:1%;height:10px;border-radius: 5px;}
	#loading .progress_text{text-align: center;text-indent:-70px;}
</style>
<?php $seller_id = $this->seller['seller_id']?>
<div class="mui-content">
<div class="mui-content-padded" style="margin:0;">
	<form class="mui-input-group" action="<?php echo IUrl::creatUrl("/seller/goods_update2");?>" method="post" id="myForm" enctype='multipart/form-data'>
		<input type="hidden" name="id" value="<?php echo isset($form['id'])?$form['id']:"";?>" />
		<input type='hidden' name="callback" value="<?php echo IUrl::getRefRoute();?>" />
		<input name="goods_no" id="goods_no" type="hidden" value="<?php echo isset($form['goods_no'])?$form['goods_no']:"";?>"  />
		<input name="img" id="img" type="hidden" value="<?php echo isset($form['img'])?$form['img']:"";?>"  />
		<input type='hidden' name="_imgList" value="" />
		<input type='hidden' name="is_mobile" value="1" />
		<div class="mui-input-row">
			<label>课程名称</label>
			<input type="text" name="name" value="<?php echo isset($form['name'])?$form['name']:"";?>" placeholder="课程名称" />
		</div>
		<div class="mui-input-row">
			<label>一句话简介</label>
			<input type="text" name="goods_brief" value="<?php echo isset($form['goods_brief'])?$form['goods_brief']:"";?>" placeholder="一句话简介" />
		</div>
		<div class="mui-input-row">
			<label>关键词</label>
			<input type="text" name="search_words" value="<?php echo isset($form['search_words'])?$form['search_words']:"";?>" placeholder="关键词" />
		</div>
		<div class="mui-input-row" id="categorytxt">
			<label>课程分类</label>
			<span><?php if($catname){?><?php echo isset($catname)?$catname:"";?><?php }else{?>请选择<?php }?></span>
			<i class="icon-angle-right"></i>
			<div id="catlist">
			<?php if($goods_category){?>
			<?php foreach($goods_category as $key => $item){?>
			<input type="hidden" value="<?php echo isset($item)?$item:"";?>" name="_goods_category[]">
			<?php }?>
			<?php }?>
			</div>
		</div>
		<p>课程相册</p>
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

        <div class="mui-input-row">
			<label>课程排序</label>
			<input type="text" name="sort" value="<?php echo isset($form['sort'])?$form['sort']:"";?>" placeholder="排序" />
		</div>
        <p>是否有试听课</p>
        <div class="mui-input-row">
        	<div class="mui-radio mui-left mui-check-left">
			<label class="auto">有</label>
			<input type="radio" name="is_preview" value="1" checked>
			</div>
			<div class="mui-radio mui-left mui-check-left">
			<label class="auto">无</label>
			<input type="radio" name="is_preview" value="0">
			</div>
		</div>
		<p>是否支持转让课程</p>
        <div class="mui-input-row">
        	<div class="mui-radio mui-left mui-check-left">
			<label class="auto">支持</label>
			<input type="radio" name="is_refer" value="1" checked>
			</div>
			<div class="mui-radio mui-left mui-check-left">
			<label class="auto">不支持</label>
			<input type="radio" name="is_refer" value="0">
			</div>
		</div>
		<p>是否上架</p>
        <div class="mui-input-row">
        	<div class="mui-radio mui-left mui-check-left">
			<label class="auto">上架</label>
			<input type="radio" name="is_del" value="3" checked>
			</div>
			<div class="mui-radio mui-left mui-check-left">
			<label class="auto">下架</label>
			<input type="radio" name="is_del" value="2">
			</div>
		</div>
		<p>课程简介</p>
		<textarea name="content" id="content" class="txt"><?php echo isset($form['content'])?$form['content']:"";?></textarea>
		<input type="hidden" name="model_id" value="1" />
		<div id="attrbox">

		</div>
		<p>基本信息</p>
		<div id="sepc_list">
			<div class="mui-card">
				<div class="mui-card-content">
					<div class="mui-input-row">
						<label>属性名称</label>
						<input type="text" name="specname" value="<?php echo isset($product[0]['cusname'])?$product[0]['cusname']:"";?>" placeholder="例如：班级" />
					</div>
				</div>
			</div>
			<?php if($product){?>
			<?php foreach($product as $key => $item){?>
			<div class="mui-card">
				<div class="mui-card-content">
					<div class="mui-input-row">
						<label>属性值</label>
						<input name="specval[]" type="text" value="<?php echo isset($item['cusval'])?$item['cusval']:"";?>" placeholder="例如：突破班" />
					</div>
					<div class="mui-input-row">
						<label>招生人数</label>
						<input name="student[]" type="text" value="<?php echo isset($item['student'])?$item['student']:"";?>" placeholder="例如：100" />
					</div>
					<div class="mui-input-row">
						<label>授课老师</label>
						<input name="teacher[]" type="text" value="" />
					</div>
					<div class="mui-input-row">
						<label>课时</label>
						<input name="classnum[]" type="text" value="<?php echo isset($item['classnum'])?$item['classnum']:"";?>" placeholder="例如：12课时" />
					</div>
					<div class="mui-input-row">
						<label>每学期月数</label>
						<input name="month[]" type="text" value="<?php echo isset($item['month'])?$item['month']:"";?>" placeholder="例如：1个月" />
					</div>
					<div class="mui-input-row">
						<label>市场价</label>
						<input class="market_price" name="market_price[]" tt="3" type="text" value="<?php echo isset($item['market_price'])?$item['market_price']:"";?>" placeholder="例如：1500" />
					</div>
					<div class="mui-input-row">
						<label>折扣</label>
						<input class="discount" name="discount[]" tt="1" type="text" value="<?php echo isset($item['discount'])?$item['discount']:"";?>" placeholder="例如：10" />
						<input class="cost_price" tt="2" name="cost_price[]" type="hidden" value="<?php echo isset($item['cost_price'])?$item['cost_price']:"";?>" /></td>
						<input class="sell_price" name="sell_price[]" type="hidden" value="<?php echo isset($item['sell_price'])?$item['sell_price']:"";?>" /></td>
					</div>
					<div class="mui-input-row">
						<div class="mui-checkbox mui-right mui-check-left">
							<label class="auto">是否显示</label>
							<input type="checkbox" name="is_show[]" value="1"<?php if($item['is_show'] == 1){?> checked<?php }?>>
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
				<div class="mui-card-content">
					<div class="mui-input-row">
						<label>属性值</label>
						<input name="specval[]" type="text" value="" placeholder="例如：突破班" />
					</div>
					<div class="mui-input-row">
						<label>招生人数</label>
						<input name="student[]" type="text" value="100" placeholder="例如：100" />
					</div>
					<div class="mui-input-row">
						<label>授课老师</label>
						<input name="teacher[]" type="text" value="" />
					</div>
					<div class="mui-input-row">
						<label>课时</label>
						<input name="classnum[]" type="text" value="" placeholder="例如：12课时" />
					</div>
					<div class="mui-input-row">
						<label>每学期月数</label>
						<input name="month[]" type="text" value="" placeholder="例如：1个月" />
					</div>
					<div class="mui-input-row">
						<label>市场价</label>
						<input class="market_price" name="market_price[]" tt="3" type="text" value="" placeholder="例如：1500" />
					</div>
					<div class="mui-input-row">
						<label>折扣</label>
						<input class="discount" name="discount[]" tt="1" type="text" value="" placeholder="例如：10" />
						<input class="cost_price" tt="2" name="cost_price[]" type="hidden" value="" /></td>
						<input class="sell_price" name="sell_price[]" type="hidden" value="" /></td>
					</div>
					<div class="mui-input-row">
						<div class="mui-checkbox mui-right mui-check-left">
							<label class="auto">是否显示</label>
							<input type="checkbox" name="is_show[]" value="1">
						</div>
					</div>
				</div>
				<div class="mui-card-footer">
					<a class="mui-card-link" onclick="delProduct(this);">删除</a>
				</div>
			</div>
			<?php }?>
		</div>
		<div class="mui-button-row">
			<button type="button" class="mui-btn mui-btn-primary" onclick="return checkForm()">确认提交</button>
			<button type="button" class="mui-btn mui-btn-danger" onclick="addSpec()">增加一行</button>
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
	create_attr(1);
	<?php }else{?>
	create_attr(1);
	<?php }?>
	<?php if(!empty($form['goods_no'])){?>
		$('[name="goods_no"]').val('<?php echo isset($form['goods_no'])?$form['goods_no']:"";?>');
	<?php }else{?>
		$('[name="goods_no"]').val(defaultProductNo);
	<?php }?>

	$('.discount').on('keyup',function(){
		calculation_price($(this));
	});
});

function calculation_price(obj)
{
	var rcommission = '<?php echo $site_config->rcommission;?>';
	var pcommission = '<?php echo $site_config->pcommission;?>';
	var _val = obj.val();
	_val = parseFloat( _val );
	var _market_price = obj.parent().parent().find(".market_price").val();
	_market_price = parseFloat( _market_price );
	var _tt = obj.attr('tt');

	if ( _val > 0 && _market_price > 0 )
	{
		switch( _tt )
		{
			case '1':
				var sell_discount =  (_val / 100) * (rcommission / 100);
				var _cost_price = _market_price - (_market_price * ( _val / 100 ));
				var _sell_price = _market_price - (_market_price * sell_discount);
				var _new_sell_price = ( _market_price - _sell_price ) * pcommission / 100 + _sell_price;

				obj.parent().parent().find(".cost_price").val(_cost_price.toFixed(2));
				obj.parent().parent().find(".sell_price").val(_new_sell_price.toFixed(2));
				break;
			case '2':
				var _discount = ( _val / _market_price ) * 100;
				var _sell_price = ( _market_price - _val ) / 2 + _val;
				var _new_sell_price = ( _market_price - _sell_price ) * pcommission / 100 + _sell_price;

				obj.parent().parent().find(".discount").val(_discount.toFixed(2));
				obj.parent().parent().find(".sell_price").val(_new_sell_price.toFixed(2));
				break;
		}
	}
}





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
	goods_submit();
	return true;
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
						'<label>属性值</label>'+
						'<input name="specval[]" type="text" value="" placeholder="例如：突破班" />'+
					'</div>'+
					'<div class="mui-input-row">'+
						'<label>招生人数</label>'+
						'<input name="student[]" type="text" value="100" placeholder="例如：100" />'+
					'</div>'+
					'<div class="mui-input-row">'+
						'<label>授课老师</label>'+
						'<input name="teacher[]" type="text" value="" />'+
					'</div>'+
					'<div class="mui-input-row">'+
						'<label>课时</label>'+
						'<input name="classnum[]" type="text" value="" placeholder="例如：12课时" />'+
					'</div>'+
					'<div class="mui-input-row">'+
						'<label>每学期月数</label>'+
						'<input name="month[]" type="text" value="" placeholder="例如：1个月" />'+
					'</div>'+
					'<div class="mui-input-row">'+
						'<label>市场价</label>'+
						'<input class="market_price" name="market_price[]" tt="3" type="text" value="" placeholder="例如：1500" />'+
					'</div>'+
					'<div class="mui-input-row">'+
						'<label>折扣</label>'+
						'<input class="discount" name="discount[]" tt="1" type="text" value="" placeholder="例如：10" />'+
						'<input class="cost_price" tt="2" name="cost_price[]" type="hidden" value="" /></td>'+
						'<input class="sell_price" name="sell_price[]" type="hidden" value="" /></td>'+
					'</div>'+
					'<div class="mui-input-row">'+
						'<div class="mui-checkbox mui-right mui-check-left">'+
							'<label class="auto">是否显示</label>'+
							'<input type="checkbox" name="is_show[]" value="1">'+
						'</div>'+
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
