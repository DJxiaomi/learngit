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
		<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<article class="module width_full">
	<header>
		<h3 class="tabs_involved">编辑促销活动</h3>
	</header>

	<form action="<?php echo IUrl::creatUrl("/seller/pro_rule_edit_act");?>" method="post" name='pro_rule_edit'>
		<input type='hidden' name='id' />

		<div class="module_content">
			<fieldset>
				<label>活动名称</label>
				<input type='text' name='name' pattern='required' alt='请填写活动名称' />
				<label>* 填写活动名称</label>
			</fieldset>

			<fieldset>
				<label>活动时间</label>
				<div class="box">
					<input type='text' name='start_time' class='normal' pattern='datetime' onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"  alt='请填写一个日期' /> ～
					<input type='text' name='end_time' class='normal' pattern='datetime' onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" alt='请填写一个日期' />
					<label>* 此活动的使用时间段</label>
				</div>
			</fieldset>

			<fieldset>
				<label>允许参与人群</label>
				<div class="box">
					<ul class="attr_list">
						<li><label class='attr'><input type='checkbox' name='user_group' value='all' onclick='select_all();' />全部</label></li>
						<?php $query = new IQuery("user_group");$items = $query->find(); foreach($items as $key => $item){?>
						<li><label class='attr'><input type='checkbox' name='user_group[]' value='<?php echo isset($item['id'])?$item['id']:"";?>' /><?php echo isset($item['group_name'])?$item['group_name']:"";?></label></li>
						<?php }?>
					</ul>
					<label>* 此活动允许参加的用户组</label>
				</div>
			</fieldset>

			<fieldset>
				<label>是否开启</label>
				<div class="box">
					<label class='attr'><input type='radio' name='is_close' value='0' checked=checked />是</label>
					<label class='attr'><input type='radio' name='is_close' value='1' />否</label>
				</div>
			</fieldset>

			<fieldset>
				<label>活动介绍</label>
				<textarea name='intro' class='textarea'><?php echo isset($this->promotionRow['intro'])?$this->promotionRow['intro']:"";?></textarea>
			</fieldset>

			<fieldset>
				<label>购物车总金额条件</label>
				<input type='text' name='condition' pattern='float' class='small' alt='请填写一个金额数字' />元
				<label>* 当购物车总金额达到所填写的现金额度时规则生效</label>
			</fieldset>

			<fieldset>
				<label>活动规则</label>
				<select class='auto' name='award_type' pattern='required' alt='请选择一种规则' onchange="change_rule(this.value);">
					<option value=''>请选择</option>
					<option value='1'>当购物车金额满 M 元时,优惠 N 元</option>
					<option value='2'>当购物车金额满 M 元时,优惠 N% </option>
					<option value='6'>当购物车金额满 M 元时,免运费</option>
				</select>
				<label>* 选择一种活动规则</label>

				<div class="box" id='rule_box' style='margin-top:10px'></div>
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

<script type='text/javascript'>
//修改规则
function change_rule(selectVal)
{
	//判断是否为真正的onchange事件
	if(selectVal != $('#rule_box').data('index'))
	{
		$('#rule_box').data('index',selectVal);
	}
	else
	{
		return;
	}

	var html = '';
	switch(selectVal)
	{
		case "1":
		{
			html = "<label>优惠金额</label>"
					+"<input type='text' name='award_value' class='small' pattern='float' alt='请填写一个金额数字' />元"
					+"<label>* 优惠的金额，从购物车总金额中减掉此部分金额</label>";
		}
		break;

		case "2":
		{
			html = "<label>优惠百分比</label>"
					+"<input type='text' name='award_value' class='small' pattern='float' alt='请填写一个数字' />%"
					+"<label>* 优惠的百分比，从购物车总金额中的折扣百分比，如输入10则表示优惠10%</label>";
		}
		break;
	}
	$('#rule_box').html(html);
	formObj.setValue('award_value',"<?php echo isset($this->promotionRow['award_value'])?$this->promotionRow['award_value']:"";?>");
}

//选择参与人群
function select_all()
{
	var is_checked = $('[name="user_group"]').prop('checked');
	if(is_checked ==  "checked")
	{
		var checkedVal  = true;
		var disabledVal = true;
	}
	else
	{
		var checkedVal  = false;
		var disabledVal = false;
	}

	$('input:checkbox[name="user_group[]"]').each(
		function(i)
		{
			$(this).prop('checked',checkedVal);
			$(this).prop('disabled',disabledVal);
		}
	);
}

//表单回填
var formObj = new Form('pro_rule_edit');
formObj.init(<?php echo JSON::encode($this->promotionRow);?>);
change_rule("<?php echo isset($this->promotionRow['award_type'])?$this->promotionRow['award_type']:"";?>");

//根据默认值进行用户组选择
select_all();
var userGroup = "<?php echo trim($this->promotionRow['user_group'],',');?>";
if(userGroup)
{
	var userGroupArray = userGroup.split(',');
	for(var i in userGroupArray)
	{
		$('[name="user_group[]"][value="'+userGroupArray[i]+'"]').prop('checked',true);
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