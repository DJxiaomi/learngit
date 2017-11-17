<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>后台管理</title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/admin.css";?>" />
	<meta name="robots" content="noindex,nofollow">
	<link rel="shortcut icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/common.js";?>"></script>
	<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/admin.js";?>"></script>

	<script src="/resource/scripts/bootstrap/bootstrap.min.js"></script>
	<script src="/resource/scripts/bootstrap/bootstrp-selelct/js/bootstrap-select.js"></script>
	<link rel="stylesheet" href="/resource/scripts/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="/resource/scripts/bootstrap/bootstrp-selelct/css/bootstrap-select.css">
	<style>
	.container {width:100%;}
	.btn {height:20px;}
	.bootstrap-select > .dropdown-toggle {width:80%;}
	button span {background: none;}
	* {box-sizing:inherit;}
	#menu {background:none;}
	.bootstrap-select.btn-group .dropdown-toggle .caret {display:none;}
	</style>
</head>
<body>
	<div class="container">
		<div id="header">
			<div class="logo">
				<a href="<?php echo IUrl::creatUrl("/system/default");?>"><img src="<?php echo $this->getWebSkinPath()."images/admin/logo.png";?>" width="303" height="43" /></a>
			</div>
			<div id="menu">
				<ul name="topMenu">
					<?php $menuData=menu::init($this->admin['role_id']);?>
					<?php foreach(menu::getTopMenu($menuData) as $key => $item){?>
					<li>
						<a hidefocus="true" href="<?php echo IUrl::creatUrl("".$item."");?>"><?php echo isset($key)?$key:"";?></a>
					</li>
					<?php }?>
				</ul>
			</div>
			<p><a href="<?php echo IUrl::creatUrl("/systemadmin/logout");?>">退出管理</a> <a href="<?php echo IUrl::creatUrl("/system/admin_repwd");?>">修改密码</a> <a href="<?php echo IUrl::creatUrl("/system/default");?>">后台首页</a> <a href="<?php echo IUrl::creatUrl("");?>" target='_blank'>商城首页</a> <span>您好 <label class='bold'><?php echo isset($this->admin['admin_name'])?$this->admin['admin_name']:"";?></label>，当前身份 <label class='bold'><?php echo isset($this->admin['admin_role_name'])?$this->admin['admin_role_name']:"";?></label></span></p>
		</div>
		<div id="info_bar">
			<label class="navindex"><a href="<?php echo IUrl::creatUrl("/system/navigation");?>">快速导航管理</a></label>
			<span class="nav_sec">
			<?php $query = new IQuery("quick_naviga");$query->where = "admin_id = {$this->admin['admin_id']} and is_del = 0";$items = $query->find(); foreach($items as $key => $item){?>
			<a href="<?php echo isset($item['url'])?$item['url']:"";?>" class="selected"><?php echo isset($item['naviga_name'])?$item['naviga_name']:"";?></a>
			<?php }?>
			</span>
		</div>

		<div id="admin_left">
			<ul class="submenu">
				<?php $leftMenu=menu::get($menuData,IWeb::$app->getController()->getId().'/'.IWeb::$app->getController()->getAction()->getId())?>
				<?php foreach(current($leftMenu) as $key => $item){?>
				<li>
					<span><?php echo isset($key)?$key:"";?></span>
					<ul name="leftMenu">
						<?php foreach($item as $leftKey => $leftValue){?>
						<li><a <?php if(stripos($leftKey,"javascript:")===0){?>href="javascript:void(0)" onclick="<?php echo isset($leftKey)?$leftKey:"";?>" <?php }else{?> href="<?php echo IUrl::creatUrl("".$leftKey."");?>"<?php }?>><?php echo isset($leftValue)?$leftValue:"";?></a></li>
						<?php }?>
					</ul>
				</li>
				<?php }?>
			</ul>
			<div id="copyright"></div>
		</div>

		<div id="admin_right">
			<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/cropper/cropper.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/cropper/cropper.min.css" />
<script type="text/javascript" src="/plugins/newupload/plupload.full.min.js"></script>
<link rel="stylesheet" href="/resource/scripts/layer/skin/layer.css">
<script type="text/javascript" src="/resource/scripts/layer/layer.js"></script>
<style>
	.cropper-wrapper img{max-height:420px;}
	.form_table .pic {width:156px;height: 180px;overflow:hidden;margin: 10px;}
	.form_table .pic img {max-width: 150px;max-height:150px;margin:0px;}
</style>
<div class="headbar">
	<div class="position"><span>学校</span><span>></span><span>学校管理</span><span>></span><span><?php if(isset($brand['id'])){?>编辑<?php }else{?>添加<?php }?>学校页面内容</span></div>
</div>
<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/brand/brand_save");?>" method="post" enctype='multipart/form-data'>
			<table class="form_table" cellpadding="0" cellspacing="0">
				<col width="150px" />
				<col />
				<tr>
					<th>登录名：</th>
					<td><input class="normal" name="username" type="text" value="<?php echo isset($brand['username'])?$brand['username']:"";?>" pattern="required" alt="登录名不能为空" />
						<label>*</label>
						<input name="brand_id" value="<?php echo isset($brand['id'])?$brand['id']:"";?>" type="hidden" />
					</td>
				</tr>
				<tr>
					<th>学校简称：</th>
					<td><input class="normal" name="shortname" type="text" value="<?php echo isset($brand['shortname'])?$brand['shortname']:"";?>" pattern="required" alt="学校简称不能为空" /></td>
				</tr>
				<tr>
					<th>学校全称：</th>
					<td><input class="normal" name="name" type="text" value="<?php echo isset($brand['name'])?$brand['name']:"";?>" pattern="required" alt="学校全称不能为空" />
						<label>*</label>
					</td>
				</tr>
				<tr>
					<th>排序：</th><td><input class="normal" name="sort" type="text" value="<?php echo isset($brand['sort'])?$brand['sort']:"";?>" pattern='int' empty alt='必需为整形数值'/></td>
				</tr>
				<tr>
					<th>二级域名设置：</th><td><input class="normal" name="url" type="text" value="<?php echo isset($brand['url'])?$brand['url']:"";?>" pattern='required' empty alt='4个英文字母' /><label>英文字母+dsanke.com即为二级域名</label></td>
				</tr>
				<tr>
					<th>手机端LOGO：</th>
					<td colspan="3">
						<div class="demo" style="margin-top: 8px;">
			               <label class="tip"></label>
			                <ul id="logo_pics" class="ul_pics clearfix">
			                	<?php if(isset($brand['logo'])){?>
								<li class="pic"><img style="opacity:1;width:150px;" src="<?php echo IUrl::creatUrl("")."".$brand['logo']."";?>" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="logo[]" value="<?php echo isset($brand['logo'])?$brand['logo']:"";?>" /></li>
			                	<?php }?>
			                </ul>
			               <a class="btn" id="logo" style="padding: 4px 13px;">选择...</a>
			            </div>
					</td>
				</tr>
				<tr>
					<th>PC端LOGO：</th>
					<td colspan="3">
						<div class="demo" style="margin-top: 8px;">
			             <label class="tip"></label>
			                <ul id="pc_logo_pics" class="ul_pics clearfix">
			                	<?php if(isset($brand['pc_logo'])){?>
								<li class="pic"><img style="opacity:1;width:150px;" src="/<?php echo isset($brand['pc_logo'])?$brand['pc_logo']:"";?>" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="pc_logo[]" value="<?php echo isset($brand['pc_logo'])?$brand['pc_logo']:"";?>" /></li>
			                	<?php }?>
			                </ul>
							<a class="btn" id="pc_logo" style="padding: 4px 13px;">选择...</a>
			            </div>
					</td>
				</tr>
				<tr>
					<th>所属地区：</th>
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
				</tr>


				<tr>
					<th>学校轮播图：</th>
					<td colspan="3">
						<div class="demo" style="margin-top: 8px;">

			               <label class="tip"></label>
			                <ul id="img_pics" class="ul_pics clearfix">
			                	<?php if(isset($brand['img'])){?>
			                	<?php foreach($brand['img'] as $key => $item){?>
								<li class="pic"><img style="opacity:1;width:150px;" src="<?php echo IUrl::creatUrl("")."".$item."";?>" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="img[]" value="<?php echo isset($item)?$item:"";?>" /></li>
			                	<?php }?>
			                	<?php }?>
			                </ul>
						  <a class="btn" id="img" style="padding: 4px 13px;">选择...</a>
			            </div>
					</td>
				</tr>
				<tr>

			<th>学校介绍：</th>

			<td colspan="3">
					<div class="demo" style="margin-top: 8px;">

		               <label class="tip"></label>
		                <ul id="class_desc_img_pics" class="ul_pics clearfix">
		                	<?php if(isset($brand['class_desc_img'])){?>
		                	<?php foreach($brand['class_desc_img'] as $key => $item){?>
		                	<li class="pic"><img style="opacity:1;width:150px;" src="<?php echo IUrl::creatUrl("")."".$item."";?>" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="class_desc_img[]" value="<?php echo isset($item)?$item:"";?>" /></li>
		                	<?php }?>
		                	<?php }?>
		                </ul>
						    <a class="btn" id="class_desc_img" style="padding: 4px 13px;">选择...</a>
		            </div>
				</td>

		</tr>

		<tr>

	<th>授权书：</th>

	<td colspan="3">
			<div class="demo" style="margin-top: 8px;">

							 <label class="tip"></label>
								<ul id="certificate_of_authorization_pics" class="ul_pics clearfix">
									<?php if(isset($brand['certificate_of_authorization'])){?>
									<?php foreach($brand['certificate_of_authorization'] as $key => $item){?>
									<li class="pic"><img style="opacity:1;width:150px;" src="<?php echo IUrl::creatUrl("")."".$item."";?>" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="certificate_of_authorization[]" value="<?php echo isset($item)?$item:"";?>" /></li>
									<?php }?>
									<?php }?>
								</ul>
						<a class="btn" id="certificate_of_authorization" style="padding: 4px 13px;">选择...</a>
						</div>
		</td>

</tr>



		<tr>
		  <th>首页广告语：</th>
			<td><input class="normal" name="brief" type="text" value="<?php echo isset($brand['brief'])?$brand['brief']:"";?>" pattern="required" alt="广告语不能为空" />
			   <label>*</label>
			</td>
		</tr>
		<tr>
			<th valign="top">详细介绍：</th><td><textarea name="description" id="description" style="width:600px;height:300px;"><?php echo isset($brand['description'])?$brand['description']:"";?></textarea></td>
		</tr>
		<tr>
			<th>学校展示：</th>
				<td colspan="3">
					<div class="demo" style="margin-top: 8px;">

			               <label class="tip"></label>
			                  <ul id="shop_desc_img_pics" class="ul_pics clearfix">
			                	<?php if(isset($brand['shop_desc_img'])){?>
			                	<?php foreach($brand['shop_desc_img'] as $key => $item){?>
			                	<li class="pic"><img style="opacity:1;width:150px;" src="<?php echo IUrl::creatUrl("")."".$item."";?>" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="shop_desc_img[]" value="<?php echo isset($item)?$item:"";?>" /></li>
			                	<?php }?>
			                	<?php }?>
			                </ul>
					    <a class="btn" id="shop_desc_img" style="padding: 4px 13px;">选择...</a>
			        </div>
				</td>
		</tr>
		<tr>
			<td></td><td><button class="submit" type="submit"><span>确 定</span></button></td>
		</tr>
			</table>
		</form>
	</div>
</div>

<div class="cropper">
	<div class="cropper-wrapper"><img src="" alt=""></div>
	<div class="preview preview-lg"></div>
</div>


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
        var imgSrc = '<li class="pic"><img style="opacity:1;width:150px;" src="'+dataurl+'" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="'+_self+'[]" value="'+dataurl+'" /></li>';

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
      var imgSrc = '<li class="pic"><img style="opacity:1;width:150px;" src="'+dataurl+'" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="'+_self+'[]" value="'+dataurl+'" /></li>';

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
        var imgSrc = '<li class="pic"><img style="opacity:1;width:150px;" src="'+dataurl+'" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="'+_self+'[]" value="'+dataurl+'" /></li>';

        $('#'+_self).siblings('ul').html(imgSrc);
        layer.close(index);
	  }
	});
}

$(function(){
	var ids = new Array("img","class_desc_img","shop_desc_img","logo","pc_logo","certificate_of_authorization");
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
		   var str = '<li class="pic"><img style="opacity:1;width:150px;" src="/'+data.img+'" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="'+self+'[]" value="'+data.img+'" /></li>';
		   switch(self)
			{
			case 'logo':
			    cutPicture1(data,self);
			    break;
			case 'pc_logo':
			    cutPicture2(data,self);
			    break;
			case 'class_desc_img':
			case 'shop_desc_img':
			case 'certificate_of_authorization':
				$('#'+self).siblings('ul').append(str);
				break;
			// case 'shop_desc_img':
			// 	$('#'+self).siblings('ul').append(str);
			// 	break;
			default:
				cutPicture(data,self);
			    break;
			}

		})

		uploadImg.bind('Error',function(up, err) {
            alert(err.message);
        })
	})



	///////////////////////////////////////////////////////////





});

<?php if($brand['id']){?>
//锁定字段一旦注册无法修改
var lockCols = ['username'];
for(var index in lockCols)
{
	$('input:text[name="'+lockCols[index]+'"]').addClass('readonly');
	$('input:text[name="'+lockCols[index]+'"]').attr('readonly',true);
}
<?php }?>


</script>

		</div>
	</div>

	<script type='text/javascript'>
	//隔行换色
	$(".list_table tr:nth-child(even)").addClass('even');
	$(".list_table tr").hover(
		function () {
			$(this).addClass("sel");
		},
		function () {
			$(this).removeClass("sel");
		}
	);

	//按钮高亮
	var topItem  = "<?php echo key($leftMenu);?>";
	$("ul[name='topMenu']>li:contains('"+topItem+"')").addClass("selected");

	var leftItem = "<?php echo IUrl::getUri();?>";
	$("ul[name='leftMenu']>li a[href^='"+leftItem+"']").parent().addClass("selected");
	</script>
</body>
</html>
