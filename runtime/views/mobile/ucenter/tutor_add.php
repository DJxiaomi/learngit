<?php
	$member_info = member_class::get_member_info($this->user['user_id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $this->_siteConfig->name;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link type="image/x-icon" href="<?php echo IUrl::creatUrl("")."favicon.ico";?>" rel="icon">
	<link href="<?php echo IUrl::creatUrl("")."resource/css/font-awesome.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/jquery-3.1.1.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."resource/scripts/common.js";?>"></script>
	<script type="text/javascript">mui.init({swipeBack:true});var SITE_URL = '<?php echo IUrl::creatUrl("");?>';</script>
</head>
<body>
	<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '')){?>
	<?php }else{?>
	<header class="mui-bar mui-bar-nav">
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <?php if($isctrl){?>
	    <a href="<?php echo IUrl::creatUrl("".$isctrl['url']."");?>" class="mui-btn mui-btn-white mui-btn-link mui-pull-right"><?php echo isset($isctrl['text'])?$isctrl['text']:"";?></a>
	    <?php }?>
	    <h1 class="mui-title"><?php echo mb_substr($this->title,0,16,'utf-8');?></h1>
	</header>
	<?php }?>
	<div class="mui-content">
	<link rel="stylesheet" href="<?php echo $this->getWebViewPath()."javascript/mui/css/mui.picker.min.css";?>">
<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.picker.min.js";?>"></script>
<link href="<?php echo $this->getWebSkinPath()."css/ucenter.css";?>" rel="stylesheet" type="text/css" />
<style>
input[type=radio] {margin-top: 13px;}
.add_teaching_time_td {background-color: #f4f4f4;}
.add_teaching_time_td, .add_teaching_time_td select {color: #666;font-size: 90%;}
.add_teaching_time_td select {width: auto;border:1px solid #666; line-height: 30px;text-align: center;}
.add_teaching_time_td td {padding-left: 15%; height: 25px;line-height: 25px;}
.add_teaching_time {font-size: 90%; height: 30px; line-height: 30px;}
</style>

<script language="javascript">
var _tutor_cate_list = <?php if($tutor_cate_list_json){?><?php echo isset($tutor_cate_list_json)?$tutor_cate_list_json:"";?><?php }else{?>new Array()<?php }?>;
</script>

<h5 class="mui-content-padded">发布家教信息</h5>
<div class="mui-content-padded" style="margin:0;">
	<form class="mui-input-group" action="<?php echo IUrl::creatUrl("/ucenter/tutor_update");?>" method="post" enctype='multipart/form-data'>

    <div class="mui-input-row">
      <label>性别</label>
      <input type="radio" name="gender" value="1" id="gender_1" style="float: none;width:auto;" checked/>
      <label style="width: auto;float: none;padding: 0">男</label>&nbsp; &nbsp;
      <input type="radio" name="gender" value="0" id="gender_0" style="float: none;width:auto;" <?php if($tutor_info['gender'] == 0){?>checked<?php }?>/>
      <label style="width: auto;float: none;padding: 0">女</label>
    </div>

		<div class="mui-input-row">
			<label>年龄</label>
			<input type="text" name="age" value="<?php echo isset($tutor_info['age'])?$tutor_info['age']:"";?>" placeholder="请输入年龄" />岁
		</div>

    <div class="mui-input-row mui-input-row-grade">
      <label>年级</label>
			<select name="grade_level" class="grade_level" pattern="required" alt="请选择年级">
				<option value="">请选择分类</option>
				<?php foreach($tutor_cate_list as $key => $item){?>
					<option value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($tutor_info['grade_level'] == $item['id']){?>selected<?php }?>><?php echo isset($item['name'])?$item['name']:"";?></option>
				<?php }?>
			</select>
    </div>
		<div class="mui-input-row mui-input-row-category">
			<label>分类</label>
			<select name="grade" class="grade" pattern="required" alt="请选择分类">
				<?php foreach($tutor_cate_list as $key => $item){?>
					<?php if($item['id'] == $tutor_info['grade_level']){?>
						<?php foreach($item['child'] as $key => $it){?>
							<option value="<?php echo isset($it['id'])?$it['id']:"";?>" <?php if($tutor_info['grade'] == $it['id']){?>selected<?php }?>><?php echo isset($it['name'])?$it['name']:"";?></option>
						<?php }?>
					<?php }?>
				<?php }?>
			</select>
		</div>

    <div class="mui-input-row">
      <label>最近一次考分</label>
      <input type="text" name="lastest_scores" value="<?php echo isset($tutor_info['lastest_scores'])?$tutor_info['lastest_scores']:"";?>" placeholder="请输入最近一次考分" />
    </div>

		<div class="mui-input-row">
			<label>期望的考分</label>
			<input type="text" name="expected_scores" value="<?php echo isset($tutor_info['expected_scores'])?$tutor_info['expected_scores']:"";?>" placeholder="请输入期望的考分" />
		</div>

    <div class="mui-input-row">
      <label>支付的最低报酬</label>
      <input type="text" name="lowest_reward" value="<?php echo isset($tutor_info['lowest_reward'])?$tutor_info['lowest_reward']:"";?>" placeholder="支付的最低报酬" />
    </div>

    <div class="mui-input-row">
      <label>支付的最高报酬</label>
      <input type="text" name="highest_reward" value="<?php echo isset($tutor_info['highest_reward'])?$tutor_info['highest_reward']:"";?>" placeholder="支付的最低报酬" />
    </div>

    <div class="mui-input-row">
      <label>预计补课的课时</label>
      <input name="expected_hours" type="text" value="<?php echo isset($tutor_info['expected_hours'])?$tutor_info['expected_hours']:"";?>" />
    </div>

    <div class="mui-input-row">
      <label>接受补课的时间</label>
			<a href="javascript:void(0);" class="add_teaching_time">增加一行</a>
    </div>

		<div class="mui-input-row" style="height: auto;">
			<table border="0" class="add_teaching_time_td" width="96%">
				<?php foreach($tutor_info['teaching_time'] as $key => $it){?>
				<tr>
					<td>
						<select name="time1[]">
							<?php foreach($teaching_time_arr as $key => $item){?>
								<option value="<?php echo isset($key)?$key:"";?>" <?php if($it['time1'] == $key){?>selected<?php }?>><?php echo isset($item)?$item:"";?></option>
							<?php }?>
						</select>

						从<select name="time2[]">
							<?php foreach($teaching_time_arr3 as $key => $item){?>
								<option value="<?php echo isset($key)?$key:"";?>" <?php if($it['time2'] == $key){?>selected<?php }?>><?php echo isset($item)?$item:"";?></option>
							<?php }?>
						</select>点至
						<select name="time3[]">
							<?php foreach($teaching_time_arr3 as $key => $item){?>
								<option value="<?php echo isset($key)?$key:"";?>" <?php if($it['time3'] == $key){?>selected<?php }?>><?php echo isset($item)?$item:"";?></option>
							<?php }?>
						</select>点
						&nbsp; <a href="javascript:void(0);" class="del_teaching_time">删除</a>
					</td>
				</tr>
				<?php }?>
			</table>
		</div>

    <div class="mui-input-row">
      <label>是否提供交通费</label>
      <input type="radio" name="is_provide_transportation_fee" value="1" style="float: none;width:auto;" checked />
      <label style="width: auto;float: none;padding: 0">是</label>&nbsp; &nbsp;
      <input type="radio" name="is_provide_transportation_fee" value="0" style="float: none;width:auto;" <?php if($tutor_info['is_provide_transportation_fee'] == 0){?>checked<?php }?>/>
      <label style="width: auto;float: none;padding: 0">否</label>
    </div>

    <div class="mui-input-row">
      <label>是否提供就餐</label>
      <input type="radio" name="is_provide_repast" value="1" style="float: none;width:auto;" checked />
      <label style="width: auto;float: none;padding: 0">是</label>&nbsp; &nbsp;
      <input type="radio" name="is_provide_repast" value="0" style="float: none;width:auto;" <?php if($tutor_info['is_provide_repast'] == 0){?>checked<?php }?>/>
      <label style="width: auto;float: none;padding: 0">否</label>
    </div>

    <div class="mui-input-row mui-input-row-region">
      <label>补课区域</label>
      <input type="text" name="region_id_str" id="region_id_str" value="<?php echo isset($tutor_info['region_name'])?$tutor_info['region_name']:"";?>" />
    </div>

    <div class="mui-input-row">
      <label>详细地址</label>
      <input type="text" name="address" id="address" value="<?php echo isset($tutor_info['address'])?$tutor_info['address']:"";?>" />
    </div>

		<div class="mui-button-row">
		  <input type="hidden" name="id" value="<?php echo isset($tutor_info['id'])?$tutor_info['id']:"";?>" />
      <input type="hidden" name="expected_hours" id="expected_hours" value="<?php echo isset($tutor_info['expected_hours'])?$tutor_info['expected_hours']:"";?>" />
      <input type="hidden" name="region_id" id="region_id" value="<?php echo isset($tutor_info['region_id'])?$tutor_info['region_id']:"";?>" />
			<button type="submit" class="mui-btn mui-btn-primary"> 保 存 </button>
			<br /><br /><br />
		</div>

	</form>
</div>

<table class="add_teaching_time_html" style="display:none;">
	<tr>
		<td>
			<select name="time1[]">
				<?php foreach($teaching_time_arr as $key => $item){?>
					<option value="<?php echo isset($key)?$key:"";?>"><?php echo isset($item)?$item:"";?></option>
				<?php }?>
			</select>

			从<select name="time2[]">
				<?php foreach($teaching_time_arr3 as $key => $item){?>
					<option value="<?php echo isset($key)?$key:"";?>"><?php echo isset($item)?$item:"";?></option>
				<?php }?>
			</select>点至
			<select name="time3[]">
				<?php foreach($teaching_time_arr3 as $key => $item){?>
					<option value="<?php echo isset($key)?$key:"";?>"><?php echo isset($item)?$item:"";?></option>
				<?php }?>
			</select>点
			&nbsp; <a href="javascript:void(0);" class="del_teaching_time">删除</a>
		</td>
	</tr>
</table>

<script language="javascript">
mui('.mui-input-row-category').on('tap','input', function(e) {
  var picker = new mui.PopPicker();
  picker.setData(<?php echo isset($tutor_cate_list_json)?$tutor_cate_list_json:"";?>);
  picker.show(function(rs){
      $('#category_name').val(rs[0].text);
      $('#category_id').val(rs[0].value);
  });
});

// mui('.mui-input-row-grade_level').on('tap','input', function(e){
//   var picker = new mui.PopPicker();
//   picker.setData(<?php echo isset($grade_arr_json)?$grade_arr_json:"";?>);
//   picker.show(function(rs){
//       $('#grade_level_str').val(rs[0].text);
//       $('#grade_level').val(rs[0].value);
//   });
// });
//
// mui('.mui-input-row-grade').on('tap','input', function(e){
//   var picker = new mui.PopPicker();
//   picker.setData(<?php echo isset($grade_level_arr_json)?$grade_level_arr_json:"";?>);
//   picker.show(function(rs){
//       $('#grade_str').val(rs[0].text);
//       $('#grade').val(rs[0].value);
//   });
// });

mui('.mui-input-row-expected-hours').on('tap','input', function(e){
  var picker = new mui.PopPicker();
  picker.setData(<?php echo isset($teaching_time_json)?$teaching_time_json:"";?>);
  picker.show(function(rs){
      $('#expected_hours_str').val(rs[0].text);
      $('#expected_hours').val(rs[0].value);
  });
});

mui('.mui-input-row-region').on('tap','input', function(e){
  var picker = new mui.PopPicker();
  picker.setData(<?php echo isset($region_list_json)?$region_list_json:"";?>);
  picker.show(function(rs){
      $('#region_id_str').val(rs[0].text);
      $('#region_id').val(rs[0].value);
  });
});

$(document).ready(function(){
	$(document).on('change', '.grade_level',function(){
		set_category($(this),$(this).val());
	});

	$('.add_teaching_time').click(function(){
		var _html = $('.add_teaching_time_html').html();
		$('.add_teaching_time_td').append(_html);
	})

	$(document).on('click', '.del_teaching_time', function(){
		$(this).parent().parent().remove();
	})
})

function set_category(obj, grade_level, grade, cate_id)
{
	var _grade_html = '';
	var _cate_id_html = '';
	if ( obj && grade_level )
	{
			for( var i in _tutor_cate_list )
			{
				if ( _tutor_cate_list[i]['id'] == grade_level && _tutor_cate_list[i]['child'] )
				{
						for( var j in _tutor_cate_list[i]['child'] )
						{
							var _selected = (grade && _tutor_cate_list[i]['child'][j]['id'] == grade ) ? 'selected' : '';
							_grade_html += "<option value='" + _tutor_cate_list[i]['child'][j]['id'] + "' " + _selected + ">"  + _tutor_cate_list[i]['child'][j]['name'] + "</option>";

							if ( _tutor_cate_list[i]['child'][j]['id'] == grade && _tutor_cate_list[i]['child'][j]['child'])
							{
								for ( var k in _tutor_cate_list[i]['child'][j]['child'] )
								{
									var _selected = (cate_id && _tutor_cate_list[i]['child'][j]['child'][k]['id'] == cate_id ) ? 'selected' : '';
									_cate_id_html += "<option value='" + _tutor_cate_list[i]['child'][j]['child'][k]['id'] + "' " + _selected + ">"  + _tutor_cate_list[i]['child'][j]['child'][k]['name'] + "</option>";
								}

								obj.parent().find('.cate_id').html(_cate_id_html);
								obj.parent().find('.cate_id').show();
							}
						}

						$(".grade").html(_grade_html);
						$(".grade").show();
				}
			}
	}
}
</script>

	</div>
	<nav class="mui-bar mui-bar-tab">
	    <a class="mui-tab-item home <?php if($this->getId() == 'site' && ($_GET['action'] == 'index' || $_GET['action'] == '')){?>mui-hot-home<?php }?>" href="<?php echo IUrl::creatUrl("");?>">
	        <span class="mui-tab-label">首页</span>
	    </a>
	    <a class="mui-tab-item gift <?php if($this->getId() == 'site' && $_GET['action'] == 'chit1'){?>mui-hot-gift<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit1");?>" id="ztelBtn">
	        <span class="mui-tab-label">短期课</span>
	    </a>
	    <a class="mui-tab-item money <?php if($this->getId() == 'site' && $_GET['action'] == 'chit2'){?>mui-hot-money<?php }?>" href="<?php echo IUrl::creatUrl("/site/chit2");?>">
	        <span class="mui-tab-label">券</span>
	    </a>
	    <a class="mui-tab-item user <?php if($this->getId() == 'ucenter' || ($this->getId() == 'simple' && $_GET['action'] == 'login')){?>mui-hot-user<?php }?>" href="<?php echo IUrl::creatUrl("/simple/login");?>?callback=/ucenter" id="ltelBtn">
	        <span class="mui-tab-label">我的</span>
	    </a>
      <a class="mui-tab-item service" href="<?php echo IUrl::creatUrl("/site/service");?>" id="ltelBtn">
	        <span class="mui-tab-label">客服</span>
	    </a>
	</nav>
</body>
</html>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.lazyload.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->getWebViewPath()."javascript/mui/js/mui.lazyload.img.js";?>"></script>
<script type="text/javascript">
mui('body').on('tap', 'a', function(){
    if(this.href != '#' && this.href != ''){
        mui.openWindow({
            url: this.href
        });
    }
    this.click();
});

(function($) {
	$(document).imageLazyload({
		placeholder: '<?php echo $this->getWebSkinPath()."images/lazyload.jpg";?>'
	});
})(mui);
</script>
