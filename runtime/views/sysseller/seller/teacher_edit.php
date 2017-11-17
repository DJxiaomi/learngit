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

<body>
	<!--头部 开始-->
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="<?php echo IUrl::creatUrl("/seller/index");?>"><img src="<?php echo $this->getWebSkinPath()."images/main/logo.png";?>" /></a></h1>
			<h2 class="section_title"></h2>
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
			<p><strong>Copyright &copy; 2010-2015 iWebShop</strong></p>
			<p>Powered by <a href="http://www.aircheng.com">iWebShop</a></p>
		</footer>
	</aside>
	<!--侧边栏菜单 结束-->

	<!--主体内容 开始-->
	<section id="main" class="column">
		<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/editor/kindeditor-min.js"></script><script type="text/javascript">window.KindEditor.options.uploadJson = "/pic/upload_json";window.KindEditor.options.fileManagerJson = "/pic/file_manager_json";</script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<?php $seller_id = $this->seller['seller_id']?>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/cropper/cropper.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/cropper/cropper.min.css" />
<script type="text/javascript" src="/plugins/newupload/plupload.full.min.js"></script>
<link rel="stylesheet" href="/resource/scripts/layer/skin/layer.css">
<script type="text/javascript" src="/resource/scripts/layer/layer.js"></script>
<style>
.hide { display: none; }
input.normal, select.normal { height: 30px; }
.form_table { width: 60%; }
#allmap { width: 700px; height: 400px; }
.cropper-wrapper img{max-height:420px;}
</style>

<article class="module width_full">
	<header>
		<h3 class="tabs_involved">编辑教师</span></div>
	</header>


		<form action="<?php echo IUrl::creatUrl("/seller/teacher_save");?>" method="post" name="teacherForm" enctype='multipart/form-data'>

					<fieldset>
						<label>教师姓名：</label>
						<td><input class="normal" name="name" type="text" pattern="required" alt="请输入教师姓名" value="<?php echo isset($teacher_info['name'])?$teacher_info['name']:"";?>" /><label>* 教师名称（必填）</label></td>
					</fieldset>
          
          <fieldset>
              <label>性别：</label>
              <td><input type="radio" name="sex" value="1" id="sex_1" /><label for="sex_1">男</label>&nbsp; &nbsp; <input type="radio" name="sex" value="2" id="sex_2" /><label for="sex_2">女</label></td>
          </fieldset>
					<fieldset>
						<label>手机号码：</label>
						<td><input type="text" class="normal" name="mobile" pattern="mobi" empty alt="请输入正确的手机号码" value="<?php echo isset($teacher_info['mobile'])?$teacher_info['mobile']:"";?>" /></td>
					</fieldset>
           <fieldset>
            <label>出生年月：</td>
            <td><input type="text" class="normal" name="birth_date" pattern="date" empty alt="请选择出生年月" onFocus="WdatePicker()" value="<?php echo isset($teacher_info['birth_date'])?$teacher_info['birth_date']:"";?>" /></td>
          </fieldset>
          <fieldset>
            <label>形象照片：</label>
                <div class="demo" style="margin-top: 8px;">
                   <a class="btn" id="icon" style="padding: 4px 13px;">选择...</a>
                   <label class="tip"></label>
                    <ul id="img_pics" class="ul_pics clearfix">
                        <?php if(isset($teacher_info['icon'])){?>
                        <li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="<?php echo isset($teacher_info['icon'])?$teacher_info['icon']:"";?>" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="icon" value="<?php echo isset($teacher_info['icon'])?$teacher_info['icon']:"";?>" /></li>
                        <?php }?>
                    </ul>
                </div>  
          </fieldset>
          <fieldset>
            <label>教师介绍：</td>
            <td>
                <textarea name="description" id="description" style="width:600px;height:300px;"><?php echo isset($teacher_info['description'])?$teacher_info['description']:"";?></textarea>
            </td>
          </fieldset>
			<fieldset>
				<td></td>
				<td>
              <input type="hidden" name="id" value="<?php echo isset($teacher_info['id'])?$teacher_info['id']:"";?>" />
				<button class="submit" type="submit" ><span>确 定</span></button>
			</td>
		</fieldset>
	       </div>
		</form>
<div class="cropper">
    <div class="cropper-wrapper"><img src="" alt=""></div>
    <div class="preview preview-lg"></div>
</div>
<script>
$(function(){
    var ids = new Array("icon");
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
            cutPicture(data,self);        
    
        })

        uploadImg.bind('Error',function(up, err) {
            alert(err.message);
        })
    })
})


function cutPicture(_data,_self){
    var $image = $('.cropper-wrapper > img');
    $image.attr('src','/'+_data.img);

    $image.cropper('destroy').cropper({
      aspectRatio: 2/3,
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
        var imgSrc = '<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="'+dataurl+'" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="icon" value="'+dataurl+'" /></li>';
        
        $('#'+_self).siblings('ul').html(imgSrc);
        layer.close(index);
      }
    });
}
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