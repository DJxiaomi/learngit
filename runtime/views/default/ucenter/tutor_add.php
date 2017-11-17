<?php 
	$myCartObj  = new Cart();
	$myCartInfo = $myCartObj->getMyCart();
	$siteConfig = new Config("site_config");
	$callback   = IReq::get('callback') ? urlencode(IFilter::act(IReq::get('callback'),'url')) : '';
	$navigation_list = navigation_class::get_navigation_list(1,0);
	$navigation_list2 = navigation_class::get_navigation_list(2,0);
	$user_id = $this->user['user_id'];
	$member_info = member_class::get_member_info($user_id);
	$user_info = user_class::get_user_info($user_id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php if($seo_data['title'] != ''){?><?php echo $seo_data['title'];?><?php }else{?><?php echo $siteConfig->index_seo_title;?><?php }?></title>
	<meta name="Keywords" content="<?php if($seo_data['keywords'] != ''){?><?php echo $seo_data['keywords'];?><?php }else{?><?php echo $siteConfig->index_seo_keywords;?><?php }?>" >
	<meta name="description" content="<?php if($seo_data['description'] !=''){?><?php echo $seo_data['description'];?><?php }else{?><?php echo $siteConfig->index_seo_description;?><?php }?>" />
	<meta property="qc:admins" content="246176725764545451116375" />
	<link type="image/x-icon" href="favicon.ico" rel="icon">


	<?php if(!$this->index){?>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/aero.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<?php }?>
	<script type='text/javascript' src='<?php echo $this->getWebViewPath()."skin/default/school/js/jquery.min.js";?>'></script>
	<script type='text/javascript' src='<?php echo $this->getWebViewPath()."javascript/layer/layer.js";?>'></script>
	<script type='text/javascript' src='<?php echo $this->getWebViewPath()."javascript/site.js";?>'></script>
	<script type='text/javascript' src='<?php echo $this->getWebViewPath()."javascript/jquery_lazyload/jquery.lazyload.js";?>'></script>
	<link href="<?php echo $this->getWebSkinPath()."css/font-awesome.min.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/common.css";?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getWebSkinPath()."css/sited.css";?>" rel="stylesheet" type="text/css" />
</head>
<style>

</style>
<body class="index">

	<!-- 工具条 S -->
	 <div class="toolbar">
		<a href="#"><div class="top-btn"><i></i></div></a>
		<ul>
        	<a href="tencent://message/?Menu=yes&amp;uin=2821518520&amp;Service=58&amp;SigT=A7F6FEA02730C9881B11E0AE7AF2E2413E3090997F5951E7CFC7F66A8EF4F5D7A3233F568A8EBC2B984019AC21FF99093F241FB5CD7A7DD4C39596B28D63C849FBCF4A5AED55184EFE696F36F9FF6428EEC729D42EF963C0FD5E9BAC2AD18620E7ADFC9387D83C4B46A7B0C2DC4B63341934EE44C822C196"><li><div class="qq"><i></i></div></li></a>
            <li><div class="wechat-icon"><i></i></div><span class="phone-box"><i class="wechat-erweima"></i><p>微信公众号</p></span></li>
            <a href="<?php echo IUrl::creatUrl("/ucenter/index");?>"><li><div class="tel"><i></i></div><span class="normal tel_span"><p>0731-28308258</p></span></li></a>
			<a href="<?php echo IUrl::creatUrl("/ucenter/index");?>"><li><div class="yonghu"><i></i></div><span class="normal user_span"><p class="user">个人信息</p></span></li></a>
			<a href="<?php echo IUrl::creatUrl("/simple/cart");?>" ><li><div class="shopcar"><i></i></div><span class="normal"><p>课程表</p></span></li></a>
			<li><div class="phone-icon"><i></i></div><span class="phone-box"><i class="phone-erweima"></i><p class="phone">手机APP</p></span></li>

		</ul>

	 </div>
	 <!-- 工具条 E -->
      
	 <!-- fixed topbar start -->
	 <div class="TopBar fixtopbar">
		 <div class="Wrap">

				 <div class="fr head-right">
						<?php if($this->user){?>
							您好<a href="<?php echo IUrl::creatUrl("/ucenter/index");?>"><?php echo $this->user['username'];?></a>，欢迎来到<?php echo $siteConfig->name;?>！[<a href="<?php echo IUrl::creatUrl("/simple/logout");?>" class="reg red">退出</a>]
						<?php }else{?>
							<a href="<?php echo IUrl::creatUrl("ucenter/index");?>" >你好，请登录</a>
							<a href="<?php echo IUrl::creatUrl("simple/reg?callback=".$callback."");?>" >免费注册</a>
						<?php }?>

				<?php if($navigation_list){?>
					<?php foreach($navigation_list as $key => $item){?>
						<?php if($item['type'] == 1){?>
							<a href="<?php echo IUrl::creatUrl("".$item['link']."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a>
						<?php }elseif($item['type'] == 2){?>
							<a class="place-on navigation_menu" href="javascript:void(0);"><?php echo isset($item['name'])?$item['name']:"";?><i class="arrow-icon"></i></a>
							<?php if($item['child']){?>
								<ul class="navigation_child nav_module_<?php echo isset($key)?$key:"";?>">
									<?php foreach($item['child'] as $key => $val){?>
										<li><a class=" " href="<?php echo IUrl::creatUrl("".$val['link']."");?>"><?php echo isset($val['name'])?$val['name']:"";?></a></li>
									<?php }?>
								</ul>
							<?php }?>
						<?php }else{?>
							<a class="navigation_menu sjlx-on" href="javascript:void(0);"><i class="phone-icon"></i><?php echo isset($item['name'])?$item['name']:"";?><i class="arrow-icon"></i></a>
							<ul class="navigation_child sjlx">
								<li>
									<div class="erweima">
										<a href="javascript:void(0);">
											<img src="<?php echo $this->getWebSkinPath()."images/erweima.png";?>" data="<?php echo $this->getWebSkinPath()."images/erweima.png";?>" />
										</a>
									</div>
								</li>
							</ul>
						<?php }?>
					<?php }?>
				<?php }?>
				</div>
			<div class="clear"></div>
		</div>
	 </div>
	 <!-- fixed topbar end -->

	<!-- Header S -->
	<div class="Header ">
		 <!-- TopBar -->
		 <div class="TopBar">

		 </div>
		 <!-- TopBox -->
		 <div class="TopBox Wrap">
				 <!-- logo -->
				 <a class="logo fl" href="<?php echo IUrl::creatUrl("site");?>" title="乐享生活"></a>
				 <!-- search -->
				 <div class="search fl">
						<div class="searchTool">
								<form method='get' action='<?php echo IUrl::creatUrl("site/search_list");?>' id="form_keyword">
										<input type='hidden' name='controller' value='site' />
										<input type='hidden' name='action' value='pro_list' />
										<input class="txtSearch" type="text" name='word' autocomplete="off" placeholder="课程名称" <?php if($word){?>value="<?php echo isset($word)?$word:"";?>"<?php }?> />
										 <div class="btnSearch">
												<input class="lbl" type="button" value="搜索" onclick="checkInput('word','课程名称...');" />
										 </div>
										 <div class="clear"></div>
								 </form>
						</div>
						<div class="clear"></div>
				 </div>
				 <!-- signlan -->
				 <div class="sign fr">
					 <a class="shopping-car" href="<?php echo IUrl::creatUrl("/simple/cart");?>">
						 <i class="shopping-icon"></i>课程清单(<span name="mycart_count"><?php echo isset($myCartInfo['count'])?$myCartInfo['count']:"";?></span>)<i class="arrow-icon-right"></i>
					 </a>
				 </div>
				 <div class="clear"></div>
		 </div>
		 <!-- Nav -->
		 <div class="Nav">
			 <div class="Nav_left"></div>
				<div class="mainNav Wrap">
					 <ul class="nav_menu">
					 			<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '')){?>
						 		 <li  id="first_all" class="nav_menu-item first-child"><span>全部分类</span><div >ALL CATEGORIES</div>
					<div class="all_cate">
                     <?php foreach(Api::run('getCategoryListTop') as $k => $first){?>
	                    <div class="Title1 part01">                     
							<div class="title_menu">
							<a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$first['id']."");?>" ><?php echo isset($first['name'])?$first['name']:"";?></a>
							</div>
						 <div class="secnod_menu" >
							<ul >				<?php foreach(Api::run('getCategoryByParentid',array('#parent_id#',$first['id'])) as $key => $second){?>
							  
								<li ><a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$second['id']."");?>"><?php echo isset($second['name'])?$second['name']:"";?></a></li>
								<?php }?>
								
							</ul>
			              </div>
                            </div>						  
						 <?php }?>
						 </div>
								 </li>
								     
								 <?php }else{?>
								 <li   class="nav_menu-item first-child"><a href="javascript:void(0);">全部分类<div>ALL CATEGORIES</div></a>
						
								 
								 
								 
								 </li>
						 		 <?php }?>
								 <?php foreach(Api::run('getGuideList') as $kk => $item){?>
								 
								 	<?php  $i = 0;?>
								 	<li class="nav_menu-item <?php if(!$kk){?>sec-child<?php }?>"><a href="<?php echo IUrl::creatUrl("".$item['link']."");?>"><?php echo isset($item['name'])?$item['name']:"";?><div><?php if(!$kk){?>HOME PAGE<?php }elseif($kk == 1){?>FREE CLASS<?php }elseif($kk==2){?>COUPONS<?php }elseif($kk == 3){?>PREFERENTIAL<?php }elseif($kk == 4){?>ORGANIZATION<?php }elseif($kk == 5){?>INDIVIDUAL<?php }elseif($kk==6){?>TUTORING<?php }else{?>INFORMATION<?php }?></div></a></li>
									<?php  $i++;?>
								 <?php }?>
								 <div class="clear"></div>
					 </ul>
				</div>
				<div class="Nav_right"></div>
				     
				          
		 </div>
		 <script>
		 $(document).ready(function(){
		  $("#first_all").mouseover(function(){
			$(".all_cate").css("display","block");
		  });
		 $(".all_cate").mouseout(function(){
			$(".all_cate").css("display","none");
		  });
       });
</script>
	
		 <script type="text/javascript">
				function set_navigation()
				{
					var left = ($(window).width() - 1200)/2;
					$('.Nav_left').css('width', left);
					$('.Nav_right').css('width', left);
				}
				window.onresize = set_navigation;
				$(document).ready(function(){
					set_navigation();
				});
		 </script>
	</div>
	<!-- Header E -->

	<!-- 内容 S -->
	<?php if($this->getId() != 'ucenter'){?>
	<div class="<?php if( ($this->getId() == 'site' && $_GET['action'] == 'index') || ($this->getId() == 'site' && $_GET['action'] == '') || ($this->getId() == 'site' && $_GET['action'] == 'intro')){?>module_content_index<?php }else{?>module_content<?php }?>">
		<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/editor/kindeditor-min.js"></script><script type="text/javascript">window.KindEditor.options.uploadJson = "/pic/upload_json";window.KindEditor.options.fileManagerJson = "/pic/file_manager_json";</script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<link href="<?php echo $this->getWebSkinPath()."css/ucenter_article_add.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebSkinPath()."css/ucenter_tutor.css";?>" rel="stylesheet" type="text/css" />

<script language="javascript">
var _tutor_cate_list = <?php if($tutor_cate_list_json){?><?php echo isset($tutor_cate_list_json)?$tutor_cate_list_json:"";?><?php }else{?>new Array()<?php }?>;
</script>

<form name="form1" method="post" action="<?php echo IUrl::creatUrl("/ucenter/tutor_update");?>">
<div class="main f_r">
    <div class="uc_title m_10">
        <label class="current"><span><?php if($id){?>修改<?php }else{?>发表<?php }?>家教需求信息</span></label>
    </div>

    <div class="box m_10">
        <table class="list_table" width="100%" cellpadding="0" cellspacing="0">

          <tr>
            <td class="tt">性别：</td>
            <td>
              <input type="radio" name="gender" value="1" checked id="gender_1" /><label for="gender_1">男</label>
              <input type="radio" name="gender" value="2" id="gender_2" <?php if($tutor_info['gender'] == 2){?>checked<?php }?> /><label for="gender_2">女</label>
            </td>
          </tr>

          <tr>
            <td class="tt">年龄：</td>
            <td><input name="age" type="text" pattern='int' empty alt='请输入年龄' class="normal small" value="<?php echo isset($tutor_info['age'])?$tutor_info['age']:"";?>" />岁</td>
          </tr>

          <tr>
            <td class="tt">年级：</td>
            <td>
              <select name="grade_level" class="grade_level" pattern="required" alt="请选择年级">
                <option value="">请选择分类</option>
                <?php foreach($tutor_cate_list as $key => $item){?>
                  <option value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($tutor_info['grade_level'] == $item['id']){?>selected<?php }?>><?php echo isset($item['name'])?$item['name']:"";?></option>
                <?php }?>
              </select>
              <select name="grade" class="grade" pattern="required" alt="请选择分类">
                <?php foreach($tutor_cate_list as $key => $item){?>
                  <?php if($item['id'] == $tutor_info['grade_level']){?>
                    <?php foreach($item['child'] as $key => $it){?>
                      <option value="<?php echo isset($it['id'])?$it['id']:"";?>" <?php if($tutor_info['grade'] == $it['id']){?>selected<?php }?>><?php echo isset($it['name'])?$it['name']:"";?></option>
                    <?php }?>
                  <?php }?>
                <?php }?>
              </select>
              <select name="category_id[]" class="cate_id">
										<?php foreach($tutor_cate_list as $key => $item){?>
											<?php if($item['id'] == $tutor_info['grade_level']){?>
												<?php foreach($item['child'] as $key => $it){?>
													<?php if($it['id'] == $tutor_info['grade']){?>
														<?php foreach($it['child'] as $key => $i){?>
															<option value="<?php echo isset($i['id'])?$i['id']:"";?>" <?php if($tutor_info['category_id'] == $i['id']){?>selected<?php }?>><?php echo isset($i['name'])?$i['name']:"";?></option>
														<?php }?>
													<?php }?>
												<?php }?>
											<?php }?>
										<?php }?>
							</select>
              <select name="category_id2[]" class="cate_id2">
                <?php foreach($tutor_cate_list as $key => $item){?>
                  <?php if($item['id'] == $tutor_info['grade_level']){?>
                    <?php foreach($item['child'] as $key => $it){?>
                      <?php if($it['id'] == $tutor_info['grade']){?>
                        <?php foreach($it['child'] as $key => $i){?>
                            <?php if($i['id'] == $tutor_info['category_id']){?>
                              <?php foreach($i['child'] as $key => $t){?>
                                <option value="<?php echo isset($t['id'])?$t['id']:"";?>" <?php if($tutor_info['category_id2'] == $t['id']){?>selected<?php }?>><?php echo isset($t['name'])?$t['name']:"";?></option>
                              <?php }?>
                            <?php }?>
                        <?php }?>
                      <?php }?>
                    <?php }?>
                  <?php }?>
                <?php }?>
              </select>
            </td>
          </tr>

          <tr>
            <td class="tt">现考试成绩：</td>
            <td><input name="lastest_scores" type="text" pattern='float' empty alt='请输入现考试成绩' class="normal small" value="<?php echo isset($tutor_info['lastest_scores'])?$tutor_info['lastest_scores']:"";?>" /></td>
          </tr>
          <tr>
            <td class="tt">愿支付的基本报酬：</td>
            <td><input name="lowest_reward" type="text" pattern='float' alt='请输入愿支付的基本报酬' class="normal small" value="<?php echo isset($tutor_info['lowest_reward'])?$tutor_info['lowest_reward']:"";?>" /> 元/课时</td>
          </tr>
          <tr>
            <td class="tt">期望的成绩：</td>
            <td><input name="expected_scores" type="text" pattern='float' empty alt='请输入期望的成绩' class="normal small" value="<?php echo isset($tutor_info['expected_scores'])?$tutor_info['expected_scores']:"";?>" /></td>
          </tr>
          <tr>
            <td class="tt">达到期望目标的报酬：</td>
            <td><input name="highest_reward" type="text" pattern='float' empty alt='请输入最高报酬' class="normal small" value="<?php echo isset($tutor_info['highest_reward'])?$tutor_info['highest_reward']:"";?>" /> 元/课时</td>
          </tr>
          <tr>
            <td class="tt">预计补课的课时数：</td>
            <td>
              <input name="expected_hours" type="text" pattern='int' alt='请输入预计补课的课时' class="normal small" value="<?php echo isset($tutor_info['expected_hours'])?$tutor_info['expected_hours']:"";?>" /> 时
            </td>
          </tr>

          <tr>
            <td class="tt">计划补课的时间：</td>
            <td><a href="javascript:void(0);" class="add_teaching_time">增加一行</a><br /></td>
          </tr>

          <tr>
            <td></td>
            <td>
              <table border="0" class="add_teaching_time_td">
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
            </td>
          </tr>

          <tr>
            <td class="tt">是否提供交通费用：</td>
            <td>
              <input type="radio" name="is_provide_transportation_fee" value="1" checked id="transportation_fee_1" /><label for="transportation_fee_1">是</label>
              <input type="radio" name="is_provide_transportation_fee" value="0" <?php if($tutor_info['is_provide_transportation_fee'] == 0){?>checked<?php }?> id="transportation_fee_0" /><label for="transportation_fee_0">否</label>
            </td>
          </tr>

          <tr>
            <td class="tt">是否提供就餐：</td>
            <td>
              <input type="radio" name="is_provide_repast" value="1" checked id="is_provide_repast_1" /><label for="is_provide_repast_1">是</label>
              <input type="radio" name="is_provide_repast" value="0" <?php if($tutor_info['is_provide_repast'] == 0){?>checked<?php }?> id="is_provide_repast_0" /><label for="is_provide_repast_0">否</label>
            </td>
          </tr>

          <tr>
            <td class="tt">补课地址：</td>
            <td>
                <select name="region_id" pattern="required">
                  <?php foreach($region_list as $key => $item){?>
                    <option value="<?php echo isset($item['area_id'])?$item['area_id']:"";?>" <?php if($tutor_info['region_id'] == $item['area_id']){?>selected<?php }?>><?php echo isset($item['area_name'])?$item['area_name']:"";?></option>
                  <?php }?>
                </select>
                <input type="text" name="address" value="<?php echo isset($tutor_info['address'])?$tutor_info['address']:"";?>" class="normal big" />
            </td>
          </tr>

          <tr>
            <td class="tt"><b style="color:red">奖励机制</b>：</td>
            <td>
              <a href="javascript:void(0);" class="add_test">增加一行</a>
            </td>
          </tr>

          <tr>
            <td class="tt"></td>
            <td class="test_table">
              <table border="0" class="test_row">
                    <tr>
                        <th width="106">关键考试时间</th>
                        <th width="110">关键考试类型</th>
                        <th width="128">关键考试的分数</th>
                        <th width="118">关键考试的奖金</th>
                        <th width="67"></th>
                    </tr>
              </table>
              <?php foreach($tutor_info['test_reward'] as $key => $item){?>
              <table border="0" class="test_row">
                    <tr>
                        <td><input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="test_time[]" class="normal small" value="<?php echo isset($item['test_time'])?$item['test_time']:"";?>"/></td>
                        <td><input type="text" name="test_type[]" class="normal small" value="<?php echo isset($item['test_type'])?$item['test_type']:"";?>" /></td>
                        <td><input type="text" name="test_condition[]" class="normal small" value="<?php echo isset($item['test_condition'])?$item['test_condition']:"";?>" />分</td>
                        <td><input type="text" name="test_money[]" class="normal small" value="<?php echo isset($item['test_money'])?$item['test_money']:"";?>" />元</td>
                        <td><a href="javascript:void(0);" class="del_test">删除</a></td>
                    </tr>
              </table>
              <?php }?>
              <?php if(!$tutor_info['test_reward']){?>
              <table border="0" class="test_row">
                    <tr>
                        <td><input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="test_time[]" class="normal small"/></td>
                        <td><input type="text" name="test_type[]" class="normal small"/></td>
                        <td><input type="text" name="test_condition[]" class="normal small" />分</td>
                        <td><input type="text" name="test_money[]" class="normal small"/>元</td>
                        <td><a href="javascript:void(0);" class="del_test">删除</a></td>
                    </tr>
              </table>
              <?php }?>
            </td>
          </tr>

          <tr>
            <td></td>
            <td>
              <?php if($id){?><input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>"  /><?php }?>
              <label class="btn"><input type="submit" value=" 保 存 " class="save_btn"></label>&nbsp; &nbsp;
              <label class="btn"><input type="reset" value=" 重 置 "></label>
            </td>
          </tr>

        </table>
    </div>
</div>
</form>

<div class="add_test_html" style="display:none;">
  <table border="0" class="test_row">
      <tr>
          <td><input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="test_time[]" class="normal small"/></td>
          <td><input type="text" name="test_type[]" class="normal small"/></td>
          <td><input type="text" name="test_condition[]" class="normal small" />分</td>
          <td><input type="text" name="test_money[]" class="normal small"/>元</td>
          <td><a href="javascript:void(0);" class="del_test">删除</a></td>
      </tr>
  </table>
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

<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/ucenter_article_add.js";?>"></script>

<script language="javascript">
$(document).ready(function(){
  $(document).on('change', '.grade_level',function(){
    set_category($(this),$(this).val());
  });
  $(document).on('change','.grade',function(){
    var _grade_level = $(this).parent().parent().find(".grade_level").val();
    set_category($(this), _grade_level, $(this).val());
  });
  $(document).on('change','.cate_id',function(){
    var _grade_level = $(this).parent().parent().find(".grade_level").val();
    var _grade = $(this).parent().parent().find(".grade").val();
    set_category($(this), _grade_level, _grade, $(this).val());
  })

  $('.add_teaching_time').click(function(){
		var _html = $('.add_teaching_time_html').html();
		$('.add_teaching_time_td').append(_html);
	})

  $(document).on('click', '.del_teaching_time', function(){
    $(this).parent().parent().remove();
  })

  <?php if(!$tutor_info['teaching_time']){?>
    $('.add_teaching_time').click();
  <?php }?>

  $('.add_test').click(function(){
    var _html = $('.add_test_html').html();
    $('.test_table').html( $('.test_table').html() + _html );
  });

  $(document).on('click', '.del_test', function(){
    $(this).parent().parent().parent().parent().remove();
  });
})

function set_category(obj, grade_level, grade, cate_id, cate_id2)
{
	var _grade_html = "<option value=''>请选择年级</option>";
	var _cate_id_html = "<option value=''>请选择课程</option>";
	var _cate_id2_html = "<option value=''>请选择课程</option>";
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

									if ( _tutor_cate_list[i]['child'][j]['child'][k]['id']  == cate_id && _tutor_cate_list[i]['child'][j]['child'][k]['child'] )
									{
										for ( var m in _tutor_cate_list[i]['child'][j]['child'][k]['child'] )
										{
											var _selected = (cate_id2 && _tutor_cate_list[i]['child'][j]['child'][k]['child'][m]['id'] == cate_id2 ) ? 'selected' : '';
											_cate_id2_html += "<option value='" + _tutor_cate_list[i]['child'][j]['child'][k]['child'][m]['id'] + "' " + _selected + ">"  + _tutor_cate_list[i]['child'][j]['child'][k]['child'][m]['name'] + "</option>";
										}
										obj.parent().find('.cate_id2').html(_cate_id2_html);
										obj.parent().find('.cate_id2').show();
									}
								}
								obj.parent().find('.cate_id').html(_cate_id_html);
								obj.parent().find('.cate_id').show();
							}
						}
						obj.parent().find(".grade").html(_grade_html);
						obj.parent().find(".grade").show();
				}
			}
	}
}
</script>

<style>
<?php if(!$id){?>
.grade, .cate_id, .cate_id2 {display:none;}
<?php }else{?>
  <?php if(!$tutor_info['category_id2']){?>
    .cate_id2 {display:none;}
  <?php }?>
  <?php if(!$tutor_info['category_id']){?>
    .cate_id {display:none;}
  <?php }?>
  <?php if(!$tutor_info['grade']){?>
    .grade {display:none;}
  <?php }?>
<?php }?>
</style>

	</div>
	<?php }else{?>
	<div class="module_content">
			<div class="ucenter container">
			<div class="position">
				您当前的位置： <a href="<?php echo IUrl::creatUrl("");?>">首页</a> » <a href="<?php echo IUrl::creatUrl("/ucenter/index");?>">我的账户</a>
			</div>
			<div class="wrapper clearfix">
				<div class="sidebar f_l">

					<div class="box">
						<div class="title"><h2 class='bg5'>个人中心</h2></div>
						<div class="cont">
							<ul class="list">
								<!-- <li><a href="<?php echo IUrl::creatUrl("/ucenter/address");?>">地址管理</a></li> -->
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/info");?>"><i class="icon-user"></i>个人信息</a></li>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/favorite");?>"><i class="icon-star"></i>收藏夹</a></li>
							</ul>
						</div>
					</div>

					<div class="box">
						<div class="title"><h2>财务中心</h2></div>
						<div class="cont">
							<ul class="list">
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/account_log");?>"><i class="icon-bookmark"></i>我的账户</a></li>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/redpacket");?>"><i class="icon-book"></i>我的代金券</a></li>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/order");?>"><i class="icon-shopping-cart"></i>我的订单</a></li>
							</ul>
						</div>
					</div>

					<div class="box">
						<div class="title"><h2>应用中心</h2></div>
						<div class="cont">
							<ul class="list">
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/order_transfer_list");?>"><i class="icon-share-alt"></i>我的转让</a></li>
								<?php if($user_info['is_equity'] == 1){?>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/equity");?>" class="bt-none"><i class="icon-money"></i>我的股权信息</a></li>
								<?php }?>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/tutor_list");?>" class="bt-none"><i class="icon-file"></i>我的家教</a></li>
								<?php if($member_info['group_id'] == 2){?>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/booking_list");?>" class="bt-none"><i class="icon-file"></i>我的预定表</a></li>
								<?php }?>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/promote");?>" class="bt-none"><i class="icon-group"></i>我的推广</a></li>
							</ul>
						</div>
					</div>

					<div class="box">
						<div class="title"><h2 class='bg2'>服务中心</h2></div>
						<div class="cont">
							<ul class="list">
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/complain");?>"><i class="icon-comment-alt"></i>站点建议</a></li>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/consult");?>"><i class="icon-comment"></i>报名咨询</a></li>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/evaluation");?>"><i class="icon-edit"></i>课后评价</a></li>
							</ul>
						</div>
					</div>

					<div class="box">
						<div class="title"><h2 class='bg3'>资讯</h2></div>
						<div class="cont">
							<ul class="list">
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/message");?>"><i class="icon-envelope"></i>短信息</a></li>
								<li ><a href="<?php echo IUrl::creatUrl("/ucenter/tuiguang");?>"><i class="icon-group"></i>推广人</a></li>
								<li><a href="<?php echo IUrl::creatUrl("/ucenter/article_list");?>" class="bt-none"><i class="icon-file"></i>我的文章</a></li>
							</ul>
						</div>
					</div>
				</div>
				<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/editor/kindeditor-min.js"></script><script type="text/javascript">window.KindEditor.options.uploadJson = "/pic/upload_json";window.KindEditor.options.fileManagerJson = "/pic/file_manager_json";</script>
<script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/my97date/wdatepicker.js"></script>
<link href="<?php echo $this->getWebSkinPath()."css/ucenter_article_add.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->getWebSkinPath()."css/ucenter_tutor.css";?>" rel="stylesheet" type="text/css" />

<script language="javascript">
var _tutor_cate_list = <?php if($tutor_cate_list_json){?><?php echo isset($tutor_cate_list_json)?$tutor_cate_list_json:"";?><?php }else{?>new Array()<?php }?>;
</script>

<form name="form1" method="post" action="<?php echo IUrl::creatUrl("/ucenter/tutor_update");?>">
<div class="main f_r">
    <div class="uc_title m_10">
        <label class="current"><span><?php if($id){?>修改<?php }else{?>发表<?php }?>家教需求信息</span></label>
    </div>

    <div class="box m_10">
        <table class="list_table" width="100%" cellpadding="0" cellspacing="0">

          <tr>
            <td class="tt">性别：</td>
            <td>
              <input type="radio" name="gender" value="1" checked id="gender_1" /><label for="gender_1">男</label>
              <input type="radio" name="gender" value="2" id="gender_2" <?php if($tutor_info['gender'] == 2){?>checked<?php }?> /><label for="gender_2">女</label>
            </td>
          </tr>

          <tr>
            <td class="tt">年龄：</td>
            <td><input name="age" type="text" pattern='int' empty alt='请输入年龄' class="normal small" value="<?php echo isset($tutor_info['age'])?$tutor_info['age']:"";?>" />岁</td>
          </tr>

          <tr>
            <td class="tt">年级：</td>
            <td>
              <select name="grade_level" class="grade_level" pattern="required" alt="请选择年级">
                <option value="">请选择分类</option>
                <?php foreach($tutor_cate_list as $key => $item){?>
                  <option value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($tutor_info['grade_level'] == $item['id']){?>selected<?php }?>><?php echo isset($item['name'])?$item['name']:"";?></option>
                <?php }?>
              </select>
              <select name="grade" class="grade" pattern="required" alt="请选择分类">
                <?php foreach($tutor_cate_list as $key => $item){?>
                  <?php if($item['id'] == $tutor_info['grade_level']){?>
                    <?php foreach($item['child'] as $key => $it){?>
                      <option value="<?php echo isset($it['id'])?$it['id']:"";?>" <?php if($tutor_info['grade'] == $it['id']){?>selected<?php }?>><?php echo isset($it['name'])?$it['name']:"";?></option>
                    <?php }?>
                  <?php }?>
                <?php }?>
              </select>
              <select name="category_id[]" class="cate_id">
										<?php foreach($tutor_cate_list as $key => $item){?>
											<?php if($item['id'] == $tutor_info['grade_level']){?>
												<?php foreach($item['child'] as $key => $it){?>
													<?php if($it['id'] == $tutor_info['grade']){?>
														<?php foreach($it['child'] as $key => $i){?>
															<option value="<?php echo isset($i['id'])?$i['id']:"";?>" <?php if($tutor_info['category_id'] == $i['id']){?>selected<?php }?>><?php echo isset($i['name'])?$i['name']:"";?></option>
														<?php }?>
													<?php }?>
												<?php }?>
											<?php }?>
										<?php }?>
							</select>
              <select name="category_id2[]" class="cate_id2">
                <?php foreach($tutor_cate_list as $key => $item){?>
                  <?php if($item['id'] == $tutor_info['grade_level']){?>
                    <?php foreach($item['child'] as $key => $it){?>
                      <?php if($it['id'] == $tutor_info['grade']){?>
                        <?php foreach($it['child'] as $key => $i){?>
                            <?php if($i['id'] == $tutor_info['category_id']){?>
                              <?php foreach($i['child'] as $key => $t){?>
                                <option value="<?php echo isset($t['id'])?$t['id']:"";?>" <?php if($tutor_info['category_id2'] == $t['id']){?>selected<?php }?>><?php echo isset($t['name'])?$t['name']:"";?></option>
                              <?php }?>
                            <?php }?>
                        <?php }?>
                      <?php }?>
                    <?php }?>
                  <?php }?>
                <?php }?>
              </select>
            </td>
          </tr>

          <tr>
            <td class="tt">现考试成绩：</td>
            <td><input name="lastest_scores" type="text" pattern='float' empty alt='请输入现考试成绩' class="normal small" value="<?php echo isset($tutor_info['lastest_scores'])?$tutor_info['lastest_scores']:"";?>" /></td>
          </tr>
          <tr>
            <td class="tt">愿支付的基本报酬：</td>
            <td><input name="lowest_reward" type="text" pattern='float' alt='请输入愿支付的基本报酬' class="normal small" value="<?php echo isset($tutor_info['lowest_reward'])?$tutor_info['lowest_reward']:"";?>" /> 元/课时</td>
          </tr>
          <tr>
            <td class="tt">期望的成绩：</td>
            <td><input name="expected_scores" type="text" pattern='float' empty alt='请输入期望的成绩' class="normal small" value="<?php echo isset($tutor_info['expected_scores'])?$tutor_info['expected_scores']:"";?>" /></td>
          </tr>
          <tr>
            <td class="tt">达到期望目标的报酬：</td>
            <td><input name="highest_reward" type="text" pattern='float' empty alt='请输入最高报酬' class="normal small" value="<?php echo isset($tutor_info['highest_reward'])?$tutor_info['highest_reward']:"";?>" /> 元/课时</td>
          </tr>
          <tr>
            <td class="tt">预计补课的课时数：</td>
            <td>
              <input name="expected_hours" type="text" pattern='int' alt='请输入预计补课的课时' class="normal small" value="<?php echo isset($tutor_info['expected_hours'])?$tutor_info['expected_hours']:"";?>" /> 时
            </td>
          </tr>

          <tr>
            <td class="tt">计划补课的时间：</td>
            <td><a href="javascript:void(0);" class="add_teaching_time">增加一行</a><br /></td>
          </tr>

          <tr>
            <td></td>
            <td>
              <table border="0" class="add_teaching_time_td">
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
            </td>
          </tr>

          <tr>
            <td class="tt">是否提供交通费用：</td>
            <td>
              <input type="radio" name="is_provide_transportation_fee" value="1" checked id="transportation_fee_1" /><label for="transportation_fee_1">是</label>
              <input type="radio" name="is_provide_transportation_fee" value="0" <?php if($tutor_info['is_provide_transportation_fee'] == 0){?>checked<?php }?> id="transportation_fee_0" /><label for="transportation_fee_0">否</label>
            </td>
          </tr>

          <tr>
            <td class="tt">是否提供就餐：</td>
            <td>
              <input type="radio" name="is_provide_repast" value="1" checked id="is_provide_repast_1" /><label for="is_provide_repast_1">是</label>
              <input type="radio" name="is_provide_repast" value="0" <?php if($tutor_info['is_provide_repast'] == 0){?>checked<?php }?> id="is_provide_repast_0" /><label for="is_provide_repast_0">否</label>
            </td>
          </tr>

          <tr>
            <td class="tt">补课地址：</td>
            <td>
                <select name="region_id" pattern="required">
                  <?php foreach($region_list as $key => $item){?>
                    <option value="<?php echo isset($item['area_id'])?$item['area_id']:"";?>" <?php if($tutor_info['region_id'] == $item['area_id']){?>selected<?php }?>><?php echo isset($item['area_name'])?$item['area_name']:"";?></option>
                  <?php }?>
                </select>
                <input type="text" name="address" value="<?php echo isset($tutor_info['address'])?$tutor_info['address']:"";?>" class="normal big" />
            </td>
          </tr>

          <tr>
            <td class="tt"><b style="color:red">奖励机制</b>：</td>
            <td>
              <a href="javascript:void(0);" class="add_test">增加一行</a>
            </td>
          </tr>

          <tr>
            <td class="tt"></td>
            <td class="test_table">
              <table border="0" class="test_row">
                    <tr>
                        <th width="106">关键考试时间</th>
                        <th width="110">关键考试类型</th>
                        <th width="128">关键考试的分数</th>
                        <th width="118">关键考试的奖金</th>
                        <th width="67"></th>
                    </tr>
              </table>
              <?php foreach($tutor_info['test_reward'] as $key => $item){?>
              <table border="0" class="test_row">
                    <tr>
                        <td><input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="test_time[]" class="normal small" value="<?php echo isset($item['test_time'])?$item['test_time']:"";?>"/></td>
                        <td><input type="text" name="test_type[]" class="normal small" value="<?php echo isset($item['test_type'])?$item['test_type']:"";?>" /></td>
                        <td><input type="text" name="test_condition[]" class="normal small" value="<?php echo isset($item['test_condition'])?$item['test_condition']:"";?>" />分</td>
                        <td><input type="text" name="test_money[]" class="normal small" value="<?php echo isset($item['test_money'])?$item['test_money']:"";?>" />元</td>
                        <td><a href="javascript:void(0);" class="del_test">删除</a></td>
                    </tr>
              </table>
              <?php }?>
              <?php if(!$tutor_info['test_reward']){?>
              <table border="0" class="test_row">
                    <tr>
                        <td><input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="test_time[]" class="normal small"/></td>
                        <td><input type="text" name="test_type[]" class="normal small"/></td>
                        <td><input type="text" name="test_condition[]" class="normal small" />分</td>
                        <td><input type="text" name="test_money[]" class="normal small"/>元</td>
                        <td><a href="javascript:void(0);" class="del_test">删除</a></td>
                    </tr>
              </table>
              <?php }?>
            </td>
          </tr>

          <tr>
            <td></td>
            <td>
              <?php if($id){?><input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>"  /><?php }?>
              <label class="btn"><input type="submit" value=" 保 存 " class="save_btn"></label>&nbsp; &nbsp;
              <label class="btn"><input type="reset" value=" 重 置 "></label>
            </td>
          </tr>

        </table>
    </div>
</div>
</form>

<div class="add_test_html" style="display:none;">
  <table border="0" class="test_row">
      <tr>
          <td><input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="test_time[]" class="normal small"/></td>
          <td><input type="text" name="test_type[]" class="normal small"/></td>
          <td><input type="text" name="test_condition[]" class="normal small" />分</td>
          <td><input type="text" name="test_money[]" class="normal small"/>元</td>
          <td><a href="javascript:void(0);" class="del_test">删除</a></td>
      </tr>
  </table>
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

<script type='text/javascript' src="<?php echo $this->getWebViewPath()."javascript/ucenter_article_add.js";?>"></script>

<script language="javascript">
$(document).ready(function(){
  $(document).on('change', '.grade_level',function(){
    set_category($(this),$(this).val());
  });
  $(document).on('change','.grade',function(){
    var _grade_level = $(this).parent().parent().find(".grade_level").val();
    set_category($(this), _grade_level, $(this).val());
  });
  $(document).on('change','.cate_id',function(){
    var _grade_level = $(this).parent().parent().find(".grade_level").val();
    var _grade = $(this).parent().parent().find(".grade").val();
    set_category($(this), _grade_level, _grade, $(this).val());
  })

  $('.add_teaching_time').click(function(){
		var _html = $('.add_teaching_time_html').html();
		$('.add_teaching_time_td').append(_html);
	})

  $(document).on('click', '.del_teaching_time', function(){
    $(this).parent().parent().remove();
  })

  <?php if(!$tutor_info['teaching_time']){?>
    $('.add_teaching_time').click();
  <?php }?>

  $('.add_test').click(function(){
    var _html = $('.add_test_html').html();
    $('.test_table').html( $('.test_table').html() + _html );
  });

  $(document).on('click', '.del_test', function(){
    $(this).parent().parent().parent().parent().remove();
  });
})

function set_category(obj, grade_level, grade, cate_id, cate_id2)
{
	var _grade_html = "<option value=''>请选择年级</option>";
	var _cate_id_html = "<option value=''>请选择课程</option>";
	var _cate_id2_html = "<option value=''>请选择课程</option>";
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

									if ( _tutor_cate_list[i]['child'][j]['child'][k]['id']  == cate_id && _tutor_cate_list[i]['child'][j]['child'][k]['child'] )
									{
										for ( var m in _tutor_cate_list[i]['child'][j]['child'][k]['child'] )
										{
											var _selected = (cate_id2 && _tutor_cate_list[i]['child'][j]['child'][k]['child'][m]['id'] == cate_id2 ) ? 'selected' : '';
											_cate_id2_html += "<option value='" + _tutor_cate_list[i]['child'][j]['child'][k]['child'][m]['id'] + "' " + _selected + ">"  + _tutor_cate_list[i]['child'][j]['child'][k]['child'][m]['name'] + "</option>";
										}
										obj.parent().find('.cate_id2').html(_cate_id2_html);
										obj.parent().find('.cate_id2').show();
									}
								}
								obj.parent().find('.cate_id').html(_cate_id_html);
								obj.parent().find('.cate_id').show();
							}
						}
						obj.parent().find(".grade").html(_grade_html);
						obj.parent().find(".grade").show();
				}
			}
	}
}
</script>

<style>
<?php if(!$id){?>
.grade, .cate_id, .cate_id2 {display:none;}
<?php }else{?>
  <?php if(!$tutor_info['category_id2']){?>
    .cate_id2 {display:none;}
  <?php }?>
  <?php if(!$tutor_info['category_id']){?>
    .cate_id {display:none;}
  <?php }?>
  <?php if(!$tutor_info['grade']){?>
    .grade {display:none;}
  <?php }?>
<?php }?>
</style>

			</div>
		</div>
	<?php }?>
	<!-- 内容 E -->



	<!-- Footer S -->
	<div class="footer">
		<div class="Wrap">
	    	<!--up -->
		    <div class="footer-left">
					<?php foreach($navigation_list2 as $key => $helpCat){?>
						<?php if($key < 4){?>
				    	<ul>
				    		<h3 class="foot-title"><?php echo isset($helpCat['name'])?$helpCat['name']:"";?></h3>
				    		<?php foreach($helpCat['child'] as $key => $item){?>
									<li><a href="<?php echo IUrl::creatUrl("".$item['link']."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></li>
								<?php }?>
				    	</ul>
						<?php }?>
		    	<?php }?>
		    </div>
				<div class="footer-center">
					<ul>
						<li class="tel">全国统一免费咨询热线</li>
						<li class="tel_bg"></li>
						<li class="addr">地址：中心广场大汉希尔顿1栋2601</li>
					</ul>
				</div>
				<div class="footer-right">
					<ul>
						<li>
							第三课APP<br /><img class="lazy" data-original="<?php echo $this->getWebSkinPath()."images/qrcode_1.png";?>"/>
						</li>
						<li>
							第三课微信公众号<br /><img class="lazy" data-original="<?php echo $this->getWebSkinPath()."images/qrcode_2.png";?>" />
						</li>
					</ul>
				</div>
		    <div class="clear"></div>
		    <!-- copyright -->
		    <div class="copyright">
		        <div class="Wrap">
					<div class="tubbiao">
	<!-- <a href="http://webscan.360.cn/index/checkwebsite/url/www.dsanke.com"><img border="0" src="http://img.webscan.360.cn/status/pai/hash/a1f20bc445d31538899515dd5b5ff053"/></a> -->
  <a href="http://webscan.360.cn/index/checkwebsite/url/www.lelele999.com"><img src="<?php echo $this->getWebSkinPath()."images/t013365a715435676e8.jpg";?>"/></a>
		 </div>
		            <p clas="footP1">Powered by 第三课</p>
		            <p class="footP1">Copyright©2014-2017&nbsp;<a class="copyys" target="_blank" href="http://www.miibeian.gov.cn/">湘ICP备15005945号-1</a> &nbsp;版权所有</p>
		        </div>
		    </div>
	    </div>
	</div>
	<!-- Footer E -->

	<?php if($id == 851){?>
	<link rel="stylesheet" href="<?php echo $this->getWebSkinPath()."css/form.css";?>" />
	<script>var pid = <?php echo isset($id)?$id:"";?>;</script>
	<script language="javascript" src="<?php echo $this->getWebSkinPath()."scripts/form.js";?>"></script>
	<?php }?>
	<!-- 图片懒加载 -->



	<?php if($this->getId() == 'ucenter'){?>

	<script type='text/javascript'>
	//DOM加载完毕后运行
	$(function()
	{
		$(".tabs").each(function(i){
		    var parrent = $(this);
			$('.tabs_menu .node',this).each(function(j){
				var current=".node:eq("+j+")";
				$(this).bind('click',function(event){
					$('.tabs_menu .node',parrent).removeClass('current');
					$(this).addClass('current');
					$('.tabs_content>.node',parrent).css('display','none');
					$('.tabs_content>.node:eq('+j+')',parrent).css('display','block');
				});
			});
		});

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

		menu_current();

		/**
		$('input:text[name="word"]').bind({
			keyup:function(){autoComplete('<?php echo IUrl::creatUrl("/site/autoComplete");?>','<?php echo IUrl::creatUrl("/site/pro_list/word/@word@");?>','<?php echo $siteConfig->auto_finish;?>');}
		});
		**/

		<?php $word = IReq::get('word') ? IFilter::act(IReq::get('word'),'text') : '教育机构或课程名称...'?>
		//$('input:text[name="word"]').val("<?php echo isset($word)?$word:"";?>");

		//课程表div层
		$('.mycart').hover(
			function(){
				showCart('<?php echo IUrl::creatUrl("/simple/showCart");?>');
			},
			function(){
				$('#div_mycart').hide('slow');
			}
		);

		//二维码
		$('.erweima a').click(function(){
			var _data = $(this).find("img").attr('data');
			layer.open({
				type: 1,
				skin: 'layui-layer-demo', //样式类名
				closeBtn: 0, //不显示关闭按钮
				shadeClose: true, //开启遮罩关闭
				content: '<img src="' + _data + '" />'
			});
		})

		$('.navigation_menu').each(function(){ 
			var _parent_width = $(this).parent().width();
			var _left = $(this).position().left;
			var _width = $(this).width();
			$(this).next('.navigation_child').css('right', _parent_width - _left - _width - 16);
		})
	});
	</script>
	<?php }?>

	<?php if($this->getId() == 'ucenter'){?>
		<style>
		.module_content {width: 1200px; margin: 0px auto;}
		</style>
	<?php }?>
	   <script type="text/javascript" charset="utf-8">

 $(function(){
      $("img.lazy").lazyload({effect: "fadeIn"});
  });
</script>
</body>
</html>
