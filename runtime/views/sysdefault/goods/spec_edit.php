<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>价格选项修改</title>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/admin.css";?>" />
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/admin.js";?>"></script>
</head>
<?php $dev = IClient::getDevice()?>

<style>
<?php if($dev == 'mobile'){?>
.small{width:50px;}
body{width:700px;}
<?php }else{?>
body{width:500px;}
overflow-y: hidden;
<?php }?>
</style>

<body style="min-height: 400px;">
<div class="pop_win">
	<form action='<?php echo IUrl::creatUrl("/goods/spec_update");?>' method='post' id='specForm' name='specForm'>
		<input type="hidden" name="seller_id" value="<?php echo isset($seller_id)?$seller_id:"";?>" />
		<input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>" />
		<table class="form_table">
			<col width="70">
			<tr>
				<td>价格选项名称：</td>
				<td><input class="small" name="name" value="<?php echo isset($name)?$name:"";?>" type="text" pattern="required" alt="名字不能为空" /><label>* 价格选项名称（必填）</label></td>
			</tr>
			<tr>
				<td>显示类型：</td>
				<td>
					<label class="attr"><input name="type" type="radio" value="1" <?php if($type==1 || $type==null){?>checked=checked<?php }?> onchange="changeType();" />文字</label>
					<label class="attr"><input name="type" type="radio" value="2" <?php if($type==2){?>checked=checked<?php }?> onchange="changeType();" />图片</label>
				</td>
			</tr>
			<tr>
				<td>说明：</td>
				<td><input class="small" type="text" name="note" value="<?php echo isset($note)?$note:"";?>" /></td>
			</tr>
			<tr>
				<td></td>
				<td><button type="button" class="btn" onclick="addSpec();"><span class="add">添加价格选项</span></button></td>
			</tr>
			<tr>
				<td colspan="2">
					<table class='border_table' cellpadding="0" cellspacing="0" width='100%'>
						<thead>
							<tr>
								<th>价格选项</th>
								<th><?php if($dev=="pc"){?>提示信息(不可重复)<?php }else{?>提示,不可重复<?php }?></th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody id='spec_box'></tbody>
					</table>
				</td>
			</tr>
		</table>
	</form>
</div>

<!--价格选项模板-->
<script id="specTemplate" type='text/html'>
<tr class='td_c'>
	<td>
		<%var textType = type == 1 ? "show":"none";%>
		<%var imgType  = type == 2 ? "show":"none";%>

		<input style="display:<%=textType%>;" type="text" class="small" name="showText[]" value="<%if(type == 1){%><%=show%><%}%>" pattern="required" />

		<div style="display:<%=imgType%>" name="imageBox">
			<div class="imgbox"><img class="img_border" src='<%if(type == 2){%><?php echo IUrl::creatUrl("")."<%=show%>";?><%}%>' width='50px' height='50px' <%if(!show || type != 2){%>style="display:none;"<%}%> /></div>
			<input type="hidden" name="showImage[]" value="<%if(type == 2){%><%=show%><%}%>" />
			<button type="button" class="btn" onclick="photoUpload(this);"><span>选择图片</span></button>
		</div>
	</td>
	<td>
		<input type="text" class="small" name="valueData[]" value="<%=value%>" pattern="required" />
	</td>
	<td>
		<img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_asc.gif";?>" alt="向上" onclick="upChange(this);" />
		<img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_desc.gif";?>" alt="向下" onclick="downChange(this);" />
		<img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_del.gif";?>" alt="删除" onclick="delItem(this);" />
	</td>
</tr>
</script>

<script type='text/javascript'>
//页面加载
jQuery(function()
{
	var specValue = <?php echo $value ? $value : "[]";?>;
	for(var index in specValue)
	{
		var data = {"type":"<?php echo isset($type)?$type:"";?>","value":index,"show":specValue[index]};
		$('#spec_box').append(template('specTemplate', data));
	}
});
//切换价格选项方式
function changeType()
{
	$('[name="showText[]"]').toggle();
	$('[name="imageBox"]').toggle();
}

//向上移动
function upChange(_self)
{
	var toIndex = $(_self).closest("tr").prev().index();
	$('#spec_box tr:eq('+toIndex+')').before($(_self).closest("tr"));
}

//向下移动
function downChange(_self)
{
	var toIndex = $(_self).closest("tr").next().index();
	$('#spec_box tr:eq('+toIndex+')').after($(_self).closest("tr"));
}

//删除自身
function delItem(_self)
{
	art.dialog.confirm('确定要删除么？',function(){$(_self).closest('tr').remove();});
}

//添加规格数据
function addSpec()
{
	var type = $('[name="type"]:checked').val();
	var data = {"type":type};
	$('#spec_box').append(template('specTemplate', data));
}

//价格选项图片上传回调函数
function updatePic(indexValue,srcValue)
{
	var imageUrl = srcValue.indexOf("http") == 0 ? "@images@" : "<?php echo IUrl::creatUrl("")."@images@";?>";
	$('#spec_box tr:eq('+indexValue+')').find(".img_border").attr("src",imageUrl.replace("@images@",srcValue));
	$('#spec_box tr:eq('+indexValue+')').find(".img_border").show();
	$('#spec_box tr:eq('+indexValue+')').find("[name='showImage[]']").val(srcValue);
	art.dialog({id:'uploadIframe'}).close();
}

//上传按钮html
function photoUpload(_self)
{
	var specIndex = $(_self).closest("tr").index();
	var tempUrl = '<?php echo IUrl::creatUrl("/block/pic/specIndex/@specIndex@");?>';
	tempUrl     = tempUrl.replace('@specIndex@',specIndex);
	art.dialog.open(tempUrl,
	{
		'id':"uploadIframe",
		'title':'选择图片上传的方式',
		'ok':function(iframeWin, topWin)
		{
	    	iframeWin.document.forms[0].submit();
	    	return false;
		}
	});
}
</script>
</body>
</html>
