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
		<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/editor/kindeditor-min.js"></script><script type="text/javascript">window.KindEditor.options.uploadJson = "/pic/upload_json";window.KindEditor.options.fileManagerJson = "/pic/file_manager_json";</script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jqueryFileUpload/jquery.ui.widget.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jqueryFileUpload/jquery.iframe-transport.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jqueryFileUpload/jquery.fileupload.js"></script>
<?php $seller_id = $this->seller['seller_id']?>
<style>
.list_table a {
	color: #f7740f;
}
</style>
<article class="module width_full">
	<header>
		<h3 class="tabs_involved">教师列表</h3>
	</header>

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
		<a href="javascript:void(0);"><button class="operating_btn" type="button" onclick="window.location='<?php echo IUrl::creatUrl("/seller/teacher_edit");?>'"><span class="addition">添加教师</span></button></a>


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
				<?php if(isset($teacher_list_info['result'])){?>
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
						<a href="<?php echo IUrl::creatUrl("/seller/teacher_edit/id/".$item['id']."");?>"><img class="operator" src="<?php echo $this->getWebSkinPath()."images/main/icn_edit.png";?>" alt="修改" /></a>
						<a href="javascript:void(0)" onclick="delModel({link:'<?php echo IUrl::creatUrl("/seller/teacher_del/id/".$item['id']."");?>'})"><img class="operator" src="<?php echo $this->getWebSkinPath()."images/main/icn_del.png";?>" alt="删除" /></a>
					</td>
				</tr>
				<?php }?>
		<?php }else{?>
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