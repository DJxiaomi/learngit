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
		<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/editor/kindeditor-min.js"></script><script type="text/javascript">window.KindEditor.options.uploadJson = "/pic/upload_json";window.KindEditor.options.fileManagerJson = "/pic/file_manager_json";</script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jqueryFileUpload/jquery.ui.widget.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jqueryFileUpload/jquery.iframe-transport.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jqueryFileUpload/jquery.fileupload.js"></script>
<?php $seller_id = $this->seller['seller_id']?>
<article class="module width_full">
	<header>
		<h3 class="tabs_involved">商品编辑</h3>

		<ul class="tabs" name="menu1">
			<li id="li_1" class="active"><a href="javascript:select_tab('1');">商品信息</a></li>
			<li id="li_2"><a href="javascript:select_tab('2');">描述</a></li>
			<li id="li_3"><a href="javascript:select_tab('3');">SEO优化</a></li>
		</ul>
	</header>

	<form action="<?php echo IUrl::creatUrl("/seller/goods_update");?>" name="goodsForm" method="post">
		<input type="hidden" name="id" value="0" />
		<input type='hidden' name="img" value="" />
		<input type='hidden' name="_imgList" value="" />
		<input type='hidden' name="callback" value="<?php echo IUrl::getRefRoute();?>" />

		<!--商品信息 开始-->
		<div class="module_content" id="table_box_1">
			<fieldset>
				<label>商品名称</label>
				<input name="name" type="text" value="" initmsg="商品名称填写正确" pattern="required" alt="商品名称不能为空" />
			</fieldset>

			<fieldset>
				<label>关键词</label>
				<input type='text' name='search_words' value='' />
				<label class="tip">每个关键词最长为15个字符，超过后系统不予存储，每个词以逗号分隔</label>
			</fieldset>

			<fieldset>
				<label>所属分类</label>
				<div class="box">
					<div id="__categoryBox" style="margin-bottom:8px"></div>
					<input class="alt_btn" type="button" name="_goodsCategoryButton" value="设置分类" />
					<?php plugin::trigger('goodsCategoryWidget',array("type" => "checkbox","name" => "_goods_category[]","value" => isset($goods_category) ? $goods_category : ""))?>
				</div>
			</fieldset>

			<fieldset>
				<label>商品排序</label>
				<input name="sort" type="text" pattern="int" value="99" />
			</fieldset>

			<fieldset>
				<label>计件单位显示</label>
				<input name="unit" type="text" value="件"/>
			</fieldset>

			<fieldset>
				<label>是否免运费</label>
				<div class="box">
					<input type='radio' name='is_delivery_fee' value='1'  />是
					<input type='radio' name='is_delivery_fee' value='0' checked="checked" />否
				</div>
			</fieldset>

			<fieldset>
				<label>基本数据</label>
				<table class="tablesorter clear">
					<thead id="goodsBaseHead"></thead>
					<tbody id="goodsBaseBody"></tbody>

					<!--商品标题模板-->
					<script id="goodsHeadTemplate" type='text/html'>
					<tr>
						<th>商品货号</th>
						<%var isProduct = false;%>
						<%for(var item in templateData){%>
						<%isProduct = true;%>
						<th><a href="javascript:confirm('确定要删除此列规格？','delSpec(<%=templateData[item]['id']%>)');"><%=templateData[item]['name']%>【删】</a></th>
						<%}%>
						<th>库存</th>
						<th>市场价格</th>
						<th>销售价格</th>
						<th>成本价格</th>
						<th>重量(克)</th>
						<%if(isProduct == true){%>
						<th>操作</th>
						<%}%>
					</tr>
					</script>

					<!--商品内容模板-->
					<script id="goodsRowTemplate" type="text/html">
					<%var i=0;%>
					<%for(var item in templateData){%>
					<%item = templateData[item]%>
					<tr>
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
						<td><input class="tiny" name="_store_nums[<%=i%>]" type="text" pattern="int" value="<%=item['store_nums']?item['store_nums']:100%>" /></td>
						<td><input class="tiny" name="_market_price[<%=i%>]" type="text" pattern="float" value="<%=item['market_price']%>" /></td>
						<td>
							<input type='hidden' name="_groupPrice[<%=i%>]" value="<%=item['groupPrice']%>" />
							<input class="tiny" name="_sell_price[<%=i%>]" type="text" pattern="float" value="<%=item['sell_price']%>" />
							<input type="button" onclick="memberPrice(this);" value="会员组价格 <%if(item['groupPrice']){%>*<%}%>" />
						</td>
						<td><input class="tiny" name="_cost_price[<%=i%>]" type="text" pattern="float" empty value="<%=item['cost_price']%>" /></td>
						<td><input class="tiny" name="_weight[<%=i%>]" type="text" pattern="float" empty value="<%=item['weight']%>" /></td>
						<%if(isProduct == true){%>
						<td><a href="javascript:void(0)" onclick="delProduct(this);"><img src="<?php echo $this->getWebSkinPath()."images/main/icn_trash.png";?>" alt="删除" /></a></td>
						<%}%>
					</tr>
					<%i++;%>
					<%}%>
					</script>
				</table>
			</fieldset>

			<fieldset>
				<label>商品模型</label>
				<select name="model_id" onchange="create_attr(this.value)">
					<option value="0">通用类型 </option>
					<?php $query = new IQuery("model");$items = $query->find(); foreach($items as $key => $item){?>
					<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></option>
					<?php }?>
				</select>
			</fieldset>

			<fieldset id="properties" style="display:none">
				<label>扩展属性</label>
				<table class="tablesorter clear" id="propert_table">
				</table>

				<!--商品属性模板 开始-->
				<script type='text/html' id='propertiesTemplate'>
				<%for(var item in templateData){%>
				<%item = templateData[item]%>
				<%var valueItems = item['value'].split(',');%>
				<tr>
					<td>
						<%=item["name"]%>：
						<%if(item['type'] == 1){%>
							<%for(var tempVal in valueItems){%>
							<%tempVal = valueItems[tempVal]%>
								<input type="radio" name="attr_id_<%=item['id']%>" value="<%=tempVal%>" /><%=tempVal%>
							<%}%>
						<%}else if(item['type'] == 2){%>
							<%for(var tempVal in valueItems){%>
							<%tempVal = valueItems[tempVal]%>
								<input type="checkbox" name="attr_id_<%=item['id']%>[]" value="<%=tempVal%>"/><%=tempVal%>
							<%}%>
						<%}else if(item['type'] == 3){%>
							<select name="attr_id_<%=item['id']%>">
							<%for(var tempVal in valueItems){%>
							<%tempVal = valueItems[tempVal]%>
							<option value="<%=tempVal%>"><%=tempVal%></option>
							<%}%>
							</select>
						<%}else if(item['type'] == 4){%>
							<input type="text" name="attr_id_<%=item['id']%>" value="<%=item['value']%>" class="small" />
						<%}%>
					</td>
				</tr>
				<%}%>
				</script>
				<!--商品属性模板 结束-->
			</fieldset>

			<fieldset>
				<label>规格</label>
				<div class="box">
					<input type="button" onclick="selSpec()" value="添加规格" />
				</div>
			</fieldset>

			<fieldset>
				<label>商品品牌</label>
				<select name="brand_id">
					<option value="0">请选择</option>
					<?php $query = new IQuery("brand");$items = $query->find(); foreach($items as $key => $item){?>
					<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></option>
					<?php }?>
				</select>
			</fieldset>

			<fieldset>
				<label>商品状态</label>
				<div class="box">
					<input type='radio' name='is_del' value='3' checked="checked" />申请上架
					<input type='radio' name='is_del' value='2' />下架
				</div>
			</fieldset>

			<fieldset>
				<label>产品相册</label>
				<div class="box">
					<input id="fileUpload" type="file" style="width:70px;" accept="image/png,image/gif,image/jpeg" name="_goodsFile" multiple="multiple" data-url="<?php echo IUrl::creatUrl("/goods/goods_img_upload/seller_id/".$seller_id."");?>" />
				</div>
				<label class="tip" id="uploadPercent">可以上传多张图片，分辨率3000px以下，大小不得超过<?php echo IUpload::getMaxSize();?></label>
				<div class="box" id="thumbnails"></div>
				<!--图片模板-->
				<script type='text/html' id='picTemplate'>
				<span class='pic'>
					<img name="picThumb" onclick="defaultImage(this);" style="margin:5px; opacity:1;width:100px;height:100px" src="<?php echo IUrl::creatUrl("")."<%=picRoot%>";?>" alt="<%=picRoot%>" />
					<p>
						<a class='orange' href='javascript:void(0)' onclick="$(this).parents('.pic').insertBefore($(this).parents('.pic').prev());"><img src="<?php echo $this->getWebSkinPath()."images/main/arrow_left.png";?>" title="左移动" alt="左移动" /></a>
						<a class='orange' href='javascript:void(0)' onclick="$(this).parents('.pic').remove();"><img src="<?php echo $this->getWebSkinPath()."images/main/sign_cacel.png";?>" title="删除" alt="删除" /></a>
						<a class='orange' href='javascript:void(0)' onclick="$(this).parents('.pic').insertAfter($(this).parents('.pic').next());"><img src="<?php echo $this->getWebSkinPath()."images/main/arrow_right.png";?>" title="右移动" alt="右移动" /></a>
					</p>
				</span>
				</script>
			</fieldset>
		</div>
		<!--商品信息 结束-->

		<!--商品描述 开始-->
		<div class="module_content" id="table_box_2" style="display:none;">
			<fieldset>
				<label>产品描述</label>
				<div class="clear" style="width:98%;margin:10px 10px;">
					<textarea id="content" name="content" style="width:100%;height:400px;"></textarea>
				</div>
			</fieldset>
		</div>
		<!--商品描述 结束-->

		<!--SEO 开始-->
		<div class="module_content" id="table_box_3" style="display:none;">
			<fieldset>
				<label>SEO关键词</label>
				<input name="keywords" type="text" value="" />
			</fieldset>

			<fieldset>
				<label>SEO描述</label>
				<textarea name="description" style="height:200px;"></textarea>
			</fieldset>
		</div>
		<!--SEO 结束-->

		<footer>
			<div class="submit_link">
				<input type="submit" class="alt_btn" value="确 定" onclick="return checkForm()" />
				<input type="reset" value="重 置" />
			</div>
		</footer>
	</form>

</article>

<script language="javascript">
//创建表单实例
var formObj = new Form('goodsForm');

//默认货号
var defaultProductNo = '<?php echo goods_class::createGoodsNo();?>';

$(function()
{
	//商品图片的回填
	<?php if(isset($goods_photo)){?>
	var goodsPhoto = <?php echo JSON::encode($goods_photo);?>;
	for(var item in goodsPhoto)
	{
		var picHtml = template.render('picTemplate',{'picRoot':goodsPhoto[item].img});
		$('#thumbnails').append(picHtml);
	}
	<?php }?>

	//商品默认图片
	<?php if(isset($form['img']) && $form['img']){?>
	$('#thumbnails img[name="picThumb"][alt="<?php echo $form['img'];?>"]').addClass('current');
	<?php }?>

	initProductTable();

	//存在商品信息
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
	var spec_array = <?php echo $product[0]['spec_array'];?>;
	var product    = <?php echo JSON::encode($product);?>;

	var goodsHeadHtml = template.render('goodsHeadTemplate',{'templateData':spec_array});
	$('#goodsBaseHead').html(goodsHeadHtml);

	var goodsRowHtml = template.render('goodsRowTemplate',{'templateData':product});
	$('#goodsBaseBody').html(goodsRowHtml);
	<?php }?>

	//编辑器载入
	KindEditorObj = KindEditor.create('#content',{"filterMode":false});

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
});

//初始化货品表格
function initProductTable()
{
	//默认产生一条商品标题空挡
	var goodsHeadHtml = template.render('goodsHeadTemplate',{'templateData':[]});
	$('#goodsBaseHead').html(goodsHeadHtml);

	//默认产生一条商品空挡
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
	//整理商品图片
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
	$("ul[name=menu1] > li").removeClass('active');
	$('#li_'+curr_tab).addClass('active');
}

//添加规格
function selSpec()
{
	//货品是否已经存在
	var tempUrl  = $('input:hidden[name^="_spec_array"]').length > 0 ? '<?php echo IUrl::creatUrl("/goods/search_spec/seller_id/@seller_id@");?>' : '<?php echo IUrl::creatUrl("/goods/search_spec/model_id/@model_id@/goods_id/@goods_id@/seller_id/@seller_id@");?>';
	var model_id = $('[name="model_id"]').val();
	var goods_id = $('[name="id"]').val();
	var seller_id= <?php echo isset($seller_id)?$seller_id:"";?>;

	tempUrl = tempUrl.replace('@model_id@',model_id);
	tempUrl = tempUrl.replace('@goods_id@',goods_id);
	tempUrl = tempUrl.replace('@seller_id@',seller_id);

	art.dialog.open(tempUrl,{
		title:'设置商品的规格',
		okVal:'保存',
		ok:function(iframeWin, topWin)
		{
			//添加的规格
			var addSpecObject = $(iframeWin.document).find('[id^="vertical_"]');
			if(addSpecObject.length == 0)
			{
				return;
			}

			var specIsHere    = getIsHereSpec();
			var specValueData = specIsHere.specValueData;
			var specData      = specIsHere.specData;

			//追加新建规格
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
	$.getJSON("<?php echo IUrl::creatUrl("/block/attribute_init");?>",{'model_id':model_id}, function(json)
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
			<?php $attrArray[] = '"attr_id_'.$key.'[]":"'.join(";",$valArray).'"'?>
			<?php $attrArray[] = '"attr_id_'.$key.'":"'.join(";",$valArray).'"'?>
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
 * 设置商品默认图片
 */
function defaultImage(_self)
{
	$('#thumbnails img[name="picThumb"]').removeClass('current');
	$(_self).addClass('current');
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
		alert('请先设置商品的价格再设置会员价格');
		return;
	}

	var groupPriceValue = $(obj).siblings('input[name^="_groupPrice"]');

	//用户组的价格
	art.dialog.data('groupPrice',groupPriceValue.val());

	//开启新页面
	var tempUrl = '<?php echo IUrl::creatUrl("/goods/member_price/sell_price/@sell_price@/seller_id/".$seller_id."");?>';
	tempUrl = tempUrl.replace('@sell_price@',sellPrice);
	art.dialog.open(tempUrl,{
		id:'memberPriceWindow',
	    title: '此商品对于会员组价格',
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

//删除规格
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

	//当前已经存在的规格数据
	var specIsHere = getIsHereSpec();
	createProductList(specIsHere.specData,specIsHere.specValueData);
}

//获取已经存在的规格
function getIsHereSpec()
{
	//开始遍历规格
	var specValueData = {};
	var specData      = {};

	//规格已经存在的数据
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

			if(jQuery.inArray(json['value'],specValueData[json.id]) == -1)
			{
				specValueData[json.id].push({"tip":json.tip,"value":json.value});
			}
		});
	}
	return {"specData":specData,"specValueData":specValueData};
}

/**
 * @brief 根据规格数据生成货品序列
 * @param object specData规格数据对象
 * @param object specValueData 规格值对象集合
 */
function createProductList(specData,specValueData)
{
	//生成货品的笛卡尔积
	var specMaxData = descartes(specValueData,specData);

	//生成最终的货品数据
	var productList = [];
	for(var i = 0;i < specMaxData.length;i++)
	{
		//从表单中获取默认商品数据
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

	//创建规格标题
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