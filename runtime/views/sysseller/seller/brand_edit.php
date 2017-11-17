<?php $seller_id = $this->seller['seller_id'];$seller_name = $this->seller['seller_name'];?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>商家管理后台</title>
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/html5.js";?>"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/common.js";?>"></script>
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/ie.css";?>" type="text/css" media="screen" />
	<![endif]-->
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/admin.css";?>" type="text/css" media="screen" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
</head>
<style>
 header#header h2.section_title{
  width:40%;
 }
</style>
<body>
	<!--头部 开始-->
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="<?php echo IUrl::creatUrl("/seller/index");?>"><img src="<?php echo $this->getWebSkinPath()."images/main/logo.png";?>" /></a></h1>
			<h2 class="section_title"></h2>
			<div class="btn_view_site"><a href="http://www.lelele999.net" target="_blank">管理公众号</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("");?>" target="_blank">网站首页</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("/site/home/id/".$seller_id."");?>" target="_blank">商家主页</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("/systemseller/logout");?>">退出登录</a></div>
		</hgroup>
	</header>
	<!--头部 结束-->

	<!--面包屑导航 开始-->
	<section id="secondary_bar">
		<div class="user">
			<p><?php echo isset($seller_name)?$seller_name:"";?></p>
		</div>
	</section>
	<!--面包屑导航 结束-->

	<!--侧边栏菜单 开始-->
	<aside id="sidebar" class="column">
		<?php foreach(menuSeller::init() as $key => $item){?>
		<h3><?php echo isset($key)?$key:"";?></h3>
		<ul class="toggle">
			<?php foreach($item as $moreKey => $moreValue){?>
			<li><a href="<?php echo IUrl::creatUrl("".$moreKey."");?>"><?php echo isset($moreValue)?$moreValue:"";?></a></li>
			<?php }?>
		</ul>
		<?php }?>

		<footer>
			<hr />
			<p><strong>Copyright &copy; 2010-2017</strong></p>
			<p>Powered by <a href="http://www.dsanke.com">dsanke.com</a></p>
		</footer>
	</aside>
	<!--侧边栏菜单 结束-->

	<!--主体内容 开始-->
	<section id="main" class="column">
		<?php $brand = seller_class::get_brand_info_by_seller_id($this->seller['seller_id'])?>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/cropper/cropper.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/cropper/cropper.min.css" />
<script type="text/javascript" src="/plugins/newupload/plupload.full.min.js"></script>
<link rel="stylesheet" href="/resource/scripts/layer/skin/layer.css">
<script type="text/javascript" src="/resource/scripts/layer/layer.js"></script>
<style>
	.cropper-wrapper img{max-height:420px;}
</style>
<article class="module width_full">
	<div class="module_content">

		<form action="<?php echo IUrl::creatUrl("/seller/brand_save");?>" method="post" name="sellerForm" enctype='multipart/form-data'>
				<fieldset>
					<label>学校名称：</label>
					<td><input class="normal" name="name" type="text" value="<?php echo isset($brand['name'])?$brand['name']:"";?>" pattern="required" alt="学校名称不能为空" />
						<label>*</label>
						<input name="brand_id" value="<?php echo isset($brand['id'])?$brand['id']:"";?>" type="hidden" />
					</td>
				</fieldset>

				<fieldset>
					<label>二级域名设置：</label><td><input class="normal" name="url" type="text" value="<?php echo isset($brand['url'])?$brand['url']:"";?>" /><label>二级域名</label></td>
				</fieldset>
				<fieldset>
					<label>手机端LOGO：</label>
					<td colspan="3">
						<div class="demo" style="margin-top: 8px;">
			               <a class="btn" id="logo" style="padding: 4px 13px;">选择...</a>
			               <label class="tip"></label>
			                <ul id="logo_pics" class="ul_pics clearfix">
			                	<?php if(isset($brand['logo'])){?>
								<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="<?php echo IUrl::creatUrl("")."".$brand['logo']."";?>" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="logo[]" value="<?php echo isset($brand['logo'])?$brand['logo']:"";?>" /></li>
			                	<?php }?>
			                </ul>
			            </div>
					</td>
				</fieldset>
				<fieldset>
					<label>PC端LOGO：</label>
					<td colspan="3">
						<div class="demo" style="margin-top: 8px;">
			               <a class="btn" id="pc_logo" style="padding: 4px 13px;">选择...</a>
			               <label class="tip"></label>
			                <ul id="pc_logo_pics" class="ul_pics clearfix">
			                	<?php if(isset($brand['pc_logo'])){?>
								<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="<?php echo IUrl::creatUrl("")."".$brand['pc_logo']."";?>" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="pc_logo[]" value="<?php echo isset($brand['pc_logo'])?$brand['pc_logo']:"";?>" /></li>
			                	<?php }?>
			                </ul>
			            </div>
					</td>
				</fieldset>
				<fieldset>
					<label>学校分类：</label>
					<td>
						<?php $query = new IQuery("brand_category");$items = $query->find(); foreach($items as $key => $item){?><?php }?>
						<?php if($items){?>
						<ul class="select">
							<?php foreach($items as $key => $item){?>
							<li><label><input type="checkbox" value="<?php echo isset($item['id'])?$item['id']:"";?>" name="category[]" <?php if(isset($brand) && stripos(','.$brand['category_ids'].',',','.$item['id'].',') !== false){?>checked="checked"<?php }?> /><?php echo isset($item['name'])?$item['name']:"";?></label></li>
							<?php }?>
						</ul>
						<?php }else{?>
						系统暂无地区分类，<a href='<?php echo IUrl::creatUrl("/brand/category_edit");?>' class='orange'>请点击添加</a>
						<?php }?>
					</td>
				</fieldset>


				<fieldset>
					<label>学校轮播图：</label>
					<td colspan="3">
						<div class="demo" style="margin-top: 8px;">
			               <a class="btn" id="img" style="padding: 4px 13px;">选择...</a>
			               <label class="tip"></label>
			                <ul id="img_pics" class="ul_pics clearfix">
			                	<?php if(isset($brand['img'])){?>
			                	<?php foreach($brand['img'] as $key => $item){?>
								<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="<?php echo IUrl::creatUrl("")."".$item."";?>" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="img[]" value="<?php echo isset($item)?$item:"";?>" /></li>
			                	<?php }?>
			                	<?php }?>
			                </ul>
			            </div>
					</td>
				</fieldset>
				<fieldset>

			<label>学校介绍：</label>

			<td colspan="3">
					<div class="demo" style="margin-top: 8px;">
		               <a class="btn" id="class_desc_img" style="padding: 4px 13px;">选择...</a>
		               <label class="tip"></label>
		                <ul id="class_desc_img_pics" class="ul_pics clearfix">
		                	<?php if(isset($brand['class_desc_img'])){?>
		                	<?php foreach($brand['class_desc_img'] as $key => $item){?>
		                	<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="<?php echo IUrl::creatUrl("")."".$item."";?>" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="class_desc_img[]" value="<?php echo isset($item)?$item:"";?>" /></li>
		                	<?php }?>
		                	<?php }?>
		                </ul>
		            </div>
				</td>

		</fieldset>
		<fieldset>
			<label style="display: block;">详细介绍：</label>
			<textarea name="description" id="description" style="width:600px;height:300px;"><?php echo isset($brand['description'])?$brand['description']:"";?></textarea>
		</fieldset>
		<fieldset>
			<label>学校展示：</label>
				<td colspan="3">
					<div class="demo" style="margin-top: 8px;">
			            <a class="btn" id="shop_desc_img" style="padding: 4px 13px;">选择...</a>
			               <label class="tip"></label>
			                  <ul id="shop_desc_img_pics" class="ul_pics clearfix">
			                	<?php if(isset($brand['shop_desc_img'])){?>
			                	<?php foreach($brand['shop_desc_img'] as $key => $item){?>
			                	<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="<?php echo IUrl::creatUrl("")."".$item."";?>" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="shop_desc_img[]" value="<?php echo isset($item)?$item:"";?>" /></li>
			                	<?php }?>
			                	<?php }?>
			                </ul>
			        </div>
				</td>
		</fieldset>
		<fieldset>
			<td></td><td><button class="submit" type="submit"><span>确 定</span></button></td>
		</fieldset>

		</form>

	</div>
</article>
<!-- 裁剪框 start -->
<div class="cropper">
	<div class="cropper-wrapper"><img src="" alt=""></div>
	<div class="preview preview-lg"></div>
</div>
<!-- end -->
<script language="javascript">
//DOM加载完毕
$(function()
{
//修改模式
<?php if($this->sellerRow){?>
var formObj = new Form('sellerForm');
formObj.init(<?php echo JSON::encode($this->sellerRow);?>);
<?php }?>
</script>

<script type="text/javascript">
function cutPicture(_data,_self){
	var $image = $('.cropper-wrapper > img');
    $image.attr('src','/'+_data.img);

    $image.cropper('destroy').cropper({
	  aspectRatio: 16/11,
	  resizable:false,
	  preview: ".preview",
	});

    var index = layer.open({
	  type: 1,
	  btn:['确定','取消'],
	  skin: 'layui-layer-rim', //加上边框
	  area: ['920px', '520px'], //宽高
	  content: $('.cropper'),
	  yes:function(){

	  	var $imgData=$image.cropper('getCroppedCanvas')
        var dataurl = $imgData.toDataURL('image/jpeg');
        var imgSrc = '<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="'+dataurl+'" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="'+_self+'[]" value="'+dataurl+'" /></li>';

        $('#'+_self).siblings('ul').append(imgSrc);
        layer.close(index);
	  }
	});
}

function cutPicture1(_data,_self){
	var $image = $('.cropper-wrapper > img');
    $image.attr('src','/'+_data.img);

    $image.cropper('destroy').cropper({
	  aspectRatio: 1,
	  resizable:false,
	  preview: ".preview",
	});

    var index = layer.open({
	  type: 1,
	  btn:['确定','取消'],
	  skin: 'layui-layer-rim', //加上边框
	  area: ['920px', '520px'], //宽高
	  content: $('.cropper'),
	  yes:function(){

  	  var $imgData=$image.cropper('getCroppedCanvas')
      var dataurl = $imgData.toDataURL('image/jpeg');
      var imgSrc = '<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="'+dataurl+'" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="'+_self+'[]" value="'+dataurl+'" /></li>';

        $('#'+_self).siblings('ul').html(imgSrc);
        layer.close(index);
	  }
	});
}

function cutPicture2(_data,_self){
	var $image = $('.cropper-wrapper > img');
    $image.attr('src','/'+_data.img);

    $image.cropper('destroy').cropper({
	  aspectRatio: 300/179,
	  resizable:false,
	  preview: ".preview",
	});

    var index = layer.open({
	  type: 1,
	  btn:['确定','取消'],
	  skin: 'layui-layer-rim', //加上边框
	  area: ['920px', '520px'], //宽高
	  content: $('.cropper'),
	  yes:function(){

	  	var $imgData=$image.cropper('getCroppedCanvas')
        var dataurl = $imgData.toDataURL('image/jpeg');
        var imgSrc = '<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="'+dataurl+'" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="'+_self+'[]" value="'+dataurl+'" /></li>';

        $('#'+_self).siblings('ul').html(imgSrc);
        layer.close(index);
	  }
	});
}

$(function(){
	var ids = new Array("img","class_desc_img","shop_desc_img","logo","pc_logo");
	$.each(ids,function(i,n){
		var self = this.toString();
		var uploadImg = new plupload.Uploader({
		    runtimes: 'html5,flash,silverlight,html4',
		    browse_button: self,
		    url: "/goods/goods_img_upload",
		    filters: {
		        max_file_size: '2048kb',
		        mime_types: [
		            {title: "files", extensions: "jpg,png,gif"}
		        ]
		    },
		    multi_selection: false,

		});

		uploadImg.init();

		uploadImg.bind('FilesAdded',function(uploader,files){
				uploadImg.start();
	    });

		uploadImg.bind('FileUploaded',function(up, file, info) {
		   var data = eval("(" + info.response + ")");
		   var str = '<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="/'+data.img+'" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="'+self+'[]" value="'+data.img+'" /></li>';
		   switch(self)
			{
			case 'logo':
			    cutPicture1(data,self);
			    break;
			case 'pc_logo':
			    cutPicture2(data,self);
			    break;
			case 'class_desc_img':
				$('#'+self).siblings('ul').append(str);
				break;
			case 'shop_desc_img':
				$('#'+self).siblings('ul').append(str);
				break;
			default:
				cutPicture(data,self);
			    break;
			}

		})

		uploadImg.bind('Error',function(up, err) {
            alert(err.message);
        })
	})





});





</script>

	</section>
	<!--主题内容 结束-->

	<script type="text/javascript">
	//菜单图片ICO配置
	function menuIco(val)
	{
		var icoConfig = {
			"管理首页" : "icn_tags",
			"销售额统计" : "icn_settings",
			"货款明细列表" : "icn_categories",
			"货款结算申请" : "icn_photo",
			"商品列表" : "icn_categories",
			"添加商品" : "icn_new_article",
			"平台共享商品" : "icn_photo",
			"商品咨询" : "icn_audio",
			"商品评价" : "icn_audio",
			"商品退款" : "icn_audio",
			"规格列表" : "icn_categories",
			"订单列表" : "icn_categories",
			"团购" : "icn_view_users",
			"促销活动列表" : "icn_categories",
			"物流配送" : "icn_folder",
			"发货地址" : "icn_jump_back",
			"资料修改" : "icn_profile",
		};
		return icoConfig[val] ? icoConfig[val] : "icn_categories";
	}

	$(".toggle>li").each(function()
	{
		$(this).addClass(menuIco($(this).text()));
	});
	</script>
</body>
</html>