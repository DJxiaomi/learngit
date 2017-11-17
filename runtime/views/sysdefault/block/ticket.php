<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>使用代金券</title>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
<style>
.__ticket {overflow-y: hidden;}
.__ticket,.__ticket * {padding: 0;margin: 0;list-style: none;font-size: 12px;}
.__ticket .__ticket_box {padding: 8px;max-height: 400px;min-height: 250px;overflow-y: auto;}
.__ticket .__ticket_box .mb10 {margin-bottom: 10px;}
.__ticket .__ticket_box .brs5 {border-radius: 5px;}
.__ticket .__ticket_box .hide {display: none;}
.__ticket .__ticket_box .__tip {padding: 10px;color: #886537;background: #FEF8E5;border: 1px solid #FCEBCC;}
.__ticket .__ticket_box .__canecl,.__ticket .__ticket_box .__add_ticket {
	border: 1px solid #DC3E3F;background: #E15253;color: #fff;display: block;width: 100%;height: 40px;cursor: pointer;line-height: 40px;text-align: center;
}
.__ticket .__ticket_box .__add_ticket {border: 1px solid #1E7EBA;background: #2F8BC7;}
.__ticket .__ticket_box .__ticket_list li label input {display: none;}
.__ticket .__ticket_box .__ticket_list li label span {
	border: 1px solid #ddd;background: #fafafa;color: #555;display: block;width: 100%;line-height: 20px;cursor: pointer;padding: 10px 0;text-indent: 10px;
}
.__ticket .__ticket_box .__ticket_list li label input:checked + span {border: 1px solid #3CAE53;background: #4FB862;color: #fff;}
.__ticket .__ticket_box .__add_ticket_box {position: fixed;left: 0;top: 0;right: 0;bottom: 0;background: #fff;padding:20px 8px 8px;overflow-y: auto;}
.__ticket .__ticket_box .__add_ticket_box li {margin-bottom: 20px;position: relative;}
.__ticket .__ticket_box .__add_ticket_box li span {
	position: absolute;height: 10px;line-height: 10px;background: #fff;top: -7px;padding: 0 10px;left: 5px;
	color: #999;font-size: 11px;z-index: 1;
}
.__ticket .__ticket_box .__add_ticket_box li .__text {
	display: block;width: 100%;height: 16px;line-height: 16px;border-radius: 0;padding: 10px 0;border: none;
	background: #fff;text-indent: 10px;box-shadow: 0 0 0 1px #ddd;
}
</style>
</head>

<body class="__ticket">
<div class="__ticket_box">
	<form action="#" method="post" name="ticketForm">
		<div class="__tip mb10 brs5">
			注：代金券仅能抵扣一个商家的商品金额
		</div>
		<div class="__ticket_list">
			<ul id="ticket_show_box"></ul>
		</div>
		<input type="button" onclick="cancel_ticket();" class="__canecl mb10 brs5" value="不用代金券" />

		<div class="__add_ticket brs5" onclick="$('#addbox').show()">添加代金券</div>
		<div class="__add_ticket_box hide" id="addbox">
			<ul>
				<li>
					<span>代金券卡号</span>
					<input type='text' class="__text" id='ticket_num' placeholder="卡号" />
				</li>
				<li>
					<span>代金券密码</span>
					<input type='password' class="__text" id='ticket_pwd' placeholder="密码" />
				</li>
				<li>
					<input type="button" class="__add_ticket brs5" onclick="add_ticket();" value="添加代金券" />
				</li>
				<li>
					<input type="button" class="__canecl brs5" onclick="$('#addbox').hide()" value="取消添加" />
				</li>
			</ul>
		</div>
	</form>
</div>
</body>

<!--代金券模板-->
<script type='text/html' id='ticketTrTemplate'>
<li class="mb10">
	<label>
		<input name="ticket_id" onclick="userTicket(<%=item.seller_id%>);" type="radio" value="<%=item.id%>" price="<%=item.value%>" seller="<%=item.seller_id%>" />
		<span class="brs5"><%=item.name%> 【<%=item.card_name%>】 【￥<%=item.value%>】</span>
	</label>
</li>
</script>

<script type='text/javascript'>
jQuery(function()
{
	<?php if($this->prop){?>
	<?php foreach($this->prop as $key => $item){?>
	var propItem = template.render("ticketTrTemplate",{"item":<?php echo JSON::encode($item);?>});
	$('#ticket_show_box').prepend(propItem);
	<?php }?>
	$('#ticket_show_box').show();
	<?php }?>
})

/**
 * @brief 选择代金券
 * @param seller_id int 商家ID
 */
function userTicket(seller_id)
{
	var sellerInfo = "<?php echo $this->sellerInfo;?>";
	var sellerArray= sellerInfo.split(",");

	if(jQuery.inArray(seller_id,sellerArray) !== -1 || seller_id == 0)
	{
		return true;
	}

	alert("该代金券不能用于此商家");
	$('[name="ticket_id"]').prop('checked',false);
	return false;
}

//取消红包
function cancel_ticket(){
	$('[name="ticket_id"]').prop('checked',false);
}

//添加代金券
function add_ticket()
{
	var ticket_num = $('#ticket_num').val();
	var ticket_pwd = $('#ticket_pwd').val();

	if(ticket_num == '' || ticket_pwd == '')
	{
		alert('请填写卡号和密码');
		return '';
	}

	$.getJSON("<?php echo IUrl::creatUrl("/block/add_download_ticket");?>",{"ticket_num":ticket_num,"ticket_pwd":ticket_pwd},function(content){
		if(content.isError == false)
		{
			if($('[name="ticket_id"][value="'+content.data.id+'"]').length > 0)
			{
				alert('代金券已经存在，不要重复添加');
				return;
			}

			var ticketHtml = template.render('ticketTrTemplate',{item:content.data});
			$('#ticket_show_box').prepend(ticketHtml);

			$('#ticket_show_box').show();
			$('[name="ticket_id"]').prop('checked',true);
			$('[name="ticket_id"]:first').trigger('click');

			$('#ticket_num').val('');
			$('#ticket_pwd').val('');
			$('#addbox').hide();
		}
		else
		{
			alert(content.message);
		}
	});
}
</script>
</html>
