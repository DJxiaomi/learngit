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
			<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/editor/kindeditor-min.js"></script><script type="text/javascript">window.KindEditor.options.uploadJson = "/pic/upload_json";window.KindEditor.options.fileManagerJson = "/pic/file_manager_json";</script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<div class="headbar">
	<div class="position"><span>系统</span><span>></span><span>网站管理</span><span>></span><span>站点设置</span></div>
</div>
<div class="content_box">

	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/market/brand_chit_zuhe_save");?>"  method="post" enctype='multipart/form-data' name='base_conf'>
			<table class="form_table">
				<col width="150px" />
				<col />
				<tr>
					<th>短期课自选折扣比例：</th>
					<td><input type='text' class='normal' name='commission' pattern='int' value="<?php echo $this->commission;?>" alt='短期课自选折扣比例不正确' /><label>* 百分比</label></td>
				</tr>
				<tr>
					<th></th>
					<td>
						<button class="submit" type='submit'><span>保存设置</span></button>
					</td>
				</tr>
			</table>
		</form>

	</div>
</div>

<script type='text/javascript'>
//DOM加载完毕
$(function(){
	//默认系统定义
	select_tab("<?php echo isset($this->confRow['form_index'])?$this->confRow['form_index']:"";?>");
	show_mail(1);

	//生成导航
	<?php $query = new IQuery("guide");$guideList = $query->find(); foreach($guideList as $key => $item){?><?php }?>
	<?php if($guideList){?>
	var guideList = <?php echo JSON::encode($guideList);?>;
	for(var index in guideList)
	{
		add_guide(guideList[index]);
	}
	<?php }else{?>
		add_guide();
	<?php }?>

	//生成幻灯片
	<?php if(isset($this->confRow['index_slide']) && $this->confRow['index_slide'] && $slide = unserialize($this->confRow['index_slide'])){?>
	var slideList = <?php echo JSON::encode($slide);?>;
	for(var index in slideList)
	{
		add_slide(slideList[index]);
	}
	<?php }else{?>
		add_slide();
	<?php }?>

	//全部表单自动填入值
	var formNameArray = ['base_conf','other_conf','mail_conf','system_conf'];
	for(var index in formNameArray)
	{
		var formObject = new Form(formNameArray[index]);
		formObject.init(<?php echo JSON::encode($this->confRow);?>);
	}

	//装载编辑器
	KindEditor.ready(function(K){
		K.create('#site_footer_code',{"filterMode":false});
	});
});

//测试邮件发送
function test_mail(obj)
{
	$('form[name="mail_conf"] input:text').each(function(){
		$(this).trigger('change');
	});

	if($('form[name="mail_conf"] input:text.invalid-text').length > 0)
	{
		return;
	}

	//按钮控制
	obj.disabled = true;
	$('#testmail').html('正在测试发送请稍后...');

	var ajaxUrl = '<?php echo IUrl::creatUrl("/system/test_sendmail/@random@");?>';
	ajaxUrl     = ajaxUrl.replace('@random@',Math.random());

	$.getJSON(ajaxUrl,$('form[name="mail_conf"]').serialize(),function(content){
		obj.disabled = false;
		$('#testmail').html('测试邮件发送');
		alert(content.message);
	});
}

//添加导航
function add_guide(data)
{
	var data = data ? data : {};
	var guideTrHtml = template.render('guideTrTemplate',data);
	$('#guide_box tbody').append(guideTrHtml);
	var last_index = $('#guide_box tbody tr').size()-1;
	buttonInit(last_index);
}

//增加幻灯片
function add_slide(data)
{
	var data = data ? data : {};
	var slideTrHtml = template.render('slideTrTemplate',data);
	$('#slide_box tbody').append(slideTrHtml);
	var last_index = $('#slide_box tbody tr').size()-1;
	buttonInit(last_index,'#slide_box');
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

//清理缓存
function clearCache()
{
	loadding('请稍候，系统正在清理缓存文件...');
	jQuery.get('<?php echo IUrl::creatUrl("/system/clearCache");?>',function(content)
	{
		unloadding();
		var content = $.trim(content);
		if(content == 1)
			art.dialog.tips('清理成功！', 1.5);
		else
			art.dialog.tips('清理失败！', 1.5);
	});
}

//滑动门
function select_tab(indexVal)
{
	//设置默认值
	if(indexVal == '')
	{
		indexVal = 'base_conf';
	}

	var formObj  = $('form[name="'+indexVal+'"]');
	var li_index = $('form').index(formObj);

	//切换form
	$('form').hide();
	$('form:eq('+li_index+')').show();

	//切换li
	$('ul[name="conf_menu"] li').attr('class','');
	$('ul[name="conf_menu"] li:eq('+li_index+')').attr('class','selected');
}

//切换邮箱设置
function show_mail(checkedVal)
{
	if(checkedVal==1)
		$('table tr[name="smtp"] *').show();
	else
		$('table tr[name="smtp"] *').hide();
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
