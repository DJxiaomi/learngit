<?php $menuData=menu::init($this->admin['role_id']);?>
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
</head>
<body>
	<div class="container">
	<span class="zhong"><?php echo isset($this->admin['admin_role_name'])?$this->admin['admin_role_name']:"";?>:<?php echo isset($this->admin['admin_name'])?$this->admin['admin_name']:"";?></span>
		<div id="header">
          <div id="menu">
			<ul name="topMenu">
				<li class="first"> <a href="/index.php?controller=system&amp;action=default">首页</a></li> 

				
				
				
				<li><a hidefocus="true" href="/order/order_list">订单管理</a></li>			
				<li><a hidefocus="true" href="/market/brand_chit_list">新代金券</a></li>
                <li><a hidefocus="true" href="/order/order_collection_list">成交明细</a></li>
                <li><a hidefocus="true" href="/order/refundment_list">退款申请</a></li>				
						<li><a href="/member/withdraw_list">用户提现</a></li>
				<li><a hidefocus="true" href="/market/bill_list">结算申请</a></li>

				<li><a hidefocus="true" href="/goods/goods_list">课程管理</li>
				<li><a hidefocus="true" href="/member/member_list">用户管理</a></li>
				<li><a href="/brand/brand_list">学校资料</a></li>
				<li><a href="/member/seller_list">学校认证</a></li>
				<li><a href="/member/seller_edit">添加认证</a></li>
				<li><a href="/member/teacher_list">教师列表</a></li>
					
				<li><a href="/tools/notice_list">公告管理</a></li>
				<li><a hidefocus="true" href="/tools/article_list">文章管理</a></li>
				<li><a hidefocus="true" href="/tools/ad_list">广告管理</a></li>
				<li><a href="/comment/discussion_list">讨论管理</a></li>
				<li><a href="/comment/refer_list">咨询管理</a></li>
				<li class="last"><a href="/index.php?controller=systemadmin&amp;action=logout">退出</a></li> 
			</ul>
			</div>
			
		</div>

		<div id="admin_left">
			<ul class="submenu">
				<?php $leftMenu=menu::get($menuData,IWeb::$app->getController()->getId().'/'.IWeb::$app->getController()->getAction()->getId())?>
				<?php foreach(current($leftMenu) as $key => $item){?>
				<li>
					<span><?php echo isset($key)?$key:"";?></span>
					<ul name="leftMenu">
						<?php foreach($item as $leftKey => $leftValue){?>
						<li><a href="<?php echo IUrl::creatUrl("".$leftKey."");?>"><?php echo isset($leftValue)?$leftValue:"";?></a></li>
						<?php }?>
					</ul>
				</li>
				<?php }?>
			</ul>
			<div id="copyright"></div>
		</div>

		<div id="admin_right">
			<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/editor/kindeditor-min.js"></script><script type="text/javascript">window.KindEditor.options.uploadJson = "/pic/upload_json";window.KindEditor.options.fileManagerJson = "/pic/file_manager_json";</script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/areaSelect/areaSelect.js"></script>
<script type="text/javascript" src="/plugins/newupload/plupload.full.min.js"></script>

<script language="javascript">
	<?php if(isset($brand['album_json'])){?>
	var _album_arr = <?php echo isset($brand['album_json'])?$brand['album_json']:"";?>;
	<?php }else{?>
	var _album_arr = new Array();
	<?php }?>
	<?php if(isset($brand['ad_json'])){?>
	var _ad_arr = <?php echo isset($brand['ad_json'])?$brand['ad_json']:"";?>;
	<?php }else{?>
	var _ad_arr = new Array();
	<?php }?>
</script>
<style>
.pic,.adpic { margin-bottom: 15px;}
.pic img { width: 100px; height: 56.25px;}
.adpic img{ width: 200px; height: 50px; }
#thumbnails2,#thumbnails3 { margin-top: 10px; }
#uploadButton2,#uploadButton3 { width: 228px; padding: 3px 10px;font-size: 12px; text-align: center; border: 1px solid #959595; background-color: #e9e9e9; margin-left: 10px; }
#uploadButton2:hover,#uploadButton3:hover { text-decoration: none;}
.demo {margin-top:8px;}
</style>

<div class="headbar">
	<div class="position"><span>学校</span><span>></span><span>学校管理</span><span>></span><span><?php if(isset($brand['id'])){?>编辑<?php }else{?>添加<?php }?>学校</span></div>
</div>
<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/brand/brand_save");?>" method="post" enctype='multipart/form-data'>
			<table class="form_table" cellpadding="0" cellspacing="0">
				<col width="150px" />
				<col />
				<tr>
					<th>登录用户名：</th>
					<td><input class="normal" name="username" type="text" value="<?php echo isset($brand['username'])?$brand['username']:"";?>" pattern="required" alt="登录用户名不能为空" />
						<label>*</label>
						<input name="brand_id" value="<?php echo isset($brand['id'])?$brand['id']:"";?>" type="hidden" />
					</td>
				</tr>
				<tr>
					<th>登录密码：</th>
					<td><input class="normal" name="password" type="password" value="" />
						<label>*</label>
					</td>
				</tr>
				<tr>
					<th>学校名称：</th>
					<td><input class="normal" name="name" type="text" value="<?php echo isset($brand['name'])?$brand['name']:"";?>" pattern="required" alt="品牌名称不能为空" />
						<label>*</label>
					</td>
				</tr>
				<tr>
					<th>学校简称：</th>
					<td><input class="normal" name="shortname" type="text" value="<?php echo isset($brand['shortname'])?$brand['shortname']:"";?>" pattern="required" alt="学校简称不能为空" maxlength="8" />
						<label>*</label>
					</td>
				</tr>
				<tr>
					<th>学校折扣：</th>
					<td><input class="normal" name="discount" type="text" value="<?php echo isset($brand['discount'])?$brand['discount']:"";?>" pattern="required" alt="学校折扣不能为空" /> %
						<label>*</label>
					</td>
				</tr>
				<tr>
					<th>排序：</th><td><input class="normal" name="sort" type="text" value="<?php echo isset($brand['sort'])?$brand['sort']:"";?>" pattern='int' empty alt='必需为整形数值'/></td>
				</tr>
				<tr>
					<th>企业官网：</th><td><input class="normal" name="url" type="text" value="<?php echo isset($brand['url'])?$brand['url']:"";?>" /><label>.dsanke.com</label></td>
				</tr>
				<tr>
					<th>LOGO：</th><td><div><?php if(isset($brand['logo'])){?><img src="<?php echo IUrl::creatUrl("")."".$brand['logo']."";?>" height="60px"/><br /><?php }?><input type='file' class='normal' name='logo'/></div></td>
				</tr>
				<tr>
					<th>所属分类：</th>
					<td>
						<?php $query = new IQuery("brand_category");$items = $query->find(); foreach($items as $key => $item){?><?php }?>
						<?php if($items){?>
						<ul class="select">
							<?php foreach($items as $key => $item){?>
							<li><label><input type="checkbox" value="<?php echo isset($item['id'])?$item['id']:"";?>" name="category[]" <?php if(isset($brand) && stripos(','.$brand['category_ids'].',',','.$item['id'].',') !== false){?>checked="checked"<?php }?> /><?php echo isset($item['name'])?$item['name']:"";?></label></li>
							<?php }?>
						</ul>
						<?php }else{?>
						系统暂无品牌分类，<a href='<?php echo IUrl::creatUrl("/brand/category_edit");?>' class='orange'>请点击添加</a>
						<?php }?>
					</td>
				</tr>
				<tr>
					<th>首页顶部横幅轮播图：</th>
					<td colspan="3">
						<div class="demo">
							<a class="btn" id="uploadButton3">上传图片</a>
						</div>
						<ul id="thumbnails3" class="ul_pics clearfix">
							<?php if($brand['ad_arr']){?>
								<?php foreach($brand['ad_arr'] as $key => $item){?>
									<div class='adpic'>
										<div class='pic_image'><img src="<?php echo IUrl::creatUrl("")."".$item."";?>" alt="<%=picRoot%>" true_src="<?php echo isset($item)?$item:"";?>" /></div>
										<div class='pic_dels'><a href='javascript:void(0)'>删除</a></div>
									</div>
								<?php }?>
							<?php }?>
						</ul>
					</td>
				</tr>
				<tr>
					<th valign="top">学校简介：</th><td><textarea name="description" id="description" style="width:700px;height:200px;"><?php echo isset($brand['description'])?$brand['description']:"";?></textarea></td>
				</tr>
			
				
					<tr>
					<th>学校主相册：</th>
					<td colspan="3">
						<div class="demo">
							<a class="btn" id="uploadButton2">上传图片</a>
						</div>
						<ul id="thumbnails2" class="ul_pics clearfix">
							<?php if($brand['img_arr']){?>
								<?php foreach($brand['img_arr'] as $key => $item){?>
									<div class='pic'>
										<div class='pic_image'><img src="<?php echo IUrl::creatUrl("")."".$item."";?>" alt="<%=picRoot%>" true_src="<?php echo isset($item)?$item:"";?>" /></div>
										<div class='pic_dels'><a href='javascript:void(0)'>删除</a></div>
									</div>
								<?php }?>
							<?php }?>
						</ul>
					</td>
				</tr>


				<style type="text/css">
					#infomation .td{padding:5px; border:1px solid #ccc; margin-bottom: 10px; width: 500px;}
					#infomation .td div input{ margin-bottom: 5px; }
					#infomation .td div input[type="text"]{}
				</style>
				<tbody id="infomation">
					<tr>
						<th>自定义页面内容：</th><td><a href="javascript:;" onclick="addInfomation()">增加页面栏目</a></td>
					</tr>
					<?php if($brand['attrs']){?>
					<?php foreach($brand['attrs'] as $key => $item){?>
					<tr>
						<th><a href="javascript:;" onclick="addPic(this, 0)">增加一行栏目内容</a></th>
						<td class="td">

							<input name="navtitle[]" type="text" placeholder="页面栏目标题：例如学校信息、老师信息" class='normal' value="<?php echo isset($item['navtitle'])?$item['navtitle']:"";?>" /><br />
							<?php foreach($item['info'] as $idx => $val){?>
							<div>
							<input type='file' class='normal' name='img[<?php echo isset($key)?$key:"";?>][]'/>
							<input type="hidden" name="oldimg[<?php echo isset($key)?$key:"";?>][]" value="<?php echo isset($val['img'])?$val['img']:"";?>">
							<input type="text" name="imgtitle[<?php echo isset($key)?$key:"";?>][]" placeholder="内容标题" class='normal' maxlength="40" value="<?php echo isset($val['imgtitle'])?$val['imgtitle']:"";?>" />
							<input type="text" name="imgbrief[<?php echo isset($key)?$key:"";?>][]" placeholder="内容描述" class='normal' maxlength="40" value="<?php echo isset($val['imgbrief'])?$val['imgbrief']:"";?>" />
							</div>
							<?php }?>
						</td>
					</tr>
					<?php }?>
					<?php }else{?>
					<tr>
						<th><a href="javascript:;" onclick="addPic(this, 0)">增加一行栏目内容</a></th>
						<td class="td">
							<div>
							<input name="navtitle[]" type="text" placeholder="页面栏目标题：例如学校信息、老师信息" class='normal' /><br />
							<input type='file' class='normal' name='img[0][]'/>
							<input type="text" name="imgtitle[0][]" placeholder="内容标题" class='normal' maxlength="40" />
							<input type="text" name="imgbrief[0][]" placeholder="内容描述" class='normal' maxlength="40" />
							</div>
						</td>
					</tr>
					<?php }?>
				</tbody>
				<tr>
				
				
				
				
				
				
				
				
				<!--update-->
				<tr>
						<th>固定电话：</th>
						<td><input type="text" class="normal" name="telephone" value="<?php echo isset($brand['telephone'])?$brand['telephone']:"";?>" /></td>
					</tr>
					<tr>
						<th>手机号码：</th>
						<td><input type="text" class="normal" name="mobile" value="<?php echo isset($brand['mobile'])?$brand['mobile']:"";?>" /></td>
					</tr>
					<tr>
						<th>邮箱：</th>
						<td><input type="text" class="normal" name="email" pattern="email" empty value="<?php echo isset($brand['email'])?$brand['email']:"";?>" /></td>
					</tr>
					<tr>
						<th>地区：</th>
						<td>
							<select name="province" id="province" child="city,area" onchange="changeProvince()"></select>
							<select name="city" id="city" child="area" onchange="changeCity()"></select>
							<select name="area" id="district"></select>
						</td>
					</tr>
					<tr>
						<th>详细地址：</th><td><input class="normal" name="address" type="text" value="<?php echo isset($brand['address'])?$brand['address']:"";?>" /></td>
					</tr>
					<tr>
						<th>客服QQ号码：</th>
						<td><input class="normal" name="server_num" type="text" value="<?php echo isset($brand['qq'])?$brand['qq']:"";?>" /><label>输入客服QQ号码，可以商品详情页面对客户进行解答</label></td>
					</tr>
				<!--// update-->
			
					<td></td>
					<td>
						<input type="hidden" name="img" id="img" value="<?php echo isset($brand['img'])?$brand['img']:"";?>" />
						<input type="hidden" name="adimg" id="adimg" value="<?php echo isset($brand['adimg'])?$brand['adimg']:"";?>" />
						<button class="submit" type="submit"><span>确 定</span></button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<script type='text/html' id='picTemplate2'>
 <div class='pic'>
		 <div class='pic_image'><img src="<?php echo IUrl::creatUrl("")."<%=picRoot%>";?>" alt="<%=picRoot%>" /></div>
		 <div class='pic_dels'><a href='javascript:void(0)'>删除</a></div>
 </div>
 </script>

 <script type='text/html' id='picTemplate3'>
 <div class='adpic'>
		 <div class='pic_image'><img src="<?php echo IUrl::creatUrl("")."<%=picRoot%>";?>" alt="<%=picRoot%>" /></div>
		 <div class='pic_dels'><a href='javascript:void(0)'>删除</a></div>
 </div>
 </script>

<script type="text/javascript">
$(function(){
	//编辑器载入
	/*KindEditor.ready(function(K){
		K.create('#description', {items:['source', 'justifyleft', 'justifycenter', 'justifyright',
		'justifyfull']});
	});*/

	//地区联动插件
	//var areaInstance = new areaSelect('province');
	//areaInstance.init(<?php echo JSON::encode($brand);?>);
	setProvince('<?php echo isset($brand['province'])?$brand['province']:"";?>', '<?php echo isset($brand['city'])?$brand['city']:"";?>' , '<?php echo isset($brand['area'])?$brand['area']:"";?>');

	// 删除图片
	$("body").on("click", ".pic .pic_dels a", function(){
		var _img_src = $(this).parent().parent().find('img').attr('true_src');
		$(this).parent().parent().remove();

		for( var i = 0; i < _album_arr.length; i++ )
		{
			if( _album_arr[i] == _img_src )
				_album_arr.splice( i, 1 );
		}

		update_pics();
	});

	$("body").on("click", ".adpic .pic_dels a", function(){
		var _img_src = $(this).parent().parent().find('img').attr('true_src');
		$(this).parent().parent().remove();
		$.post('<?php echo IUrl::creatUrl("/brand/ad_del");?>', {ad: _img_src, brand_id: '<?php echo isset($brand['id'])?$brand['id']:"";?>'}, function(json){
			if(json.msg == 1){
				
				for( var i = 0; i < _album_arr.length; i++ )
				{
					if( _ad_arr[i] == _img_src )
						_ad_arr.splice( i, 1 );
				}

				update_pics3();
			}else{
				alert('删除失败');
			}
		}, 'json');
		
	});
})

function changeProvince(){
    setCity($("#province").val());
}

function changeCity(){
    setCity($("#province").val(), $("#city").val());
}
function setProvince(provinceVal, cityVal, districtVal){
    var province = $("#province");
    var city = $("#city");
    province.get(0).options.length = 0;
    city.get(0).options.length = 0;
    $.getJSON("<?php echo IUrl::creatUrl("/block/area_child_my");?>/aid/0", function(json){
        if(json!=null){
            $.each(json, function(i, n){
                var option = new Option(n, i);
                if (i == provinceVal) {
                    option.selected = true;
                }
                province.get(0).options.add(option);
            });
            if(province.val())
                province.show();
            else
                province.hide();
            setCity(province.val(), cityVal, districtVal);
        }else{
            province.hide();
            city.hide();
        }
    });
}
function setCity(provinceVal, cityVal, districtVal){
    var city = $("#city");
    city.get(0).options.length = 0;
    provinceVal = provinceVal == null ? '' : provinceVal;
    $.getJSON("<?php echo IUrl::creatUrl("/block/area_child_my");?>/aid/" + provinceVal, function(json){
        if(json!=null){
            $.each(json, function(i, n){
                var option = new Option(n, i);
                if (i == cityVal) {
                    option.selected = true;
                }
                city.get(0).options.add(option);
            });
            if(city.val())
                city.show();
            else
                city.hide();
            setDistrict(city.val(), districtVal);
        }else{
            city.hide();
        }
    });
}

function setDistrict(cityVal, districtVal){
    var district = $("#district");
    district.get(0).options.length = 0;
    cityVal = cityVal == null ? '' : cityVal;
    $.getJSON("<?php echo IUrl::creatUrl("/block/area_child_my");?>/aid/" + cityVal, function(json){
        if(json!=null){
            $.each(json, function(i, n){
                var option = new Option(n, i);
                if (i == districtVal) {
                    option.selected = true;
                }
                district.get(0).options.add(option);
            });
            if(district.val())
                district.show();
            else
                district.hide();
        }else{
            district.hide();
        }
    });
}


function addInfomation(){
	var length = $('input[type="text"][name="navtitle[]"]').length;
	var html = '<tr><th><a href="javascript:;" onclick="addPic(this, '+length+')">增加一行栏目内容</a></th><td class="td"><div><input name="navtitle[]" type="text" placeholder="页面栏目标题" class="normal" /><br /><input type="file" class="normal" name="img['+length+'][]"/><input type="text" name="imgtitle['+length+'][]" placeholder="内容标题" maxlength="40" class="normal" /><input type="text" name="imgbrief['+length+'][]" placeholder="内容描述" class="normal" maxlength="40" /></div></td></tr>';
	$('#infomation').append(html);
}

function addPic(obj, length){
	var html = '<div><input type="file" class="normal" name="img['+length+'][]"/> <input type="text" name="imgtitle['+length+'][]" placeholder="内容标题" maxlength="40" class="normal" /> <input type="text" name="imgbrief['+length+'][]" placeholder="内容描述" class="normal" maxlength="40" /></div>';
	$(obj).parent().parent().find('td').append(html);
	$('#' + type).append(html);
}

//running running upload img 处理课堂照片的图片上传
function uploadPicCallback(picJson)
{
	if ( picJson.flag == -1 )
	{
		return false;
	}

	var _div = 'thumbnails2';
	var picHtml = template.render('picTemplate2',{'picRoot':picJson.img});
	$('#' + _div).append(picHtml);
	if($('#' + _div + ' img[class="current"]').length == 0)
	{
		$('#' + _div + ' img:first').addClass('current');
	}

	_album_arr.push( picJson.img );

	update_pics();
}

function update_pics()
{
	var _str = '';
	for( i in _album_arr )
	{
		_str = ( _str == '' ) ? _album_arr[i] : _str + ',' + _album_arr[i];
	}
	$('#img').val( _str );
}

var uploader2 = new plupload.Uploader({
 runtimes: 'html5,flash,silverlight,html4',
 browse_button: 'uploadButton2',
 url: "<?php echo IUrl::creatUrl("/goods/goods_upload_class_pics");?>",
 filters: {
		 max_file_size: '1024kb',
		 mime_types: [
				 {title: "files", extensions: "jpg,png,gif"}
		 ]
 },
 multi_selection: true,
 init: {
		 FilesAdded: function(up, files) {
				 if ($("#thumbnails2").children("li").length > 30) {
						 alert("您上传的图片太多了！");
						 uploader.destroy();
				 } else {
						 var li = '';
						 plupload.each(files, function(file) {
						 });
						 $("#thumbnails2").append(li);
						 uploader2.start();
				 }
		 },
		 UploadProgress: function(up, file) {
		 },
		 FileUploaded: function(up, file, info) {
				var data = eval("(" + info.response + ")");
				 if ( info.response == '{"flag":-10}' )
				 {
						 alert('上传失败，尺寸不正确');
						 return false;
				 }
				 uploadPicCallback(data);
		 },
		 Error: function(up, err) {
				 alert(err.message);
		 }
 }
});
uploader2.init();

var uploader3 = new plupload.Uploader({
 runtimes: 'html5,flash,silverlight,html4',
 browse_button: 'uploadButton3',
 url: "<?php echo IUrl::creatUrl("/goods/goods_upload_class_pics");?>",
 filters: {
		 max_file_size: '1024kb',
		 mime_types: [
				 {title: "files", extensions: "jpg,png,gif"}
		 ]
 },
 multi_selection: true,
 init: {
		 FilesAdded: function(up, files) {
				 if ($("#thumbnails3").children("li").length > 30) {
						 alert("您上传的图片太多了！");
						 uploader3.destroy();
				 } else {
						 var li = '';
						 plupload.each(files, function(file) {
						 });
						 $("#thumbnails3").append(li);
						 uploader3.start();
				 }
		 },
		 UploadProgress: function(up, file) {
		 },
		 FileUploaded: function(up, file, info) {
				var data = eval("(" + info.response + ")");
				 if ( info.response == '{"flag":-10}' )
				 {
						 alert('上传失败，尺寸不正确');
						 return false;
				 }
				 uploadPicCallback3(data);
		 },
		 Error: function(up, err) {
				 alert(err.message);
		 }
 }
});
uploader3.init();

function uploadPicCallback3(picJson)
{
	if ( picJson.flag == -1 )
	{
		return false;
	}

	var _div = 'thumbnails3';
	var picHtml = template.render('picTemplate3',{'picRoot':picJson.img});
	$('#' + _div).append(picHtml);
	if($('#' + _div + ' img[class="current"]').length == 0)
	{
		$('#' + _div + ' img:first').addClass('current');
	}

	_ad_arr.push( picJson.img );

	update_pics3();
}

function update_pics3()
{
	var _str = '';
	for( i in _ad_arr )
	{
		_str = ( _str == '' ) ? _ad_arr[i] : _str + ',' + _ad_arr[i];
	}
	$('#adimg').val( _str );
}
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
