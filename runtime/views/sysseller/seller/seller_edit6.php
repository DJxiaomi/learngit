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
		<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/areaSelect/areaSelect.js"></script>
<article class="module width_full">
	<header>
		<h3>认证信息</h3>
	</header>

	<form action="<?php echo IUrl::creatUrl("/seller/seller_add6");?>" method="post" name="sellerForm" enctype='multipart/form-data'>
		<div class="module_content">
					<fieldset>
					<label>商户真实全称：</label>
						<td><input class="normal" name="true_name" type="text" value="" pattern="required" /></td>
					</fieldset>
					<fieldset>
						<label>营业执照号码：</label>
						<td><input class="normal" name="papersn" type="text" value="" /></td>
					</fieldset> 
					<fieldset>
						<label>营业执照：</label>
						<td>
							<input type='file' name='paper_img' />
							<?php if(isset($this->sellerRow['paper_img']) && $this->sellerRow['paper_img']){?>
							<p><a target="_blank" href="<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->sellerRow['paper_img'])?$this->sellerRow['paper_img']:"";?>"><img src='<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->sellerRow['paper_img'])?$this->sellerRow['paper_img']:"";?>' style='width:320px;border:1px solid #ccc' /></a></p>
							<?php }?>
						</td>
					</fieldset>

					<fieldset>
						<label>法人代表姓名：</label>
						<td><input type="text" class="normal" name="legal" value="<?php echo isset($this->sellerRow['legal'])?$this->sellerRow['legal']:"";?>" /></td>
					</fieldset>
					<fieldset>
						<label>法人身份证号码：</label>
						<td><input type="text" class="normal" name="cardsn" value="<?php echo isset($this->sellerRow['cardsn'])?$this->sellerRow['cardsn']:"";?>" /></td>
					</fieldset>
					<fieldset>
						<label>法人身份证正面：</label>
						<td>
							<input type='file' name='upphoto' />
							<?php if(isset($this->sellerRow['upphoto']) && $this->sellerRow['upphoto']){?>
							<p><a target="_blank" href="<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->sellerRow['upphoto'])?$this->sellerRow['upphoto']:"";?>"><img src='<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->sellerRow['upphoto'])?$this->sellerRow['upphoto']:"";?>' style='width:320px;border:1px solid #ccc' /></a></p>
							<?php }?>
						</td>
					</fieldset>
					<fieldset>
						<label>法人身份证背面：</label>
						<td>
							<input type='file' name='downphoto' />
							<?php if(isset($this->sellerRow['downphoto']) && $this->sellerRow['downphoto']){?>
							<p><a target="_blank" href="<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->sellerRow['downphoto'])?$this->sellerRow['downphoto']:"";?>"><img src='<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->sellerRow['downphoto'])?$this->sellerRow['downphoto']:"";?>' style='width:320px;border:1px solid #ccc' /></a></p>
							<?php }?>
						</td>
					</fieldset>

					<fieldset>
						<label>安全手机号码：</label>
                              <td><input type="text" class="normal" name="safe_mobile" value="<?php echo isset($this->sellerRow['safe_mobile'])?$this->sellerRow['safe_mobile']:"";?> "/>修改认证信息、结算账户、接收信息手机</td>
			        </fieldset>		
					<fieldset>
						<label>联系人：</label>
						<td><input type="text" class="normal" name="contacter" value="<?php echo isset($this->sellerRow['contacter'])?$this->sellerRow['contacter']:"";?>" /></td>
					</fieldset>
					<fieldset>
						<label>联系人身份证号码：</label>
						<td><input type="text" class="normal" name="contactcardsn" value="<?php echo isset($this->sellerRow['contactcardsn'])?$this->sellerRow['contactcardsn']:"";?>" /></td>
					</fieldset>
					<fieldset>
						<label>联系人身份证正面：</label>
						<td>
							<input type='file' name='cupphoto' />
							<?php if(isset($this->sellerRow['cupphoto']) && $this->sellerRow['cupphoto']){?>
							<p><a target="_blank" href="<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->sellerRow['cupphoto'])?$this->sellerRow['cupphoto']:"";?>"><img src='<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->sellerRow['cupphoto'])?$this->sellerRow['cupphoto']:"";?>' style='width:320px;border:1px solid #ccc' /></a></p>
							<?php }?>
						</td>
					</fieldset>
					<fieldset>
						<label>联系人身份证背面：</label>
						<td>
							<input type='file' name='cdownphoto' />
							<?php if(isset($this->sellerRow['cdownphoto']) && $this->sellerRow['cdownphoto']){?>
							<p><a target="_blank" href="<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->sellerRow['cdownphoto'])?$this->sellerRow['cdownphoto']:"";?>"><img src='<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->sellerRow['cdownphoto'])?$this->sellerRow['cdownphoto']:"";?>' style='width:320px;border:1px solid #ccc' /></a></p>
							<?php }?>
						</td>
					</fieldset>

					<fieldset>
						<td></td><td><button class="submit" type="submit"><span>提交认证</span></button></td>
					</fieldset>
	        </div>
		</form>

</article>
<script language="javascript">
//DOM加载完毕
$(function()
{
//修改模式
<?php if($this->sellerRow){?>
var formObj = new Form('sellerForm');
formObj.init(<?php echo JSON::encode($this->sellerRow);?>);

//锁定字段一旦注册无法修改
if($('[name="id"]').val())
{
	var lockCols = ['seller_name'];
	for(var index in lockCols)
	{
		$('input:text[name="'+lockCols[index]+'"]').addClass('readonly');
		$('input:text[name="'+lockCols[index]+'"]').attr('readonly',true);
	}
}
<?php }?>

//地区联动插件
var areaInstance = new areaSelect('province');
areaInstance.init(<?php echo JSON::encode($this->sellerRow);?>);
});

function getAu(obj){
	if($(obj).val() == 2){
		$('#authorization').show();
	}else{
		$('#authorization').hide();
	}
}

function getBank(obj){
	if($(obj).val() == 1){
		$('#bank').show();
		$('#alipay').hide();
	}else if($(obj).val() == 2){
		$('#bank').hide();
		$('#alipay').show();
	}else{
		return;
	}
}

var default_time = 60;
var s_count = 60;
var send_status = true;

//发送短信码
function sendMessage()
{
	var username = $('#mobileWay [name="username"]').val();
	var mobile   = $('#mobileWay [name="mobile"]').val();
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;

	if ( username == '' )
	{
		$('#mobileWay').submit();
		return false;
	}
	if(!myreg.test(mobile))
	{
		$('#mobileWay').submit();
		return false;
	}

	if ( s_count == default_time && send_status )
	{
		$.get("<?php echo IUrl::creatUrl("/simple/send_reg_sms");?>",{"mobile":mobile,"type":2},function(content){
			if(content == 'success')
			{
				update_sms_status();
				time = setInterval(function(){
					update_sms_status();
				}, 1000);
				$('#mobileWay .send_sms').addClass('disable');
				$('.form_table .send_sms_notice').show();
			}
			else
			{
				alert(content);
				return;
			}
		});
	}
}

function update_sms_status()
{
	if ( s_count > 0 )
	{
		s_count--;
		send_status = false;
		$('#mobileWay .send_sms').attr('disabled',"true");
		$('#mobileWay .send_sms').val('重新发送验证码(' + s_count + ' s)');
		$('#mobileWay .send_sms').css('cursor', 'wait');
	} else {
		s_count = default_time;
		send_status = true;
		clearInterval(time);

		$('#mobileWay .send_sms').val('重新发送验证码');
		$('#mobileWay .send_sms').removeAttr("disabled");
		$('#mobileWay .send_sms').removeClass('disable');
		$('#mobileWay .send_sms').css('cursor', 'pointer');
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