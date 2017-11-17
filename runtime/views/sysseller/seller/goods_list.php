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
			<p><strong>Copyright &copy; 2010-2017</strong></p>
			<p>Powered by <a href="http://www.dsanke.com">dsanke.com</a></p>
		</footer>
	</aside>
	<!--侧边栏菜单 结束-->

	<!--主体内容 开始-->
	<section id="main" class="column">
		<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<article class="module width_full">
	<header>
		<h3 class="tabs_involved">商品列表</h3>
		<ul class="tabs">
			<li><input type="button" class="alt_btn" onclick="filterResult();" value="检索" /></li>
			<li><input type="button" class="alt_btn" onclick="window.location.href='<?php echo IUrl::creatUrl("/seller/goods_edit");?>';" value="添加商品" /></li>
			<li><input type="button" class="alt_btn" onclick="selectAll('id[]');" value="全选" /></li>
			<li><input type="button" class="alt_btn" onclick="goods_del();" value="删除" /></li>
			<li><input type="button" class="alt_btn" onclick="goods_status(2);" value="下架" /></li>
			<li><input type="button" class="alt_btn" onclick="goods_status(3);" value="申请上架" /></li>
            <li><input type="button" class="alt_btn" onclick="goodsSetting();" value="批量设置" /></li>
			<li><input type="button" class="alt_btn" onclick="window.open('<?php echo IUrl::creatUrl("/seller/goods_report/?".$searchParam."");?>');" value="导出Excel" /></li>
		</ul>
	</header>

	<form action="<?php echo IUrl::creatUrl("/seller/goods_del");?>" method="post" name="goodsForm">
		<table class="tablesorter" cellspacing="0">
			<colgroup>
				<col width="25px" />
				<col />
				<col width="150px" />
				<col width="70px" />
				<col width="70px" />
				<col width="70px" />
				<col width="70px" />
				<col width="80px" />
			</colgroup>

			<thead>
				<tr>
					<th class="header"></th>
					<th class="header">商品名字</th>
					<th class="header">分类</th>
					<th class="header">销售价</th>
					<th class="header">库存</th>
					<th class="header">状态</th>
					<th class="header">排序</th>
					<th class="header">操作</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($this->goodHandle->find() as $key => $item){?>
				<tr>
					<td><input name="id[]" type="checkbox" value="<?php echo isset($item['id'])?$item['id']:"";?>" /></td>
					<td><img src='<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/100/h/100");?>' class="ico" /><a href="javascript:jumpUrl('<?php echo isset($item['is_del'])?$item['is_del']:"";?>','<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>')" title="<?php echo htmlspecialchars($item['name']);?>"><?php echo isset($item['name'])?$item['name']:"";?></a></td>
					<td>
						<?php $catName = array()?>
						<?php $query = new IQuery("category_extend as ce");$query->join = "left join category as cd on cd.id = ce.category_id";$query->fields = "cd.name";$query->where = "goods_id = $item[id]";$items = $query->find(); foreach($items as $key => $catData){?>
							<?php $catName[] = $catData['name']?>
						<?php }?>
						<?php echo join(',',$catName);?>
					</td>
					<td><?php echo isset($item['sell_price'])?$item['sell_price']:"";?></td>
					<td><?php echo isset($item['store_nums'])?$item['store_nums']:"";?></td>
					<td class="<?php echo $item['is_del']==0 ? "green":"red";?>"><?php echo goods_class::statusText($item['is_del']);?></td>
					<td><input class="tiny" type="text" value="<?php echo isset($item['sort'])?$item['sort']:"";?>" onchange="changeSort(<?php echo isset($item['id'])?$item['id']:"";?>,this);" /></td>
					<td>
						<a href="<?php echo IUrl::creatUrl("/seller/goods_edit/id/".$item['id']."");?>"><img src="<?php echo $this->getWebSkinPath()."images/main/icn_edit.png";?>" title="编辑" /></a>
						<a href="javascript:delModel({link:'<?php echo IUrl::creatUrl("/seller/goods_del/id/".$item['id']."");?>'})"><img src="<?php echo $this->getWebSkinPath()."images/main/icn_del.png";?>" title="删除" /></a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</form>
	<?php echo $this->goodHandle->getPageBar();?>
</article>

<script type="text/html" id="filterTemplate">
<form action="<?php echo IUrl::creatUrl("/");?>" method="get" name="filterForm">
	<input type='hidden' name='controller' value='seller' />
	<input type='hidden' name='action' value='goods_list' />

	<div class="module_content">
		<fieldset>
		<label>商品名称</label>
		<input name="search[name]" value="" type="text" />

		<label>商品货号</label>
		<input name="search[goods_no]" value="" type="text" />

		<label>商品分类</label>
		<div class="box">
			<span id="__categoryBox" style="margin-bottom:8px"></span>
			<input type="button" class="alt_btn" name="_goodsCategoryButton" value="设置分类" />
		</div>

		<label>商品状态</label>
		<select name="search[is_del]">
			<option value="">不限</option>
			<option value="0">上架</option>
			<option value="2">下架</option>
			<option value="3">待审</option>
		</select>

		<label>商品库存</label>
		<select name="search[store_nums]">
			<option value="">选择库存</option>
			<option value="0">无货</option>
			<option value="1">低于10</option>
			<option value="2">10-100</option>
			<option value="3">100以上</option>
		</select>

		<label>商品品牌</label>
		<select name="search[brand_id]">
			<option value="">选择商品品牌</option>
			<?php $query = new IQuery("brand");$items = $query->find(); foreach($items as $key => $item){?>
			<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></option>
			<?php }?>
		</select>

		<label>商品价格</label>
		<div class="box">
			<input name="search[sell_price_start]" value="" type="text" class="small" /> ——
			<input name="search[sell_price_end]" value="" type="text" class="small" />
		</div>

		<label>创建时间</label>
		<div class="box">
			<input name="search[create_time_start]" value="" type="text" class="small" onfocus="WdatePicker()" /> ——
			<input name="search[create_time_end]" value="" type="text" class="small" onfocus="WdatePicker()" />
		</div>
		</fieldset>
	</div>
</form>
</script>
<?php plugin::trigger('goodsCategoryWidget',array("name" => "search[category_id]"))?>

<script type="text/javascript">
//检索商品
function filterResult()
{
	var goodsHeadHtml = template.render('filterTemplate');
	art.dialog(
	{
		"init":function()
		{
			var filterPost = <?php echo JSON::encode(IReq::get('search'));?>;
			var formObj = new Form('filterForm');
			for(var index in filterPost)
			{
				formObj.setValue("search["+index+"]",filterPost[index]);
			}
		},
		"title":"检索条件",
		"content":goodsHeadHtml,
		"okVal":"立即检索",
		"ok":function(iframeWin, topWin)
		{
			iframeWin.document.forms[0].submit();
		}
	});
}

//删除
function goods_del()
{
	var checkNum = $('input:checkbox[name="id[]"]:checked').length;
	if(checkNum > 0)
	{
		$("form[name='goodsForm']").attr('action',"<?php echo IUrl::creatUrl("/seller/goods_del");?>");
		confirm('确定要删除所选中的商品吗？','formSubmit(\'goodsForm\')');
	}
	else
	{
		alert('请选择要删除的商品');
		return false;
	}
}

//商品状态修改
function goods_status(is_del)
{
	var checkNum = $('input:checkbox[name="id[]"]:checked').length;
	if(checkNum > 0)
	{
		var postUrl = "<?php echo IUrl::creatUrl("/seller/goods_status/is_del/@is_del@");?>";
		postUrl = postUrl.replace("@is_del@",is_del);
		$("form[name='goodsForm']").attr('action',postUrl);
		confirm('确定要修改所选中的商品吗？','formSubmit(\'goodsForm\')');
	}
	else
	{
		alert('请选择要修改的商品');
		return false;
	}
}

//修改排序
function changeSort(gid,obj)
{
	var selectedValue = obj.value;
	$.getJSON("<?php echo IUrl::creatUrl("/seller/ajax_sort");?>",{"id":gid,"sort":selectedValue});
}

//商品详情的跳转连接
function jumpUrl(is_del,url)
{
	is_del == 0 ? window.open(url) : alert("该商品没有上架无法查看");
}

//upload csv file callback
function artDialogCallback(message)
{
	message ? alert(message) : window.location.reload();
}

// 商品批量设置
function goodsSetting()
{
	if($('input:checkbox[name="id[]"]:checked').length > 0)
	{
		var idArray = [];
		var idString = '';
		$('input:checkbox[name="id[]"]:checked').each(function(i)
		{
			idArray.push(this.value);
		});
		idString = idArray.join(',');

		var urlVal = "<?php echo IUrl::creatUrl("/goods/goods_setting/id/@id@/seller_id/@seller_id@");?>";
		urlVal = urlVal.replace("@id@",idString).replace("@seller_id@","<?php echo isset($this->seller['seller_id'])?$this->seller['seller_id']:"";?>");
		art.dialog.open(urlVal,{
			id:'goods_setting',
			title:'商品批量设置',
			okVal:'保存设置',
			ok:function(iframeWin, topWin){
				var formObject = iframeWin.document.forms[0];
				if(formObject.onsubmit() == false)
				{
					return false;
				}
				loadding();
				formObject.submit();
				return false;
			}
		});
	}
	else
	{
		alert("请选择您要操作的商品");
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