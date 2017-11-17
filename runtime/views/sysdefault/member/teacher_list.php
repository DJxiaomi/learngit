<?php $menuData=menu::init($this->admin['role_id']);?>
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
			<?php $adminId = $this->admin['admin_id']?>
			<?php $query = new IQuery("quick_naviga");$query->where = "admin_id = $adminId and is_del = 0";$items = $query->find(); foreach($items as $key => $item){?>
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
						<li><a href="<?php echo IUrl::creatUrl("".$leftKey."");?>"><?php echo isset($leftValue)?$leftValue:"";?></a></li>
						<?php }?>
					</ul>
				</li>
				<?php }?>
			</ul>
			<div id="copyright"></div>
		</div>

		<div id="admin_right">
			<style>
.list_table a {
	color: #f7740f;
}
</style>
<div class="headbar">
	<div class="position">
		<span>会员</span><span>></span><span>学校管理</span><span>></span><span>教师列表</span>
	</div>
	<div class="operating">
		<div class="search f_r">
			<form name="searchseller" action="<?php echo IUrl::creatUrl("/");?>" method="get">
				<input type='hidden' name='controller' value='member' />
				<input type='hidden' name='action' value='teacher_list' />
				<select class="auto" name="search[like]">
					<option value="name">教师名称</option>
				</select>
				<input class="small" name="search[likeValue]" type="text" value="" />
				<button class="btn" type="submit"><span class="sch">搜 索</span></button>
			</form>
		</div>
		<a href="javascript:void(0);"><button class="operating_btn" type="button" onclick="window.location='<?php echo IUrl::creatUrl("/member/teacher_edit");?>'"><span class="addition">添加教师</span></button></a>
	</div>
</div>

<form action="<?php echo IUrl::creatUrl("/member/teacher_del");?>" method="post" name="teacher_list" onsubmit="return checkboxCheck('id[]','尚未选中任何记录！')">
	<div class="content">
		<table class="list_table">
			<colgroup>
				<col width="20px" />
        <col width="40px" />
				<col width="140px" />
				<col width="140px" />
        <col width="140px" />
        <col width="100px" />
				<col width="100px" />
				<col width="110px" />
				<col width="110px" />
				<col width="70px" />
				<col width="80px" />
			</colgroup>

			<thead>
				<tr>
          <th></th>
					<th>选择</th>
					<th>头像</th>
					<th>教师名称</th>
					<th>性别</th>
					<th>电话</th>
					<th>出生日期</th>
          <th>所属学校</th>
					<th>毕业学校</th>
					<th>学习专业</th>
					<th>操作</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($teacher_list_info['result'] as $key => $item){?>
				<tr>
          <td></td>
					<td><input name="id[]" type="checkbox" value="<?php echo isset($item['id'])?$item['id']:"";?>" /></td>
					<td><?php if($item['icon']){?><img src="<?php echo IUrl::creatUrl("")."".$item['icon']."";?>" width="60" height="60"/><?php }else{?>暂无<?php }?></td>
					<td title="<?php echo isset($item['name'])?$item['name']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></td>
					<td><?php echo get_sex( $item['sex'] ); ?></td>
					<td><?php if($item['mobile']){?><?php echo isset($item['mobile'])?$item['mobile']:"";?><?php }else{?>暂无<?php }?></td>
					<td><?php if($item['birth_date']){?><?php echo date('Y-m-d', $item['birth_date'] ); ?><?php }else{?>暂无<?php }?></td>
					<td><a href="<?php echo IUrl::creatUrl("/school/home/id/".$item['seller_id']."");?>" target="_blank"><?php echo isset($item['true_name'])?$item['true_name']:"";?></a></td>
					<td><?php if($item['graduate']){?><?php echo isset($item['graduate'])?$item['graduate']:"";?><?php }else{?>暂无<?php }?></td>
					<td><?php if($item['major']){?><?php echo isset($item['major'])?$item['major']:"";?><?php }else{?>暂无<?php }?></td>
					<td>
						<a href="<?php echo IUrl::creatUrl("/member/teacher_edit/id/".$item['id']."");?>"><img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_edit.gif";?>" alt="修改" /></a>
						<a href="javascript:void(0)" onclick="delModel({link:'<?php echo IUrl::creatUrl("/member/teacher_del/id/".$item['id']."");?>'})"><img class="operator" src="<?php echo $this->getWebSkinPath()."images/admin/icon_del.gif";?>" alt="删除" /></a>
					</td>
				</tr>
				<?php }?>
        <?php if( !$teacher_list_info['result']){?>
        <tr>
            <td colspan="11" style="text-align: center;">暂时没有任何教师信息</td>
        </tr>
        <?php }?>

        <?php if($teacher_list_info['page_count'] > 1){?>
				<tr>
						<td colspan="11"><?php echo isset($teacher_list_info['page_info'])?$teacher_list_info['page_info']:"";?></td>
				</tr>
        <?php }?>
			</tbody>
		</table>
	</div>

</form>

<script language="javascript">
//预加载
$(function(){
	var searchData = <?php echo JSON::encode($search);?>;
	for(var index in searchData)
	{
		$('[name="search['+index+']"]').val(searchData[index]);
	}
})

//商户状态修改
function changeStatus(sid,obj)
{
	var lockVal = obj.value;
	$.getJSON("<?php echo IUrl::creatUrl("/member/ajax_seller_lock");?>",{"id":sid,"lock":lockVal});
}

//返利账户管理入口
function fanli_add()
{
	if(!checkboxCheck('id[]','请选择要进行返利账户操作的用户！'))
	{
		return;
	}

	art.dialog.open("<?php echo IUrl::creatUrl("/member/member_balance");?>",{
	    title: '返利账户管理',
	    ok:function(iframeWin, topWin)
	    {
	    	var formObject = iframeWin.document.forms['balanceForm'];
	    	formObject.onsubmit();
	    	if($(formObject).find('.invalid-text').length > 0)
	    	{
	    		return false;
	    	}

	    	//进行post提交
	    	var postData = $('[name="seller_list"]').serialize()+'&'+$(formObject).serialize();
	    	$.post('<?php echo IUrl::creatUrl("/member/member_caozuo");?>',postData,function(json){
	    		if(json.flag == 'success')
	    		{
	    			tips('操作成功');
	    			window.location.reload();
	    			return false;
	    		} else {
	    			alert(json.message);
	    			return false;
	    		}

	    	},'json');
		}
	});
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
