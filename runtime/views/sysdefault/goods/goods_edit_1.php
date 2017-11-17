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
			<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jqueryFileUpload/jquery.ui.widget.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jqueryFileUpload/jquery.iframe-transport.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jqueryFileUpload/jquery.fileupload.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/cropper/cropper.min.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/cropper/cropper.min.css" />
<script type="text/javascript" src="/plugins/newupload/plupload.full.min.js"></script>
<link rel="stylesheet" href="/resource/scripts/layer/skin/layer.css">
<script type="text/javascript" src="/resource/scripts/layer/layer.js"></script>
<script type="text/javascript" src="/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/plugins/ueditor/ueditor.all.min.js"></script>
<style>
	.cropper-wrapper img{max-height:420px;}
</style>
<div class="headbar clearfix">
	<div class="position"><span>课程</span><span>></span><span>课程管理</span><span>></span><span>课程编辑</span></div>
	<ul class="tab" name="menu1">
		<li id="li_1" class="selected"><a href="javascript:void(0)" hidefocus="true" onclick="select_tab('1')">课程信息</a></li>

	</ul>
</div>

<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/goods/goods_update");?>" name="goodsForm" method="post">
			<input type="hidden" name="id" value="" />
			<input type='hidden' name="img" value="" />
			<input type='hidden' name="_imgList" value="" />
			<input type='hidden' name="callback" value="<?php echo IUrl::getRefRoute();?>" />

			<div id="table_box_1">
				<table class="form_table">
					<col width="150px" />
					<col />
					<tr>
						<th>课程名称：</th>
						<td>
							<input class="normal" name="name" type="text" value="" pattern="required" alt="课程名称不能为空" /><label>*</label>
						</td>
					</tr>
					<tr>
						<th>关键词：</th>
						<td>
							<input type='text' class='middle' name='keywords' value='' />
							<label>每个关键词最长为15个字符，必须以","(逗号)分隔符</label>
						</td>
					</tr>
					<tr>
						<th>结算商户：</th>
						<td>
							<select class="auto selectpicker show-tick form-control" name="seller_id" data-live-search="true">
								<option value="0">第三课自营 </option>
								<?php $query = new IQuery("seller");$query->order = "id desc";$query->where = "is_del = 0";$items = $query->find(); foreach($items as $key => $item){?>
								<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['true_name'])?$item['true_name']:"";?>-<?php echo isset($item['seller_name'])?$item['seller_name']:"";?></option>
								<?php }?>
							</select>
							<a href='<?php echo IUrl::creatUrl("/member/seller_edit");?>' class='orange'>添加商户</a>
						</td>
					</tr>
					<tr>
						<th>展示设置：</th>
						<td>
							<select class="auto selectpicker show-tick form-control" name="brand_id" data-live-search="true">
								<option value="0">请选择</option>
								<?php $query = new IQuery("brand");$query->order = "id desc";$items = $query->find(); foreach($items as $key => $item){?>
								<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></option>
								<?php }?>
							</select>
						</td>
					</tr>
					<tr>
						<th>所属分类：</th>
						<td>
							<div id="__categoryBox" style="margin-bottom:8px"></div>
							<button class="btn" type="button" name="_goodsCategoryButton"><span class="add">设置分类</span></button>
							<?php plugin::trigger('goodsCategoryWidget',array("type" => "checkbox","name" => "_goods_category[]","value" => isset($goods_category) ? $goods_category : ""))?>
							<a href='<?php echo IUrl::creatUrl("/goods/category_edit");?>' class='orange'>请点击添加分类</a>
						</td>
					</tr>
			        <tr>
						<th>简介：</th><td><textarea name="description"></textarea></td>
					</tr>
					<tr>
						<th>课程相册：</th>
						<td>
							<div class="demo" style="margin-top: 8px;">
				               <label class="tip"></label>
				                <ul id="img_pics" class="ul_pics clearfix">
				                	<?php if(isset($goods_photo)){?>
				                	<?php foreach($goods_photo as $key => $item){?>
									<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="<?php echo IUrl::creatUrl("")."".$item['img']."";?>" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="_imgList[]" value="<?php echo isset($item['img'])?$item['img']:"";?>" /></li>
				                	<?php }?>
				                	<?php }?>
				                </ul>
			               <a class="btn" id="img" style="padding: 4px 13px;">添加课程图片...</a>
				            </div>
						</td>
					</tr>
					<tr>
						<th>详情</th>
						<td><textarea id="content" name="content" style="width:700px;height:400px;"></textarea></td>
					</tr>

                      <tr style="display:none">
						<th>课程设置:</th>
						<td>
							<select class="auto" name="model_id" onchange="create_attr(this.value)">
																<option value="2">课程设置</option>
															</select>
						</td>
					</tr>
                      <tr id="properties" style="">
						<th>课程设置</th>
						<td>
							<table class="border_table1" id="propert_table">
							<tr>
								<th>课程类别</th>
								<td>
											<label class="attr"><input type="checkbox" name="attr_id_4[]" value="免费课">免费课</label>
											<label class="attr"><input type="checkbox" name="attr_id_4[]" value="体验课">体验课</label>
											<label class="attr"><input type="checkbox" name="attr_id_4[]" value="短期课">短期课</label>
											<label class="attr"><input type="checkbox" name="attr_id_4[]" value="常规课">常规课</label>
											<label class="attr"><input type="checkbox" name="attr_id_4[]" value="暑期课">暑期课</label>
											<label class="attr"><input type="checkbox" name="attr_id_4[]" value="寒假课">寒假课</label>
											<label class="attr"><input type="checkbox" name="attr_id_4[]" value="托管班">托管班</label>
											<label class="attr"><input type="checkbox" name="attr_id_4[]" value="补习班">补习班</label>
								</td>
							</tr>
							<tr>
								<th>学生年龄</th>
								<td>
											<label class="attr"><input type="checkbox" name="attr_id_5[]" value="1岁以下">1岁以下</label>
											<label class="attr"><input type="checkbox" name="attr_id_5[]" value="1-3岁">1-3岁</label>
											<label class="attr"><input type="checkbox" name="attr_id_5[]" value="4-6岁">4-6岁</label>
											<label class="attr"><input type="checkbox" name="attr_id_5[]" value="7-9岁">7-9岁</label>
											<label class="attr"><input type="checkbox" name="attr_id_5[]" value="10-12岁">10-12岁</label>
											<label class="attr"><input type="checkbox" name="attr_id_5[]" value="13-15岁">13-15岁</label>
											<label class="attr"><input type="checkbox" name="attr_id_5[]" value="16-18岁">16-18岁</label>
											<label class="attr"><input type="checkbox" name="attr_id_5[]" value="18岁以上">18岁以上</label>
											<label class="attr"><input type="checkbox" name="attr_id_5[]" value="无年龄限制">无年龄限制</label>
								</td>
							</tr>
							<tr>
								<th>学生年级</th>
								<td>
											<label class="attr"><input type="checkbox" name="attr_id_6[]" value="1年级">1年级</label>
											<label class="attr"><input type="checkbox" name="attr_id_6[]" value="2年级">2年级</label>
											<label class="attr"><input type="checkbox" name="attr_id_6[]" value="3年级">3年级</label>
											<label class="attr"><input type="checkbox" name="attr_id_6[]" value="4年级">4年级</label>
											<label class="attr"><input type="checkbox" name="attr_id_6[]" value="5年级">5年级</label>
											<label class="attr"><input type="checkbox" name="attr_id_6[]" value="6年级">6年级</label>
											<label class="attr"><input type="checkbox" name="attr_id_6[]" value="7年级">7年级</label>
											<label class="attr"><input type="checkbox" name="attr_id_6[]" value="8年级">8年级</label>
											<label class="attr"><input type="checkbox" name="attr_id_6[]" value="9年级">9年级</label>
											<label class="attr"><input type="checkbox" name="attr_id_6[]" value="高一">高一</label>
											<label class="attr"><input type="checkbox" name="attr_id_6[]" value="高二">高二</label>
											<label class="attr"><input type="checkbox" name="attr_id_6[]" value="高三">高三</label>
											<label class="attr"><input type="checkbox" name="attr_id_6[]" value="大学">大学</label>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					<tr>
						<th>价格设置：</th>
						<td>
						<div class="con">
								<table class="border_table">
									<thead id="goodsBaseHead"></thead>

									<!--课程标题模板-->
									<script id="goodsHeadTemplate" type='text/html'>
									<tr>
										<th>商品货号</th>
										<%var isProduct = false;%>
										<%for(var item in templateData){%>
										<%isProduct = true;%>
										<th><a href="javascript:confirm('确定要删除此列规格？','delSpec(<%=templateData[item]['id']%>)');"><%=templateData[item]['name']%>【删】</a></th>
										<%}%>
										<th>标题</th>
									    <th>课时数</th>
									    <th>上课时间/地点</th>
									    <th>学生年龄/年级</th>
										<th>招生人数</th>
										<th>市场价格</th>
										<th>销售价格</th>
										<th style="display:none;">成本价格</th>
										<th style="display:none;">重量(克)</th>
										<th>下架时间</th>
										<th>可用代金券数量</th>
										<th>代金券销售价</th>
										<th>短期课使用次数</th>
						<%if(isProduct == true){%>
										<th>操作</th>
										<%}%>
									</tr>
									</script>

									<tbody id="goodsBaseBody"></tbody>

									<!--商品内容模板-->
									<script id="goodsRowTemplate" type="text/html">
									<%var i=0;%>
									<%for(var item in templateData){%>
									<%item = templateData[item]%>
									<tr class='td_c'>
										<td><input class="small" name="_goods_no[<%=i%>]" pattern="required" type="text" value="<%=item['goods_no'] ? item['goods_no'] : item['products_no']%>" /></td>
										<%var isProduct = false;%>
										<%var specArrayList = typeof item['spec_array'] == 'string' && item['spec_array'] ? JSON().parse(item['spec_array']) : item['spec_array'];%>
										<%for(var result in specArrayList){%>
										<%result = specArrayList[result]%>
										<input type='hidden' name="_spec_array[<%=i%>][]" value='<%=JSON().stringify(result)%>' />
										<%isProduct = true;%>
										<td>
											<%if(result['type'] == 1){%>
												<%=result['value']%>
											<%}else{%>
												<img class="img_border" width="30px" height="30px" src="<?php echo IUrl::creatUrl("")."<%=result['value']%>";?>">
											<%}%>
										</td>
										<%}%>
										<td><input class="tiny" name="_cusval[]" type="text" value="<%=item['cusval']%>" /></td>
										<td><input class="tiny" name="_classnum[]" type="number" value="<%=item['classnum']%>" /></td>
										<td><input class="tiny" name="_school_time[]" type="text" value="<%=item['school_time']%>" /></td>
										<td><input class="tiny" name="_Age_grade[]" type="text" value="<%=item['Age_grade']%>" /></td>
										<td><input class="tiny" name="_store_nums[<%=i%>]" type="number" pattern="int" value="<%=item['store_nums']?item['store_nums']:100%>" /></td>
										<td><input class="tiny" name="_market_price[<%=i%>]" type="text" pattern="float" value="<%=item['market_price']%>" /></td>
										<td>
											<input type='hidden' name="_groupPrice[<%=i%>]" value="<%=item['groupPrice']%>" />
											<input class="tiny" name="_sell_price[<%=i%>]" type="text" pattern="float" value="<%=item['sell_price']%>" />
										</td>
										<td style="display:none;"><input class="tiny" name="_cost_price[<%=i%>]" type="text" pattern="float" empty value="<%=item['cost_price']%>" /></td>
										<td style="display:none;"><input class="tiny" name="_weight[<%=i%>]" type="text" pattern="float" empty value="<%=item['weight']%>" /></td>
										<td><input type="text" class="normal" name="_down_time" onfocus="WdatePicker()" value="<%=item['down_time']%>"></td>
										<td><input class="tiny" name="_chit[]" type="number" value="<%=item['chit']%>" /></td>
										<td><input class="tiny" name="_max_price[]" type="number" value="<%=item['max_price']%>" /></td>
										<td><input class="tiny" name="_dqk_times[]" type="number" value="<%=item['dqk_times']%>" /></td>

										<%if(isProduct == true){%>
										<td><a href="javascript:void(0)" onclick="delProduct(this);"><img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_del.gif";?>" alt="删除" /></a></td>
										<%}%>
									</tr>
									<%i++;%>
									<%}%>
									</script>
								</table>
							</div>
						</td>
						</tr>
					<tr>
					<th></th>
						<td>
							<button class="btn" type="button" onclick="selSpec()"><span class="add">添加不同价格</span></button>
						</td>
					</tr>
					<tr>
						<th>课程显示类型：</th>
						<td>
							<label class="attr"><input name="_goods_commend[]" type="checkbox" value="1" />最新</label>
							<label class="attr"><input name="_goods_commend[]" type="checkbox" value="2" />特价</label>
							<label class="attr"><input name="_goods_commend[]" type="checkbox" value="3" />热卖</label>
							<label class="attr"><input name="_goods_commend[]" type="checkbox" value="4" />推荐</label>
						</td>
					</tr>
		             <tr>
						<th>是否上架：</th>
						<td>
							<label class='attr'><input type="radio" name="is_del" value="0" checked> 是</label>
							<label class='attr'><input type="radio" name="is_del" value="2"> 否</label>
							<label>只有上架的课程才会在前台显示出来，客户是无法看到下架课程</label>
						</td>
					</tr>
					<tr>
						<th>是否共享：</th>
						<td>
							<label class='attr'><input type="radio" name="is_share" value="1"> 是</label>
							<label class='attr'><input type="radio" name="is_share" value="0" checked> 否</label>
						</td>
					</tr>
					</tr>
				</table>
			</div>

			<table class="form_table">
				<col width="150px" />
				<col />
				<tr>
					<td></td>
					<td><button class="submit" type="submit" onclick="return checkForm()"><span>发布课程</span></button></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<div class="cropper">
	<div class="cropper-wrapper"><img src="" alt=""></div>
	<div class="preview preview-lg"></div>
</div>
<script language="javascript">
//创建表单实例
var formObj = new Form('goodsForm');

//默认货号
var defaultProductNo = '<?php echo goods_class::createGoodsNo();?>';

$(function()
{
	UE.getEditor('content');
	create_attr(2);
	$('._goods_no').val(defaultProductNo);
	$('.default_no').val(defaultProductNo+'_1');
	//课程图片的回填
	<?php if(isset($goods_photo)){?>
	var goodsPhoto = <?php echo JSON::encode($goods_photo);?>;
	for(var item in goodsPhoto)
	{
		var picHtml = template.render('picTemplate',{'picRoot':goodsPhoto[item].img});
		$('#thumbnails').append(picHtml);
	}
	<?php }?>

	//课程默认图片
	<?php if(isset($form['img']) && $form['img']){?>
	$('#thumbnails img[name="picThumb"][alt="<?php echo $form['img'];?>"]').addClass('current');
	<?php }?>

	initProductTable();

	//存在课程信息
	<?php if(isset($form)){?>
	var goods = <?php echo JSON::encode($form);?>;

	var goodsRowHtml = template.render('goodsRowTemplate',{'templateData':[goods]});
	$('#goodsBaseBody').html(goodsRowHtml);

	formObj.init(goods);

	//模型选择
	$('[name="model_id"]').change();
	<?php }else{?>
	$('[name="_goods_no[0]"]').val(defaultProductNo);
	<?php }?>

	//存在货品信息,进行数据填充
	<?php if(isset($product)){?>
	var spec_array = <?php if($product[0]['spec_array']){?><?php echo $product[0]['spec_array'];?><?php }else{?>new Array()<?php }?>;
	var product    = <?php echo JSON::encode($product);?>;

	var goodsHeadHtml = template.render('goodsHeadTemplate',{'templateData':spec_array});
	$('#goodsBaseHead').html(goodsHeadHtml);

	var goodsRowHtml = template.render('goodsRowTemplate',{'templateData':product});
	$('#goodsBaseBody').html(goodsRowHtml);
	<?php }?>

	//课程促销回填
	<?php if(isset($goods_commend)){?>
	formObj.setValue('_goods_commend[]',"<?php echo join(';',$goods_commend);?>");
	<?php }?>

	//编辑器载入
	//KindEditorObj = KindEditor.create('#content',{"filterMode":false});

	//jquery图片上传
    $('[name="_goodsFile"]').fileupload({
        dataType: 'json',
        done: function (e, data)
        {
        	if(data.result && data.result.flag == 1)
        	{
        		uploadPicCallback(data.result);
        	}
        	else
        	{
        		realAlert("上传失败");
        	}
        },
        progressall: function (e, data)
        {
            var progress = parseInt(data.loaded / data.total * 100);
            $('#uploadPercent').text("加载完成："+progress+"%");
        }
    });

    var ids = new Array("img");
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
			cutPicture(data,self);
		})
		uploadImg.bind('Error',function(up, err) {
            alert(err.message);
        })
	})
});

//初始化货品表格
function initProductTable()
{
	//默认产生一条课程标题空挡
	var goodsHeadHtml = template.render('goodsHeadTemplate',{'templateData':[]});
	$('#goodsBaseHead').html(goodsHeadHtml);

	//默认产生一条课程空挡
	var goodsRowHtml = template.render('goodsRowTemplate',{'templateData':[[]]});
	$('#goodsBaseBody').html(goodsRowHtml);
}

//删除货品
function delProduct(_self)
{
	$(_self).parent().parent().remove();
	if($('#goodsBaseBody tr').length == 0)
	{
		initProductTable();
	}
}

//提交表单前的检查
function checkForm()
{
	//整理课程图片
	var goodsPhoto = [];
	$('#thumbnails img[name="picThumb"]').each(function(){
		goodsPhoto.push(this.alt);
	});
	if(goodsPhoto.length > 0)
	{
		$('input[name="_imgList"]').val(goodsPhoto.join(','));
		$('input[name="img"]').val($('#thumbnails img[name="picThumb"][class="current"]').attr('alt'));
	}
	return true;
}

//tab标签切换
function select_tab(curr_tab)
{
	$("form[name='goodsForm'] > div").hide();
	$("#table_box_"+curr_tab).show();
	$("ul[name=menu1] > li").removeClass('selected');
	$('#li_'+curr_tab).addClass('selected');
}

/**
 * 会员价格
 * @param obj 按钮所处对象
 */
function memberPrice(obj)
{
	var sellPrice = $(obj).siblings('input[name^="_sell_price"]')[0].value;
	if($.isNumeric(sellPrice) == false)
	{
		alert('请先设置课程的价格再设置会员价格');
		return;
	}

	var groupPriceValue = $(obj).siblings('input[name^="_groupPrice"]');

	//用户组的价格
	art.dialog.data('groupPrice',groupPriceValue.val());

	//开启新页面
	var tempUrl = '<?php echo IUrl::creatUrl("/goods/member_price/sell_price/@sell_price@");?>';
	tempUrl = tempUrl.replace('@sell_price@',sellPrice);
	art.dialog.open(tempUrl,{
		id:'memberPriceWindow',
	    title: '此课程对于会员组价格',
	    ok:function(iframeWin, topWin)
	    {
	    	var formObject = iframeWin.document.forms['groupPriceForm'];
	    	var groupPriceObject = {};
	    	$(formObject).find('input[name^="groupPrice"]').each(function(){
	    		if(this.value != '')
	    		{
	    			//去掉前缀获取group的ID
		    		var groupId = this.name.replace('groupPrice','');

		    		//拼接json串
		    		groupPriceObject[groupId] = this.value;
	    		}
	    	});

	    	//更新会员价格值
    		var temp = [];
    		for(var gid in groupPriceObject)
    		{
    			temp.push('"'+gid+'":"'+groupPriceObject[gid]+'"');
    		}
    		groupPriceValue.val('{'+temp.join(',')+'}');
    		return true;
		}
	});
}

//添加价格选项
function selSpec()
{
	//课程是否已经存在
	var tempUrl  = $('input:hidden[name^="_spec_array"]').length > 0 ? '<?php echo IUrl::creatUrl("/goods/search_spec");?>' : '<?php echo IUrl::creatUrl("/goods/search_spec/model_id/@model_id@/goods_id/@goods_id@");?>';
	var model_id = $('[name="model_id"]').val();
	var goods_id = $('[name="id"]').val();

	tempUrl = tempUrl.replace('@model_id@',model_id);
	tempUrl = tempUrl.replace('@goods_id@',goods_id);

	art.dialog.open(tempUrl,{
		title:'设置课程的价格选项',
		okVal:'保存',
		ok:function(iframeWin, topWin)
		{
			//添加的价格选项
			var addSpecObject = $(iframeWin.document).find('[id^="vertical_"]');
			if(addSpecObject.length == 0)
			{
				return;
			}

			var specIsHere    = getIsHereSpec();
			var specValueData = specIsHere.specValueData;
			var specData      = specIsHere.specData;

			//追加新建价格选项
			addSpecObject.each(function()
			{
				$(this).find('input:hidden[name="specJson"]').each(function()
				{
					var json = $.parseJSON(this.value);
					if(!specValueData[json.id])
					{
						specData[json.id]      = json;
						specValueData[json.id] = [];
					}
					specValueData[json.id].push({"tip":json.tip,"value":json.value});
				});
			});
			createProductList(specData,specValueData);
		}
	});
}

//笛卡儿积组合
function descartes(list,specData)
{
	//parent上一级索引;count指针计数
	var point  = {};

	var result = [];
	var pIndex = null;
	var tempCount = 0;
	var temp   = [];

	//根据参数列生成指针对象
	for(var index in list)
	{
		if(typeof list[index] == 'object')
		{
			point[index] = {'parent':pIndex,'count':0}
			pIndex = index;
		}
	}

	//单维度数据结构直接返回
	if(pIndex == null)
	{
		return list;
	}

	//动态生成笛卡尔积
	while(true)
	{
		for(var index in list)
		{
			tempCount = point[index]['count'];
			var itemSpecData = list[index][tempCount];
			temp.push({"id":specData[index].id,"type":specData[index].type,"name":specData[index].name,"value":itemSpecData.value,"tip":itemSpecData.tip});
		}

		//压入结果数组
		result.push(temp);
		temp = [];

		//检查指针最大值问题
		while(true)
		{
			if(point[index]['count']+1 >= list[index].length)
			{
				point[index]['count'] = 0;
				pIndex = point[index]['parent'];
				if(pIndex == null)
				{
					return result;
				}

				//赋值parent进行再次检查
				index = pIndex;
			}
			else
			{
				point[index]['count']++;
				break;
			}
		}
	}
}

//根据模型动态生成扩展属性
function create_attr(model_id)
{
	$.getJSON("<?php echo IUrl::creatUrl("/block/attribute_init");?>",{'model_id':model_id,'random':Math.random()}, function(json)
	{
		if(json && json.length > 0)
		{
			var templateHtml = template.render('propertiesTemplate',{'templateData':json});
			$('#propert_table').html(templateHtml);
			$('#properties').show();

			//表单回填设置项
			<?php if(isset($goods_attr)){?>
			<?php $attrArray = array();?>
			<?php foreach($goods_attr as $key => $item){?>
			<?php $valArray = explode(',',$item);?>
			<?php $attrArray[] = '"attr_id_'.$key.'[]":"'.join(";",IFilter::act($valArray)).'"'?>
			<?php $attrArray[] = '"attr_id_'.$key.'":"'.join(";",IFilter::act($valArray)).'"'?>
			<?php }?>
			formObj.init({<?php echo join(',',$attrArray);?>});
			<?php }?>
		}
		else
		{
			$('#properties').hide();
		}
	});
}

/**
 * 图片上传回调,handers.js回调
 * @param picJson => {'flag','img','list','show'}
 */
function uploadPicCallback(picJson)
{
	var picHtml = template.render('picTemplate',{'picRoot':picJson.img});
	$('#thumbnails').append(picHtml);

	//默认设置第一个为默认图片
	if($('#thumbnails img[name="picThumb"][class="current"]').length == 0)
	{
		$('#thumbnails img[name="picThumb"]:first').addClass('current');
	}
}

/**
 * 设置课程默认图片
 */
function defaultImage(_self)
{
	$('#thumbnails img[name="picThumb"]').removeClass('current');
	$(_self).addClass('current');
}

//获取已经存在的价格选项
function getIsHereSpec()
{
	//开始遍历价格选项
	var specValueData = {};
	var specData      = {};

	//价格选项已经存在的数据
	if($('input:hidden[name^="_spec_array"]').length > 0)
	{
		$('input:hidden[name^="_spec_array"]').each(function()
		{
			var json = $.parseJSON(this.value);
			if(!specValueData[json.id])
			{
				specData[json.id]      = json;
				specValueData[json.id] = [];
			}

			//去掉spec_array中的已经添加的重复值
			for(var i in specValueData[json.id])
			{
				for(var item in specValueData[json.id][i])
				{
					item = specValueData[json.id][i];
					if(item.value == json.value && item.tip == json.tip)
					{
						return;
					}
				}
			}
			specValueData[json.id].push({"tip":json.tip,"value":json.value});
		});
	}
	return {"specData":specData,"specValueData":specValueData};
}

/**
 * @brief 根据价格选项数据生成货品序列
 * @param object specData价格选项数据对象
 * @param object specValueData 价格选项值对象集合
 */
function createProductList(specData,specValueData)
{
	//生成货品的笛卡尔积
	var specMaxData = descartes(specValueData,specData);

	//生成最终的货品数据
	var productList = [];
	for(var i = 0;i < specMaxData.length;i++)
	{
		//从表单中获取默认课程数据
		var productJson = {};
		var defaultIndex = $('#goodsBaseBody tr').length > i ? i : i%$('#goodsBaseBody tr').length;
		$('#goodsBaseBody tr:eq('+defaultIndex+')').find('input[type="text"]').each(function(){
			productJson[this.name.replace(/^_(\w+)\[\d+\]/g,"$1")] = this.value;
		});

		var productItem = {};
		for(var index in productJson)
		{
			//自动组建货品号
			if(index == 'goods_no')
			{
				//值为空时设置默认货号
				if(productJson[index] == '')
				{
					productJson[index] = defaultProductNo;
				}

				if(productJson[index].match(/(?:\-\d*)$/) == null)
				{
					//正常货号生成
					productItem['goods_no'] = productJson[index]+'-'+(i+1);
				}
				else
				{
					//货号已经存在则替换
					productItem['goods_no'] = productJson[index].replace(/(?:\-\d*)$/,'-'+(i+1));
				}
			}
			else
			{
				productItem[index] = productJson[index];
			}
		}
		productItem['spec_array'] = specMaxData[i];
		productList.push(productItem);
	}

	//创建价格选项标题
	var goodsHeadHtml = template.render('goodsHeadTemplate',{'templateData':specData});
	$('#goodsBaseHead').html(goodsHeadHtml);

	//创建货品数据表格
	var goodsRowHtml = template.render('goodsRowTemplate',{'templateData':productList});
	$('#goodsBaseBody').html(goodsRowHtml);

	if($('#goodsBaseBody tr').length == 0)
	{
		initProductTable();
	}
}

//删除价格选项
function delSpec(specId)
{
	$('input:hidden[name^="_spec_array"]').each(function()
	{
		var json = $.parseJSON(this.value);
		if(json.id == specId)
		{
			$(this).remove();
		}
	});

	//当前已经存在的价格选项数据
	var specIsHere = getIsHereSpec();
	createProductList(specIsHere.specData,specIsHere.specValueData);
}
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
        var imgSrc = '<li class="pic"><img style="margin:5px;opacity:1;width:150px;" src="'+dataurl+'" class="current"><br><a href="javascript:void(0)" onclick="$(this).parent().remove();">删除</a><input type="hidden" name="_imgList[]" value="'+dataurl+'" /></li>';

        $('#'+_self).siblings('ul').append(imgSrc);
        layer.close(index);
	  }
	});
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
