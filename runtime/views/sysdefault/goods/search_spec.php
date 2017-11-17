<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理后台</title>
<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/admin.css";?>" />
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/admin.js";?>"></script>
<?php $dev = IClient::getDevice()?>
<?php if($dev == 'pc'){?><style>body{width:695px;overflow-y: hidden;}</style><?php }?>
</head>

<body style="overflow-x: auto;min-height: 400px;">
<div class="pop_win">
	<p>
		<button type="button" class="btn f_r" onclick="addSpec()"><span class="add">增加价格选项</span></button>
		1、增加价格选项或选择价格标签 >> 2、添加需要值 >> 保存
	</p>

	<!--价格选项按钮-->
	<ul class="tab"></ul>

	<!--价格选项标签按钮-->
	<script type='text/html' id='specButtonTemplate'>
		<%for(var item in templateData){%>
			<%include('specButtonLiTemplate',{'item':templateData[item]})%>
		<%}%>
	</script>

	<!--价格选项标签按钮-->
	<script type='text/html' id='specButtonLiTemplate'>
		<li id="specButton<%=item['id']%>">
			<a href="javascript:void(0);" style="display:inline;" onclick="selectTab(<%=item['id']%>);" hidefocus="true"><%=item['name']%></a>
			<label class="radio"><img src="<?php echo $this->getWebSkinPath()."images/admin/icon_del.gif";?>" class="delete" title="删除" onclick="delSpec(<%=item['id']%>,this);" /></label>
		</li>
	</script>

	<table class="spec" width="95%" cellspacing="0" cellpadding="0" border="0">

		<!--全部的价格选项,水平样式价格选项-->
		<tr>
			<td id="horizontalBox"></td>

			<!--水平价格选项列表-->
			<script type='text/html' id='horizontalSpecTemplate'>
			<%for(var item in templateData){%>
				<%include('horizonalSpecDlTemplate',{'item':templateData[item]})%>
			<%}%>
			</script>

			<!--水平价格选项单行-->
			<script type='text/html' id='horizonalSpecDlTemplate'>
			<%var className = item['type']==1 ? 'w_27':'w_45'%>
			<dl class="summary clearfix" id="horizontal_<%=item['id']%>" style='display:none'>
				<dt><label class="red">点击选择</label>下列《<%=item['name']%>》：如果没有您需要的《<%=item['name']%>》？请到价格选项列表中编辑<%=item['name']%></dt>
				<dd class="<%=className%>">
					<%var valueList = JSON().parse(item['value']);%>
					<%for(var result in valueList){%>
					<%item['value'] = valueList[result];%>
					<%item['tip']   = result;%>
					<div class="item">
						<a href="javascript:selectSpec(<%=JSON().stringify(item)%>);">
						<%if(item['type']==1){%>
							<%=item['value']%>
						<%}else{%>
							<img src="<?php echo IUrl::creatUrl("")."";?><%=item['value']%>" width="30px" height="30px"/>
						<%}%>
						</a>
					</div>
					<%}%>
				</dd>
			</dl>
			</script>
		</tr>

		<!--已存在的价格选项,垂直样式价格选项-->
		<tr>
			<td>
				<div class="cont" id="verticalBox" style='display:none'>
					<table class="border_table" width="100%" style="margin-top:0px;">
						<thead>
							<tr>
								<th>价格选项值</th>
								<th>操作</th>
							</tr>
						</thead>

						<!--垂直价格选项列表-->
						<script type='text/html' id='verticalSpecTemplate'>
						<%for(var item in templateData){%>
						<tbody id="vertical_<%=templateData[item]['id']%>">
							<%var specItem = {"id":templateData[item]['id'],"name":templateData[item]['name'],"type":templateData[item]['type']};%>
							<%for(var i in templateData[item]['value']){%>
								<%for(var tip in templateData[item]['value'][i]){%>
									<%specItem['value'] = templateData[item]['value'][i][tip];%>
									<%specItem['tip']   = tip;%>
								<%}%>
								<%include('verticalRowTemplate',{'specData':specItem})%>
							<%}%>
						</tbody>
						<%}%>
						</script>

						<!--垂直价格选项单行-->
						<script type='text/html' id='verticalRowTemplate'>
						<tr class='td_c'>
							<td>
								<input type="hidden" name="specJson" value='<%=JSON().stringify(specData)%>' />
								<%if(specData.type == 1){%><%=specData.value%><%}else{%><img width="30px" height="30px" src="<?php echo IUrl::creatUrl("")."<%=specData.value%>";?>" class="img_border" /><%}%>
							</td>
							<td>
								<img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_asc.gif";?>" onclick="positionUp(this);" alt="向上" />
								<img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_desc.gif";?>" onclick="positionDown(this);" alt="向下" />
								<img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_del.gif";?>" onclick="itemRemove(this);" alt="删除" />
							</td>
						</tr>
						</script>
					</table>
				</div>
			</td>
		</tr>
	</table>
</div>

<script language="javascript">
//DOM加载完毕
$(function()
{
	//价格选项按钮标签
	<?php if(isset($specData) && $specData){?>
	var specButtonHtml = template.render('specButtonTemplate',{'templateData':<?php echo JSON::encode($specData);?>});
	$('.tab').html(specButtonHtml);

	//价格选项垂直列表显示
	<?php if(isset($goodsSpec)){?>
	var verticalSpecHtml = template.render('verticalSpecTemplate',{'templateData':<?php echo JSON::encode($goodsSpec);?>});
	$('#verticalBox .border_table').append(verticalSpecHtml);
	<?php }?>

	//价格选项水平列表展示
	var horizontalSpecHtml = template.render('horizontalSpecTemplate',{'templateData':<?php echo JSON::encode($specData);?>});
	$('#horizontalBox').html(horizontalSpecHtml);
	<?php }?>

	//默认激活一个价格选项按钮
	defaultHoverSpecButton();
});

/**
 * 从已有的价格选项进行点选
 * @param specJson js对象 id,name,value,type
 */
function selectSpec(specJson)
{
	$('#verticalBox').show();

	//某价格选项小容器是否存在
	var specTbody = $('#vertical_'+specJson.id);
	if(specTbody.length == 0)
	{
		var valueObj = {};
		valueObj[specJson.tip] = specJson.value;
		specJson.value = [valueObj];
		var verticalSpecHtml = template.render('verticalSpecTemplate',{'templateData':[specJson]});
		$('#verticalBox .border_table').append(verticalSpecHtml);
	}
	else
	{
		isAdd = false;
		$('input:hidden[name="specJson"]').each(function()
		{
			if(JSON.parse($(this).val()).value == specJson.value)
			{
				isAdd = true;
				return;
			}
		});
		if(isAdd == true)
		{
			alert('此价格选项值已经添加过了');
			return;
		}
		var verticalRowHtml = template.render('verticalRowTemplate',{'specData':specJson});
		specTbody.append(verticalRowHtml);
	}
	$('#vertical_'+specJson.id).show();
}

/**
 * 选择当前Tab
 * @param spec_id 价格选项ID
 * @param _self 按钮本身
 */
function delSpec(spect_id,_self)
{
	art.dialog.confirm('确定要删除么？',function(){
		//移除tab价格选项标签按钮
		$(_self).parent().parent().remove();

		//移除水平价格选项
		$('#horizontal_'+spect_id).remove();

		//移除垂直价格选项
		$('#vertical_'+spect_id).remove();

		defaultHoverSpecButton();
	});
}

//默认激活价格选项按钮
function defaultHoverSpecButton()
{
	//已经没有待选择价格选项
	if($('.tab>li').length == 0)
	{
		$('#verticalBox').hide();
	}
	else
	{
		//默认激活第一个价格选项
		$('.tab>li:first a').trigger('click');
	}
}

//添加模型价格选项
function addSpec()
{
	<?php $seller_id = IFilter::act(IReq::get('seller_id'))?>
	art.dialog.open('<?php echo IUrl::creatUrl("/goods/select_spec/seller_id/".$seller_id."");?>', {
		title: '选择价格选项',
		okVal:'保存',
		<?php if(IClient::getDevice() == 'mobile'){?>
		width:'96%',
		<?php }?>
		ok:function(iframeWin, topWin){
			var specChecked = $(iframeWin.document).find('[name="spec"]:checked');
			if(specChecked.length == 1)
			{
				var specJson = $.parseJSON(specChecked.val());

				//监测价格选项是否已经存在
				if($('#horizontal_'+specJson.id).length > 0)
				{
					alert('价格选项已经被添加，不能重复添加');
					return false;
				}

				//价格选项按钮标签
				var specButtonLiHtml = template.render('specButtonLiTemplate',{'item':specJson});
				$('.tab').append(specButtonLiHtml);

				//价格选项水平列表展示
				var horizonalSpecDlHtml = template.render('horizonalSpecDlTemplate',{'item':specJson});
				$('#horizontalBox').append(horizonalSpecDlHtml);

				//激活新添加的价格选项
				$('.tab>li:last a').trigger('click');
			}
		}
	});
}

/**
 * 选择当前Tab
 * @param spec_id 价格选项ID
 */
function selectTab(spec_id)
{
	//隐藏垂直价格选项外部
	if($('.tab>li').length == 0)
	{
		$('#verticalBox').hide();
	}
	else
	{
		$('#verticalBox').show();
	}

	//按钮高亮
	$('.tab>li').removeClass('selected');
	$('#specButton'+spec_id).addClass('selected');

	//水平价格选项展示
	$('[id^="horizontal_"]').hide();
	$('#horizontal_'+spec_id).show();

	//垂直价格选项展示
	$('[id^="vertical_"]').hide();
	$('#vertical_'+spec_id).show();
}

//项上升
function positionUp(_self)
{
	var _self     = $(_self).closest('tr');
	var container = _self.parent();

	var childrenIndex = container.children().index(_self);
	if(childrenIndex == 0)
	{
		return;
	}
	_self.insertBefore(container.children().get(childrenIndex-1));
}

//项下降
function positionDown(_self)
{
	var _self     = $(_self).closest('tr');
	var container = _self.parent();

	var childrenIndex = container.children().index(_self);
	if(childrenIndex == container.children().length - 1)
	{
		return;
	}
	_self.insertAfter(container.children().get(childrenIndex+1));
}

//项删除
function itemRemove(_self)
{
	var _self = $(_self).closest('tr');
	art.dialog.confirm('确定要删除么？',function(){_self.remove()});
}
</script>
</body>
</html>
