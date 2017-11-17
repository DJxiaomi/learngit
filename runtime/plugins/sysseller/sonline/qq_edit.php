<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container">
<form action="<?php echo IUrl::creatUrl("".$submitUrl."");?>" method="post" name='service_online'>
	<table class='table'>
		<tr>
			<td>
				<table class='table' id='service_box'>
					<thead>
						<tr>
							<th>客服名称</th>
							<th>QQ号码</th>
							<th>操作</th>
						</tr>
					</thead>

					<tbody></tbody>

					<tfoot>
						<tr>
							<td colspan='3'>
								<button type='button' class='glyphicon glyphicon-plus btn btn-info' onclick="add_service();">添加客服项</button>
							</td>
						</tr>
					</tfoot>

					<script type='text/html' id='serviceTrTemplate'>
					<tr>
						<td><input type='text' name='service_name[]' class='form-control' value='<%=name%>' /></td>
						<td><input type='text' name='service_qq[]' class='form-control' value='<%=qq%>' /></td>
						<td>
							<button type="button" class='operator glyphicon glyphicon-arrow-up btn btn-default' alt='向上' title='向上'></button>
							<button type="button" class='operator glyphicon glyphicon-arrow-down btn btn-default' alt='向下' title='向下'></button>
							<button type="button" class='operator glyphicon glyphicon-remove btn btn-default' alt='删除' title='删除'></button>
						</td>
					</tr>
					</script>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" class="btn btn-success" value="保存客服" />
				<input type="button" class="btn btn-danger" value="取 消" onclick="art.dialog.close();" />
			</td>
		</tr>
	</table>
</form>
</div>
</body>

<script type="text/javascript">
//生成在线客服
<?php if(isset($qq) && $qq){?>
var serviceOnlineList = <?php echo JSON::encode($qq);?>;
for(var index in serviceOnlineList)
{
	add_service(serviceOnlineList[index]);
}
<?php }else{?>
	add_service();
<?php }?>

//添加客服
function add_service(data)
{
	var data = data ? data : {};
	var serviceTrHtml = template.render('serviceTrTemplate',data);
	$('#service_box tbody').append(serviceTrHtml);
	var last_index = $('#service_box tbody tr').size()-1;
	buttonInit(last_index,'#service_box');
}

//操作按钮绑定
function buttonInit(indexValue,ele)
{
	ele = ele || "#guide_box";
	if(indexValue == undefined || indexValue === '')
	{
		var button_times = $(ele+' tbody tr').length;

		for(var item=0;item < button_times;item++)
		{
			buttonInit(item,ele);
		}
	}
	else
	{
		var obj = $(ele+' tbody tr:eq('+indexValue+') .operator')

		//功能操作按钮
		obj.each(
			function(i)
			{
				switch(i)
				{
					//向上排序
					case 0:
					{
						$(this).click(
							function()
							{
								var insertIndex = $(this).parent().parent().prev().index();
								if(insertIndex >= 0)
								{
									$(ele+' tbody tr:eq('+insertIndex+')').before($(this).parent().parent());
								}
							}
						)
					}
					break;

					//向上排序
					case 1:
					{
						$(this).click(
							function()
							{
								var insertIndex = $(this).parent().parent().next().index();
								$(ele+' tbody tr:eq('+insertIndex+')').after($(this).parent().parent());
							}
						)
					}
					break;

					//删除排序
					case 2:
					{
						$(this).click(
							function()
							{
								var obj = $(this);
								art.dialog.confirm('确定要删除么？',function(){obj.parent().parent().remove()});
							}
						)
					}
					break;
				}
			}
		)
	}
}
</script>