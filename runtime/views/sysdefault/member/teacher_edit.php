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
			<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/editor/kindeditor-min.js"></script><script type="text/javascript">window.KindEditor.options.uploadJson = "/pic/upload_json";window.KindEditor.options.fileManagerJson = "/pic/file_manager_json";</script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<script type='text/javascript' src='<?php echo $this->getWebViewPath()."javascript/artTemplate/area_select.js";?>'></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QDA0aO9Dw8tVx22vuULQuGXOGFV5a5ZD"></script>
<style>
.hide { display: none; }
input.normal, select.normal { height: 30px; }
.form_table { width: 60%; }
#allmap { width: 700px; height: 400px; }
</style>

<div class="headbar">
	<div class="position"><span>会员</span><span>></span><span>教师管理</span><span>></span><span>编辑教师</span></div>
</div>

<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/member/teacher_save");?>" method="post" name="teacherForm" enctype='multipart/form-data'>
			<input name="id" value="" type="hidden" />

			<table class="form_table">
				<colgroup>
					<col width="150px" />
					<col />
				</colgroup>

				<tbody>
          <tr>
            <th>所属学校：</td>
            <td>
                <select name="seller_id" class="normal" pattern="required" alt="请选择所属学校">
                  <option value="">请选择所属学校</option>
                  <?php foreach($seller_list as $key => $item){?>
                    <option value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($teacher_info['seller_id'] == $item['id']){?>selected<?php }?>><?php echo isset($item['true_name'])?$item['true_name']:"";?></option>
                  <?php }?>
                </select>
            </td>
          </tr>
					<tr>
						<th>教师姓名：</th>
						<td><input class="normal" name="name" type="text" pattern="required" alt="请输入教师姓名" value="<?php echo isset($teacher_info['name'])?$teacher_info['name']:"";?>" /><label>* 教师名称（必填）</label></td>
					</tr>
          
          <tr>
              <th>性别：</th>
              <td><input type="radio" name="sex" value="1" id="sex_1" <?php if(!$teacher_info || $teacher_info['sex'] != 2){?>checked<?php }?> /><label for="sex_1">男</label>&nbsp; &nbsp; <input type="radio" name="sex" value="2" id="sex_2" <?php if($teacher_info['sex'] == 2){?>checked<?php }?> /><label for="sex_2">女</label></td>
          </tr>
					<tr>
						<th>手机号码：</th>
						<td><input type="text" class="normal" name="mobile" pattern="mobi" empty alt="请输入正确的手机号码" value="<?php echo isset($teacher_info['mobile'])?$teacher_info['mobile']:"";?>" /></td>
					</tr>
          <!-- <tr>
            <th>出生年月：</td>
            <td><input type="text" class="normal" name="birth_date" pattern="date" empty alt="请选择出生年月" onFocus="WdatePicker()" value="<?php echo isset($teacher_info['birth_date'])?$teacher_info['birth_date']:"";?>" /></td>
          </tr> -->
          <tr>
            <th>Logo：</th>
            <td>
							<input type='file' name='icon' />
							<?php if(isset($teacher_info['icon']) && $teacher_info['icon']){?>
							<p><a target="_blank" href="<?php echo IUrl::creatUrl("")."";?><?php echo isset($teacher_info['icon'])?$teacher_info['icon']:"";?>"><img src='<?php echo IUrl::creatUrl("")."";?><?php echo isset($teacher_info['icon'])?$teacher_info['icon']:"";?>' style='width:100px;border:1px solid #ccc' /></a></p>
							<?php }?>
						</td>
          </tr>
          <tr>
            <th>毕业院校：</th>
            <td><input type="text" class="normal" name="graduate" value="<?php echo isset($teacher_info['graduate'])?$teacher_info['graduate']:"";?>" /></td>
          </tr>
          <tr>
            <th>学习专业：</th>
            <td><input type="text" class="normal" name="major" value="<?php echo isset($teacher_info['major'])?$teacher_info['major']:"";?>" /></td>
          </tr>
          <!-- <tr>
            <th>授课方向：</th>
            <td><input type="text" class="normal" name="teaching_direction" value="<?php echo isset($teacher_info['teaching_direction'])?$teacher_info['teaching_direction']:"";?>" /></td>
          </tr>
          <tr class="hide">
            <th>教学经历：</td>
            <td>
                <textarea name="teaching_experience" id="teaching_experience" style="width:600px;height:300px;"><?php echo isset($teacher_info['teaching_experience'])?$teacher_info['teaching_experience']:"";?></textarea>
            </td>
          </tr> -->
          <tr>
            <th>教师介绍：</td>
            <td>
                <textarea name="description" id="description" style="width:600px;height:300px;"><?php echo isset($teacher_info['description'])?$teacher_info['description']:"";?></textarea>
            </td>
          </tr>
          <!-- <tr>
            <th>获奖荣誉：</td>
            <td>
                <textarea name="awards" id="awards" style="width:600px;height:300px;"><?php echo isset($teacher_info['awards'])?$teacher_info['awards']:"";?></textarea>
            </td>
          </tr> -->
					<tr>
						<td></td>
						<td>
              <input type="hidden" name="id" value="<?php echo isset($teacher_info['id'])?$teacher_info['id']:"";?>" />
							<button class="submit" type="submit" ><span>确 定</span></button>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>

<script language="javascript">
//DOM加载完毕
$(function(){
	//初始化地域联动
	//template.compile("areaTemplate",areaTemplate);

	//编辑器载入
	/*KindEditor.ready(function(K){
		K.create('#teaching_experience');
    K.create('#description');
    K.create('#awards');
	});*/

});

/**
 * 生成地域js联动下拉框
 * @param name
 * @param parent_id
 * @param select_id
 */
function createAreaSelect(name,parent_id,select_id)
{
	//生成地区
	$.getJSON("<?php echo IUrl::creatUrl("/block/area_child");?>",{"aid":parent_id,"random":Math.random()},function(json)
	{
		$('[name="'+name+'"]').html(template.render('areaTemplate',{"select_id":select_id,"data":json}));
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
