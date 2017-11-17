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
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/areaSelect/areaSelect.js"></script>

<div class="headbar">
	<div class="position"><span>会员</span><span>></span><span>商户管理</span><span>></span><span>商户认证信息</span></div>
</div>

<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/member/seller_add6");?>" method="post" name="sellerForm" enctype='multipart/form-data'>
			<table class="form_table" id="mobileWay">
				<colgroup>
					<col width="150px" />
					<col />
				</colgroup>
				<tbody>
					<tr>
						<th>商户名称：</th>
						<td>
							<select class="auto selectpicker show-tick form-control" name="seller_id" data-live-search="true">
								<option value="">请选择商户</option>
								<?php $query = new IQuery("seller");$query->where = "is_del = 0";$query->order = "id desc";$items = $query->find(); foreach($items as $key => $item){?>
								<option value="<?php echo isset($item['id'])?$item['id']:"";?>"<?php if($item['id'] == $this->sellerRow['id']){?> selected<?php }?>><?php echo isset($item['true_name'])?$item['true_name']:"";?>-<?php echo isset($item['seller_name'])?$item['seller_name']:"";?></option>
								<?php }?>
							</select>
						</td>
					</tr>
					<tr>
						<th>商户真实全称：</th>
						<td><input class="normal" name="true_name" type="text" value="" pattern="required" /></td>
					</tr>
					<tr>
						<th>营业执照号码：</th>
						<td><input class="normal" name="papersn" type="text" value="" /></td>
					</tr>
					<tr>
						<th>营业执照：</th>
						<td>
							<input type='file' name='paper_img' />
						</td>
					</tr>

					<tr>
						<th>法人代表姓名：</th>
						<td><input type="text" class="normal" name="legal" value="<?php echo isset($this->sellerRow['legal'])?$this->sellerRow['legal']:"";?>" /></td>
					</tr>
					<tr>
						<th>法人身份证号码：</th>
						<td><input type="text" class="normal" name="cardsn" value="<?php echo isset($this->sellerRow['cardsn'])?$this->sellerRow['cardsn']:"";?>" /></td>
					</tr>
					<tr>
						<th>法人身份证正面：</th>
						<td>
							<input type='file' name='upphoto' />
						</td>
					</tr>
					<tr>
						<th>法人身份证背面：</th>
						<td>
							<input type='file' name='downphoto' />
						</td>
					</tr>

					<tr>
						<th>安全手机号码：</th>
                              <td><input type="text" class="normal" name="safe_mobile" value="<?php echo isset($this->sellerRow['mobile'])?$this->sellerRow['mobile']:"";?> "/>修改认证信息、结算账户、接收信息手机</td>
			        </tr>
					<tr>
						<th>联系人：</th>
						<td><input type="text" class="normal" name="contacter" value="<?php echo isset($this->sellerRow['contacter'])?$this->sellerRow['contacter']:"";?>" /></td>
					</tr>
					<tr>
						<th>联系人身份证号码：</th>
						<td><input type="text" class="normal" name="contactcardsn" value="<?php echo isset($this->sellerRow['contactcardsn'])?$this->sellerRow['contactcardsn']:"";?>" /></td>
					</tr>
					<tr>
						<th>联系人身份证正面：</th>
						<td>
							<input type='file' name='cupphoto' />
						</td>
					</tr>
					<tr>
						<th>联系人身份证背面：</th>
						<td>
							<input type='file' name='cdownphoto' />
						</td>
					</tr>
					<tr>
						<th>登录密码：</th>
						<td><input class="normal" name="password" type="password" value="" />
							<label>*</label>
						</td>
					</tr>
					<tr>
						<th>取款密码：</th>
						<td><input class="normal" name="draw_password" type="password" value="" />
							<label>*</label>
						</td>
					</tr>
					<tr>
						<td></td><td><button class="submit" type="submit"><span>提交认证</span></button></td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>

<script language="javascript">
//DOM加载完毕
$(function()
{

$('select[name=seller_id]').change(function(){
	var seller_id = $(this).val();
	$.getJSON('<?php echo IUrl::creatUrl("/member/get_seller_info");?>',{seller_id:seller_id},function(res){
		if(res.status == 1){
			var data = res.data;
			$('input[name=true_name]').val(data.true_name);
			$('input[name=papersn]').val(data.papersn);
			$('input[name=legal]').val(data.legal);
			$('input[name=cardsn]').val(data.cardsn);
			$('input[name=safe_mobile]').val(data.safe_mobile);
			$('input[name=contacter]').val(data.contacter);
			$('input[name=contactcardsn]').val(data.contactcardsn);

			var str = '<p><a target="_blank" href="<?php echo IUrl::creatUrl("")."";?>%url%"><img src="<?php echo IUrl::creatUrl("")."";?>%url%" style="height:100px;border:1px solid #ccc" /></a></p>';
			if(data.paper_img){
				var p_str = str.replace(/%url%/g,data.paper_img);
				$('input[name=paper_img]').after(p_str);
			}
			if(data.upphoto){
				var p_str = str.replace(/%url%/g,data.upphoto);
				$('input[name=upphoto]').after(p_str);
			}
			if(data.downphoto){
				var p_str = str.replace(/%url%/g,data.downphoto);
				$('input[name=downphoto]').after(p_str);
			}
			if(data.cupphoto){
				var p_str = str.replace(/%url%/g,data.cupphoto);
				$('input[name=cupphoto]').after(p_str);
			}
			if(data.cdownphoto){
				var p_str = str.replace(/%url%/g,data.cdownphoto);
				$('input[name=cdownphoto]').after(p_str);
			}

		}
	})
})

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
