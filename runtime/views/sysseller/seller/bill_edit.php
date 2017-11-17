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
<?php $seller_id = $this->seller['seller_id']?>

<article class="module width_full">
	<header>
		<h3 class="tabs_involved">货款结算单编辑</h3>
	</header>

	<form action="<?php echo IUrl::creatUrl("/seller/bill_update");?>"  method="post" name="bill_edit">
		<input type='hidden' name='id' />
		<div class="module_content">
			<fieldset>
				<label>结算货款起止时间：</label>
				<div class="box">
					<input type='text' class="normal" name='start_time' readonly="readonly" pattern='date' onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" alt='请填写开始日期' title="请填写开始日期" />
					<input type='text' class="normal" name='end_time' readonly="readonly" pattern='date' onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" alt='请填写结束日期' title="请填写结束日期" />
					<input class="btn" type="button" value="点击计算结算明细" id="checkButton" onclick="checkoutFee();" />
				</div>

				<div class="box" style="padding-top:15px;">
					<textarea name="log" disabled="disabled"></textarea>
					<label class="tip">根据选择的日期系统会自动生成结算详情报告，商家必须发货且用户必须收货后才会有统计数据</label>
				</div>
			</fieldset>

			<fieldset>
				<label>申请结算附言：</label>
				<textarea name="apply_content"></textarea>
			</fieldset>

			<fieldset>
				<label>管理员回复：</label>
				<textarea name="pay_content" disabled="disabled"></textarea>
			</fieldset>
		</div>

		<footer>
			<div class="submit_link">
				<input type="submit" class="alt_btn" value="确 定" />
				<input type="reset" value="重 置" />
			</div>
		</footer>
	</form>
</article>

<script type="text/javascript">
//表单回填
var formObj = new Form('bill_edit');
formObj.init(<?php echo JSON::encode($this->billRow);?>);

//存在结算单数据就要锁定已有数据
<?php if($this->billRow){?>
$("[name='start_time']").prop("disabled",true);
$("[name='end_time']").prop("disabled",true);
$("#checkButton").hide();
<?php }?>

//计算结算款明细
function checkoutFee()
{
	var startTime = $("[name='start_time']").val();
	var endTime   = $("[name='end_time']").val();
	if(!startTime || !endTime)
	{
		alert("请填写完整的时间段");
		return;
	}

	$.getJSON("<?php echo IUrl::creatUrl("/seller/countGoodsFee");?>",{"start_time":startTime,"end_time":endTime}, function(json)
	{
		if(json.result == 'success')
		{
			$("[name='log']").val(json.data);
		}
		else
		{
			alert(json.data);
		}
	})
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